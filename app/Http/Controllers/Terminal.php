<?php

namespace App\Http\Controllers;

use App\Services\SwitchDatabaseService;
use App\Services\TerminalService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Terminal extends Controller
{
    private $TerminalService;
    private $SwitchDatabaseService;

    public function __construct()
    {
        $this->TerminalService = new TerminalService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
    }
    public function findByKey(int $key, Request $request)
    {
        $req = $request->all(['cnpj']);
        $database = 'mysql2';
        if (!isset($key)) {
            $json['message'] = 'Não foi possivel encontrar o terminal';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $terminal = $this->TerminalService->findByKey($key, $database);
                if (!isset($terminal)) {
                    $json['message'] = 'Não foi possivel encontrar o terminal';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                } else {
                    Log::info("Sucesso na rota terminal/findByKey buscando pela chave: " . $key);
                    $json['response'] = $terminal;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota terminal/findByKey buscando pela chave: " . $key . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }

    public function createTerminal(Request $request)
    {
        $req = $request->all(['terminal', 'chave', 'cnpj']);
        if (!isset($req['terminal']) || !isset($req['chave']) || !isset($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $database = 'mysql2';
            try {
                $terminal = $this->TerminalService->createTerminal($req['terminal'], $req['chave'], $database);
                Log::info("Sucesso na rota terminal/createTerminal cadastrando pela chave: " . $req['terminal']);
                $json['response'] = $terminal;
                $json['status'] = 200;
                $json = json_encode($json);
                return response($json, 200);
            } catch (Exception $error) {
                Log::error("Error na rota terminal/createTerminal cadastrando pela chave: " . $req['chave'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }
    }
}
