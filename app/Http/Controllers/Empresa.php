<?php

namespace App\Http\Controllers;

use App\Services\EnterprisesService;
use App\Services\SwitchDatabaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Empresa extends Controller
{
    private $EnterprisesService;
    public function __construct()
    {
        $this->EnterprisesService = new EnterprisesService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
    }
    public function searchByCnpj(Request $request)
    {
        $req = $request->all(['cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!isset($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if ($database == '') {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $enterprise = $this->EnterprisesService->searchByCnpj($req['cnpj'], $database);
                if (isset($enterprise)) {
                    $json['response'] = $enterprise;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    Log::info("Sucesso na rota enterprise/searchByCnpj cnpj: " . $req['cnpj']);
                    return response($json, 200);
                } else {
                    $json['message'] = 'Não foi possível encontrar a empresa';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }

            } catch (Exception $error) {
                Log::error("Error na rota enterprise/searchByCnpj cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }
    }

    public function createEnterprise(Request $request)
    {
        $req = $request->all(['cnpj', 'email']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$req['cnpj']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if ($database == '') {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $enterprise = $this->EnterprisesService->createEnterprise($req['cnpj'], $req['email'], $database);

                if ($enterprise) {
                    $json['response'] = $enterprise;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    Log::info("Sucesso na rota createEnterprise cnpj: " . $req['cnpj']);
                    return response($json, 200);
                } else {
                    $json['message'] = 'Não foi possível encontrar a empresa';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota createEnterprise cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }
    public function updateEnterprise(Request $request)
    {
        $req = $request->all(['cnpj', 'email', 'id']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$req['cnpj']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if ($database == '') {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $enterprise = $this->EnterprisesService->updateEnterprise($req['id'], $req['cnpj'], $req['email'], $database);
                if ($enterprise) {
                    $json['response'] = $enterprise;
                    $json['status'] = 200;
                    $json = json_encode($json);
                    Log::info("Sucesso na rota updateEnterprise cnpj: " . $req['cnpj']);
                    return response($json, 200);
                } else {
                    $json['message'] = 'Não foi possível encontrar a empresa';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota updateEnterprise cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }
}
