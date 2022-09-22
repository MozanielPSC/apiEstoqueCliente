<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
    class ProductsService{
        public function __construct(){

        }
        

        public function getProductById(int $id){
            $product =  DB::connection('mysql2')->table('produto')->where('codigo','=',$id)->first();
            return $product;
        }

        
        public function getProductByDesc(string $code,string $database){
            $code = \strtoupper($code);
            $product =  DB::connection($database)->table('produto')
            ->join('parametros','parametros.codlocalestoquedefau','=','parametros.codlocalestoquedefau')
            ->leftJoin('estoque',function ($join){
                $join->on('estoque.codproduto','=','produto.codigo');
                $join->on('estoque.codlocalestoque','=','parametros.codlocalestoquedefau');
            })
            ->select(DB::raw("produto.codigo, produto.descricao, produto.preco, produto.codigogtinean, (coalesce(estoque.qtde,0) - coalesce(estoque.reservado,0)) as estoque"))
            ->where(DB::raw('UPPER(produto.descricao)'),'like','%'.$code.'%')
            ->orderByRaw("produto.descricao ASC")
            ->limit(50)
            //->paginate(50);
            ->get();
            return $product;
        }
        public function getProductByCode(int $code,string $database){
            
            $product =  DB::connection($database)->table('produto')
            ->join('parametros','parametros.codlocalestoquedefau','=','parametros.codlocalestoquedefau')
            ->leftJoin('estoque',function ($join){
                $join->on('estoque.codproduto','=','produto.codigo');
                $join->on('estoque.codlocalestoque','=','parametros.codlocalestoquedefau');
            })
            ->select(DB::raw("produto.codigo, produto.descricao, produto.preco, produto.codigogtinean, (coalesce(estoque.qtde,0) - coalesce(estoque.reservado,0)) as estoque"))
            ->where('produto.codigo','=',$code)
            ->orderByRaw("produto.descricao ASC")
            ->limit(50)
            //->paginate(50);
            ->get();
            
            return $product;
        }
        public function getProductByInt(string $codeint,string $database){
            $product =  DB::connection($database)->table('produto')
            ->join('parametros','parametros.codlocalestoquedefau','=','parametros.codlocalestoquedefau')
            ->leftJoin('estoque',function ($join){
                $join->on('estoque.codproduto','=','produto.codigo');
                $join->on('estoque.codlocalestoque','=','parametros.codlocalestoquedefau');
            })
            ->select(DB::raw("produto.codigo, produto.descricao, produto.preco, produto.codigogtinean, (coalesce(estoque.qtde,0) - coalesce(estoque.reservado,0)) as estoque"))
            ->where('produto.codigogtinean','=',$codeint)
            ->orderByRaw("produto.codigo ASC")
            ->limit(50)
            //->paginate(50);
            ->get();
            return $product;
        }
        

        public function cadastroProduto(){

        }
    }