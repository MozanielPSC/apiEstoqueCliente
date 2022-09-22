<?php

namespace App\Http\Controllers;

use App\Services\CodigoService;
use App\Services\SwitchDatabaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Codigo extends Controller
{
    private $CodigoService;
    public function __construct()
    {
        $this->CodigoService = new CodigoService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
    }
    public function showCodigos(string $idCnpj, Request $request)
    {
        $req = $request->all(['cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$req['cnpj'] || !$database) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $codigo = $this->CodigoService->showCodigos($idCnpj, $database);
                if (isset($codigo)) {
                    $json['response'] = $codigo;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    Log::info("Sucesso na rota showCodigos cnpj: " . $req['cnpj']);
                    return response($json, 200);
                } else {
                    $json['message'] = 'Não foi possivel encontrar';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota showCodigos cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }

    }

    public function cadastro(Request $request)
    {
        $req = $request->all(['items', 'cnpj']);
        $req['items'];
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$req['items'] || !$req['cnpj'] || !$database) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                for ($i = 0; $i < \sizeof($req['items']); $i++) {
                    $this->CodigoService->createCodigo(
                        $req['items'][$i]['cod_id_cnpj'],
                        $req['items'][$i]['cod_chave_terminal'],
                        $req['items'][$i]['cod_identificador'],
                        $req['items'][$i]['cod_localizacao'],
                        $req['items'][$i]['cod_codigo'],
                        $req['items'][$i]['cod_preco'],
                        $req['items'][$i]['cod_quantidade'],
                        $database
                    );
                }
                Log::info("Sucesso na rota codigos/cadastro cnpj: " . $req['cnpj']);
                $response['status'] = 200;
                $response['msg'] = 'Codigos cadastrados';
                $response = \json_encode($response);
                return response($response, 200);
            } catch (Exception $error) {
                Log::error("Error na rota cadastroCodigos cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }

    }

    public function createCodigo(Request $request)
    {
        $req = $request->all(['cod_id_cnpj', 'cod_chave_terminal', 'cod_identificador', 'cod_localizacao', 'cod_codigo', 'cod_preco', 'cod_quantidade', 'cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (
            !isset($req['cod_id_cnpj']) ||
            !isset($req['cod_chave_terminal']) ||
            !isset($req['cod_identificador']) ||
            !isset($req['cod_localizacao']) ||
            !isset($req['cod_codigo']) ||
            !isset($req['cod_preco']) ||
            !isset($req['cod_quantidade']) ||
            !isset($database)
        ) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $codigo = $this->CodigoService->createCodigo(
                    $req['cod_id_cnpj'],
                    $req['cod_chave_terminal'],
                    $req['cod_identificador'],
                    $req['cod_localizacao'],
                    $req['cod_codigo'],
                    $req['cod_preco'],
                    $req['cod_quantidade'],
                    $database
                );
                Log::info("Sucesso na rota codigos/createCodigo cnpj: " . $req['cnpj']);
                return response()->json($codigo);
            } catch (Exception $error) {
                Log::error("Error na rota cadastroCodigos cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }

    }
}
