<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Codigos;
use Exception;
    class CodigoService{
        public function __construct(){

        }
        public function showCodigos(string $idCnpj,string $database){
          $codigo =  DB::connection($database)->table('CODIGOS')
          ->join('terminal', 'terminal.chave', '=', 'CODIGOS.cod_chave_terminal')
          ->where('cod_id_cnpj','=', $idCnpj)
          ->get();
          return $codigo;
		}
        public function createCodigo(string $cod_id_cnpj,string $cod_chave_terminal,string $cod_identificador,string $cod_localizacao,string $cod_codigo,$cod_preco,$cod_quantidade,string $database){
            $codigo =  Codigos::on($database)->create([
               'cod_id_cnpj'=> $cod_id_cnpj,
               'cod_chave_terminal'=> $cod_chave_terminal,
               'cod_identificador'=> $cod_identificador,
               'cod_localizacao'=> $cod_localizacao,
               'cod_codigo'=>$cod_codigo,
               'cod_preco'=>$cod_preco,
               'cod_quantidade'=>$cod_quantidade
            ]);
            return $codigo;
        } 
    }