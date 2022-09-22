<?php

namespace App\Http\Controllers;

use App\Services\ProcessoService;
use App\Services\SwitchDatabaseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Processo extends Controller
{
    private $ProcessoService;
    private $SwitchDatabaseService;

    public function __construct()
    {
        $this->ProcessoService = new ProcessoService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
    }
    public function teste(Request $request)
    {

    }
    public function retorno(Request $request)
    {

        try {
            $req = $request->all([
                'json',
            ]);
            if (!isset($req['json'])) {
                $json['message'] = 'Envie parametros validos';
                $json['status'] = 400;
                $json = json_encode($json);
                return response($json, 200);
            }

            $args = json_decode($req['json']);
            
            if (
                !isset($args->cnpj)
                ||
                !isset($args->tipoerp)
                ||
                !isset($args->coderp)
                ||
                !isset($args->appcodigo)
                ||
                !isset($args->appinicioprocesso)
                ||
                !isset($args->appfinalprocesso)
                ||
                !isset($args->finalizacao)
                ||
                !isset($args->appcodfuncionario)
                ||
                !isset($args->appsituacao)
                ||
                !isset($args->items)
            ) {
                $json['message'] = 'Envie parametros validos';
                $json['status'] = 400;
                $json = json_encode($json);
                return response($json, 200);
            }

            $database = $this->SwitchDatabaseService->switchDatabase($args->cnpj);
            try {
                $codigo = $this->ProcessoService->pegaCodigoAppRetornoProcesso($database);
            } catch (Exception $error) {
                $response['status'] = 500;
                $response['response'] = [
                    'codigo' => '',
                    'codigoerp' => '',
                    'mensagemerro' => $error->getMessage(),
                    'codigoerro' => 0,
                ];
                $response = json_encode($response);
                return response($response, 200);
            }
            try {
                $this->ProcessoService->insertAppRetorno(
                    $database,
                    $codigo,
                    $args->tipoerp,
                    $args->coderp,
                    $args->finalizacao,
                    $args->appcodfuncionario,
                    $args->appinicioprocesso,
                    $args->appfinalprocesso,
                    $args->appsituacao,
                    $args->appcodigo
                );
            } catch (Exception $erro) {
                $response['status'] = 500;
                $response['response'] = [
                    'codigo' => '',
                    'codigoerp' => '',
                    'mensagemerro' => $erro->getMessage(),
                    'codigoerro' => 1,
                ];
                $response = json_encode($response);
                return response($response, 200);
            }

            try {
                $this->ProcessoService->insertLoop($database, $args->items, $codigo);
            } catch (Exception $err) {
                $response['status'] = 500;
                $response['response'] = [
                    'codigo' => '',
                    'codigoerp' => '',
                    'mensagemerro' => $err->getMessage(),
                    'codigoerro' => 2,
                ];
                $response = json_encode($response);
                return response($response, 200);
            }

            try {
                $this->ProcessoService->update($database, $codigo);
            } catch (Exception $er) {
                $response['status'] = 500;
                $response['response'] = [
                    'codigo' => '',
                    'codigoerp' => '',
                    'mensagemerro' => $er->getMessage(),
                    'codigoerro' => 3,
                ];
                $response = json_encode($response);
                return response($response, 200);
            }

            try {
                $codigoerp = $this->ProcessoService->selectCoderp($database, $codigo);
            } catch (Exception $e) {
                $response['status'] = 500;
                $response['response'] = [
                    'codigo' => '',
                    'codigoerp' => '',
                    'mensagemerro' => $e->getMessage(),
                    'codigoerro' => 4,
                ];
                $response = json_encode($response);
                return response($response, 200);
            }
            $response['status'] = 200;
            $response['response'] = [
                'codigo' => $codigo,
                'codigoerp' => $codigoerp,
                'mensagemerro' => '',
                'codigoerro' => '',
            ];
            $response = json_encode($response);
            return response($response, 200);
        } catch (Exception $reserror) {
            Log::error("[igor] response error: " . $reserror->getMessage());
            $response['status'] = 400;
            $response['message'] = $reserror->getMessage();
            $response = json_encode($response);
            return response($response, 200);
        }
    }
}
