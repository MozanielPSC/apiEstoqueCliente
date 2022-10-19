<?php

namespace App\Http\Controllers;

use App\Mail\Separacao;
use App\Services\ConvertToUTFService;
use App\Services\OrdersService;
use App\Services\SwitchDatabaseService;
use App\Services\VerifyCNPJ;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Order extends Controller
{
    private $OrdersService;
    public function __construct()
    {
        $this->OrdersService = new OrdersService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
        $this->VerifyCNPJ = new VerifyCNPJ();
        $this->ConvertToUTFService = new ConvertToUTFService();
    }

    public function status(Request $request)
    {
        $req = $request->all(['cnpj', 'status', 'codigo']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if (!$req['status'] || !$req['codigo']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $order = $this->OrdersService->update($req['codigo'], $req['status'], $database);
                if (isset($order)) {
                    $json['response'] = $this->ConvertToUTFService->convertToUTF($order);
                    $json['status'] = 200;
                    Log::info("Sucesso na rota order/status cnpj:" . $req['cnpj']);
                    return response()->json($json);
                } else {
                    $json['message'] = 'Não foi possível encontrar o  pedido';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota status cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }
    }
    public function confirmaRecebimento(Request $request)
    {
        $req = $request->all(['cnpj', 'status', 'codigo','codseparador']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if (!$req['status'] || !$req['codigo'] || !$req['codseparador']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $order = $this->OrdersService->updateConfirma($req['codigo'], $req['status'],$req['codseparador'], $database);
                if (isset($order)) {
                    $json['response'] = $this->ConvertToUTFService->convertToUTF($order);
                    $json['status'] = 200;
                    Log::info("Sucesso na rota order/status cnpj:" . $req['cnpj']);
                    return response()->json($json);
                } else {
                    $json['message'] = 'Não foi possível encontrar o  pedido';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            } catch (Exception $error) {
                Log::error("Error na rota status cnpj: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }
        }
    }

    public function consultaParametros(Request $request)
    {
        $req = $request->all(['cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            try {
                $parametros = $this->OrdersService->getParameters($database, $req['cnpj']);
                if (isset($parametros)) {
                    $resp["status"] = 200;
                    $resp["response"] = $parametros;
                    // $resp = [
                    //     "urlimagem"=> "https://www.hsnfe.com.br/imagemproduto/",
                    //     "urlremoto" => "https://www.hsnfe.com.br/ws/appbarra/ws/",
                    //     "iplocal" => "https://www.hsnfe.com.br/ws/appbarra/ws/",
                    //     "tempolimite" => 30,
                    //     "status" => 200
                    // ];
                    $resp = json_encode($resp, JSON_UNESCAPED_SLASHES);
                    Log::info("Sucesso na rota getParametros cnpj:" . $req['cnpj']);
                    return response($resp, 200);
                } else {
                    $json['message'] = 'Não foi possível encontrar os parâmetros';
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }

            } catch (Exception $error) {
                Log::error("Error na consulta parametros: " . $req['cnpj'] . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }

    }
    public function separacao(string $codpedido, Request $request)
    {
        $req = $request->all(['cnpj']);
        if (!$req['cnpj']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else
        if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else
        if (!$codpedido) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
            if ($database == '') {
                $json['message'] = 'Envie parâmetros validos';
                $json['status'] = 400;
                $json = json_encode($json);
                return response($json, 200);
            } else {
                try {
                    $order = $this->OrdersService->buscaPedidoSeparacao($codpedido, $database);
                    Mail::to("silverio@hardsystem.com.br")->send(new Separacao("Funcionou", $codpedido));
                    $json['response'] = $this->ConvertToUTFService->convertToUTF($order);
                    $json['status'] = 200;
                    $json = json_encode($json);
                    Log::info("Sucesso na rota pedidos separacao codpedido:" . $codpedido);
                    return response($json);
                } catch (Exception $error) {
                    Mail::to("silverio@hardsystem.com.br")->send(new Separacao($error->getMessage(), $codpedido));
                    Log::error("Error pedidos separacao: " . $codpedido . "message"
                        . $error->getMessage());
                    $json['message'] = 'Error' . $error->getMessage();
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            }

        }
    }
    public function proximo(Request $request)
    {
        $req = $request->all(['cnpj', 'codigoseparador']);
        if (!$req['cnpj'] || !$req['codigoseparador']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
            if ($database == '') {
                $json['message'] = 'Envie parâmetros validos';
                $json['status'] = 400;
                $json = json_encode($json);
                return response($json, 200);
            } else {
                try {
                    $order = $this->OrdersService->buscaProximoPedido($req['codigoseparador'], $database);
                    if ($order) {
                        $json['response'] = $this->ConvertToUTFService->convertToUTF($order);
                        $json['status'] = 200;
                        $json = json_encode($json);

                        Log::info("Sucesso ao consultar a busca próximo pedido:" . $req['codigoseparador']);
                        return response($json, 200);
                    } else {
                        $json['message'] = 'Não foi possível consultar a busca próximo pedido';
                        $json['status'] = 400;
                        $json = json_encode($json);
                        return response($json, 200);
                    }

                } catch (Exception $error) {
                    Log::error("Error pedidos separacao: " . $req['codigoseparador'] . "message"
                        . $error->getMessage());
                    $json['message'] = 'Error' . $error->getMessage();
                    $json['status'] = 400;
                    $json = json_encode($json);
                    return response($json, 200);
                }
            }

        }
    }
    public function cadastraPedido(Request $request)
    {
        $req = $request->all(['cnpj', 'json']);
        // if(!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])){
        //     $resp = [
        //         "msg"=> 'Envie um cnpj válido'
        //     ];
        //     return response()->json($resp,400);
        // }else{
        //     $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        //     $order = $this->OrdersService->create($database,$req['emissao'],$req['codigo'],$req['nome']);
        //     if($order){
        //         $json['codigo'] = $req['codigo'];
        //         $json['status'] = 200;
        //         return response($json,200);
        //     }

        // }
        if (!$req['cnpj'] || !$req['json']) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else if (!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])) {
            $json['message'] = 'Envie parâmetros validos';
            $json['status'] = 400;
            $json = json_encode($json);
            return response($json, 200);
        } else {
            $response['status'] = 200;
            $response['message'] = "Pedido realizado!!";
            $response['codigo'] = 303030;
            $response = json_encode($response);
            return response($response, 200);
        }

    }

}
