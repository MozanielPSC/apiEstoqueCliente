<?php 

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Terminal;
    class SwitchDatabaseService{
        public function __construct(){

        }
        public function switchDatabase(string $cnpj){
			$database = '';
        switch($cnpj){
            case '17283276000127': 
                $database = 'classica';
                return $database;
                break;
            default:
                $database = //'mysqlteste';
                //'mysql2';
                 'pgsql3';
                return $database;
                break; 
            }
		}
    }