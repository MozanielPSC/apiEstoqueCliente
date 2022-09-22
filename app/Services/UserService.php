<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\ConvertToUTFService;
    class UserService{
        public function __construct(){
        }
        
        public function select(string $database){
            $user = DB::
            connection($database)
            ->
            select(
                "SELECT
                  appusuario.resetarsenha
                , appusuario.codterceiro
                , terceiro.razao as nome
                , terceiro.fantasia
                , terceiro.cnpj as cpf
                , terceiro.dddtelefone
                , terceiro.telefone
                , terceiro.email
                , terceiro.dddcelular
                , terceiro.celular
                , case when appusuario.ativo and terceiro.ativo then 1 else 0 end as ativo
                , appusuario.login
                , appusuario.senha
                , appusuario.acessopedido
                , appusuario.acessoseparacao
                , appusuario.acessoconferencia
                , appusuario.dados1
                , appusuario.dados2
                , appusuario.dados3  
                  FROM  appusuario
                  INNER JOIN  terceiro on terceiro.codigo = appusuario.codterceiro
                  where coalesce(appusuario.ativo,false)=true and coalesce(terceiro.ativo,false)=true
                  "
            );
            $user = ConvertToUTFService::convertToUTF($user);
            return $user;
		}

        public function update(string $database,int $codigo,string $senha){
            // $separacao = DB::
            // connection($database)
            // ->table('appusuario')
            // ->where('codterceiro','=',$codigo)->get();
            // dd($separacao);
            $separacao = DB::
            connection($database)
            ->table('appusuario')
            ->where('codterceiro','=',$codigo)->update(array('senha'=>$senha));

            $response = 'Atualizado com sucesso';
            return $response;
        }
    }