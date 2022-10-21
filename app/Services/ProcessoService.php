<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProcessoService
{
    public function __construct()
    {

    }

    public function pegaCodigoAppRetornoProcesso(string $database)
    {
        $codigo = DB::
            connection($database)
            ->
        select('select PegaCodigoAppRetornoProcesso()');
        return $codigo[0]->pegacodigoappretornoprocesso;
    }

    public function insertAppRetorno(
        string $database,
        int $codigo,
        $tipoerp,
        $coderp,
        $finalizacao,
        $appcodfuncionario,
        $appinicioprocesso,
        $appfinalprocesso,
        $appsituacao,
        $appcodigo
    ) {
        DB::connection($database)->
            insert('
            insert into appretornoprocesso (
            codigo , status , tipoerp , coderp , finalizacao , appcodfuncionario ,
             appinicioprocesso , appfinalprocesso , appsituacao ,appcodigo)
            values (?,?,?,?,?,?,?,?,?,?)',
            [$codigo, 'E', $tipoerp, $coderp, $finalizacao,
                $appcodfuncionario, $appinicioprocesso, $appfinalprocesso, $appsituacao, $appcodigo]);

    }

    public function insertLoop(string $database, array $items, int $codigo)
    {
        foreach ($items as $item) {
            DB::connection($database)->
                insert('
                insert into appretornoprocessoitem
                ( codappretornoprocesso , sequencia , codproduto , quantidade , separado , conferido , falta ,preco,desconto,descricao_item,identificacao_documento,documentocodigo)
                values (?,?,?,?,?,?,?,?,?,?,?,?)',
                [$codigo, $item->sequencia, $item->codproduto, $item->quantidade, $item->separado, $item->conferido, $item->falta, $item->preco, $item->desconto, $item->descricao_item,$item->identificacao_documento,$item->documentocodigo]);
        }
    }

    public function update(string $database, int $codigo)
    {
        DB::connection($database)->table('appretornoprocesso')
            ->where('codigo', '=', $codigo)->update(array('status' => 'F'));
    }
    public function selectCoderp(string $database, int $codigo)
    {
        //teste
        $coderp = DB::connection($database)->table('appretornoprocesso')->
            select('coderp')->where([
            ['codigo', '=', $codigo],
            ['status', '=', 'F'],
        ])->get();
        return $coderp[0]->coderp;
    }
}
