<?php

namespace App\Services;

use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class OrdersService
{
    public function __construct()
    {

    }
    public function getParameters(string $database)
    {
        $parameters = DB::connection($database)->table('appparametros')->get();
        foreach ($parameters as $params) {
            if ($params->tempolimite === null) {
                $params->tempolimite = 30;
            }
        }
        return $parameters;
    }
    public function buscaPedidoSeparacao(int $codpedido, string $database)
    {
        $pedido = DB::connection($database)->table('itempedido')->join('produto', 'produto.codigo', '=', 'itempedido.codproduto')
            ->join('pedido', function ($join) use ($codpedido) {
                $join->on('pedido.codigo', '=', 'itempedido.codpedido')->where('itempedido.codpedido', '=', $codpedido);
            })
            ->orderByRaw("itempedido.codigo ASC")
            ->get();
        return $pedido;
    }
    public function buscaProximoPedido(int $codigoseparador, string $database)
    {
        $pedido = DB::
            connection($database)
            ->
        select(
            "SELECT
                separacaoitem.codseparacao as item_codseparacao,
                separacaoitem.codigo as item_codigo,
                separacaoitem.codproduto as item_codproduto,
                separacaoitem.quantidade as item_quantidade,
                separacaoitem.preco as item_preco,
                separacaoitem.localizacao as item_localizacao,
                produto.descricao as produto_descricao,
                produto.localizacao as produto_localizacao,
                produto.preco as produto_preco,
                produto.codigogtinean as produto_codigogtinean,
                produto.isbn as produto_isbn,
                produto.reffornecedor as produto_reffornecedor,
                separacao.codigo as separacao_codigo,
                separacao.data as separacao_emissao,
                separacao.qtdedocumentos as separacao_qtdedocumentos,
                separacao.qtdeitens as separacao_qtdeitens,
                separacao.qtdesoma as separacao_qtdesoma,
                terceiro.razao as terceiro_razao,
                terceiro.cnpj as terceirocnpj,
                tercforn.fantasia as tercforn_fantasia,
                separacao.codseparador as separacao_codseparacor,
                separacao.prioridade as separacao_prioridade,
                estoque.qtde as estoque_quantidade,
                estoque.reservado as estoque_reservado,
                separacaodocumento.tipo as documento_tipo,
                separacaodocumento.coddocumento as documento_codigo,
                tipofrete.codigo as transporte_codigo,
                tipofrete.descricao as transporte_descricao,
                tipofrete.cor as transporte_cor,
                case when coalesce(separacao.ignorardocumento,false) then 1 else 0 end as separacao_ignorardocumento,
                case when separacao.multidocumento then 'S' else 'N' end as multidocumento
                FROM separacao
                INNER JOIN separacaoitem on separacao.codigo = separacaoitem.codseparacao
                 left JOIN separacaodocumento on separacaoitem.codseparacaodocumento = separacaodocumento.codigoserial
                                  and separacaodocumento.codseparacao = separacaoitem.codseparacao
                 left join pedido on separacaodocumento.coddocumento = pedido.codigo
                 left join transportadora on pedido.codtransportadora = transportadora.codterceiro
                 left join tipofrete on tipofrete.codigo = pedido.codtipofrete
                inner join produto on produto.codigo = separacaoitem.codproduto
                inner join terceiro on terceiro.codigo = separacao.codterceiroprincipal
                inner join terceiro as tercforn on tercforn.codigo = produto.codfornecedor
                left join estoque on estoque.codproduto = separacaoitem.codproduto and estoque.codlocalestoque = separacao.codlocalestoque
                where separacao.codigo = (select separacao.codigo
                from separacao
                where separacao.status = 'E'
                and coalesce(separacao.codseparador,$codigoseparador) = $codigoseparador
                order by coalesce(separacao.codseparador,0) desc
                , coalesce(separacao.prioridade,9999999)
                , separacao.codigo
                limit 1)
                order by separacaoitem.codigo
                  "
        );
        return $pedido;
    }

    public function update(int $codigo, string $status, string $database)
    {
        // $separacao = DB::
        // connection($database)
        // ->table('separacao')
        // ->where('codigo','=',$codigo)->first();
        // dd($separacao);
        $separacao = DB::
            connection($database)
            ->table('separacao')
            ->where('codigo', '=', $codigo)->update(array('status' => $status));
        $response = 'Atualizado com sucesso';
        return $response;
    }
    public function updateConfirma(int $codigo, string $status, $codseparador, string $database)
    {
        // $separacao = DB::
        // connection($database)
        // ->table('separacao')
        // ->where("codigo","=",$codigo)
        // ->first();
        // dd($separacao);
        $separacao = DB::
            connection($database)
            ->table('separacao')
            ->where('codigo', '=', $codigo)->update([
            'status' => $status,
            'codseparador' => $codseparador,
        ]);
        // dd($separacao);
        $response = 'Atualizado com sucesso';
        return $response;
    }
    public function create($database, $emissao, $codigo, $nome)
    {
        $pedido = Pedido::on($database)->create([
            'emissao' => $emissao,
            'codigo' => $codigo,
            'nome' => $nome,
        ]);
        return $pedido;
    }
}
