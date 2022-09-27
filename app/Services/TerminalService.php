<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Terminal;
    class TerminalService{
        public function __construct(){

        }
        public function findByKey(int $key,string $database){
			
          $res =  Terminal::on($database)->where('chave','=',$key)->first();
          return $res;
		}
        public function createTerminal(string $terminal,string $chave,string $database){
            
            $res =  Terminal::on("mysql2")->create([
               "terminal"=> $terminal,
                "chave"=> $chave
            ]);
            return $res;
        } 
    }