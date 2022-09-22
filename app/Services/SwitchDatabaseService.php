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
            default:
                $database = //'mysqlteste';
                //'mysql2';
                 'pgsql3';
                return $database;
                break; 
            }
		}
    }