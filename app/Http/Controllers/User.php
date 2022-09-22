<?php

namespace App\Http\Controllers;

use App\Services\SwitchDatabaseService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class User extends Controller
{
    private $UserService;
    private $SwitchDatabaseService;

    public function __construct()
    {
        $this->UserService = new UserService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
    }
    public function select(Request $request)
    {
        $req = $request->all(['cnpj']);
        if (!isset($req['cnpj'])) {
            $json['message'] = 'Não foi possivel encontrar o usuario';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
            try {
                $usuario = $this->UserService->select($database);
                if (!isset($usuario)) {
                    
                    $json['message'] = 'Não foi possivel encontrar o usuario';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                } else {
                    Log::info("Sucesso na rota usuario buscando pelo cnpj: " . $req['cnpj']);
                    $json['response'] = $usuario;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota usuario buscando pelo cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }

    public function senha(Request $request)
    {
        $req = $request->all(['cnpj', 'codigo', 'senha']);
        if (!isset($req['cnpj']) || !isset($req['codigo']) || !isset($req['senha'])) {
            $json['message'] = 'Envie parâmetros válidos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
            try {
                $usuarioSenha = $this->UserService->update($database, $req['codigo'], $req['senha']);
                Log::info("Sucesso na rota usuarioSenha buscando pelo cnpj: " . $req['cnpj']);
                $json['response'] = $usuarioSenha;
                $json['status'] = 200;
                $json = json_encode($json);
                return response($json, 200);

            } catch (Exception $error) {
                Log::error("Error na rota usuario buscando pelo cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }

}
