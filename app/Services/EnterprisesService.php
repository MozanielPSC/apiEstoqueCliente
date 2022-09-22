<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Empresa;
    class EnterprisesService{
        public function __construct(){

        }
        public function searchByCnpj(string $cnpj,string $database){
          $cnpj = preg_replace('/[^0-9]/', '',$cnpj);
          $enterprise =  DB::connection($database)->table('empresa')->where('cnpj','=',$cnpj)->first();
          return $enterprise;
		}
        public function createEnterprise(string $cnpj,string $email,string $database){
           
             $enterprise = 
            
             Empresa::on($database)->create([
                "cnpj" => $cnpj,
                "email" => $email,
            ]);
            return $enterprise;
        }
        public function updateEnterprise(int $id,string $cnpj,string $email,string $database){
           $empresa =  Empresa::on($database)->where('id','=',$id)->first();
           $empresa->cnpj = $cnpj;
           $empresa->email = $email;
           $empresa->save();
           return $empresa;
        }
        
    }