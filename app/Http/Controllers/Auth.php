<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\AuthService;
use App\Services\SwitchDatabaseService;
use App\Services\VerifyCNPJ;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Auth extends Controller
{
    private $AuthService;
    private $SwitchDatabaseService;
    private $VerifyCNPJ;
    public function __construct()
    {
        $this->AuthService = new AuthService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
        $this->VerifyCNPJ = new VerifyCNPJ();
    }

    public function signIn(Request $request)
    {
        //Controlador que gera um token e "loga" o usuário no sistem;
        //Recebe e valida os parâmetros
        $info = $request->all(['email', 'cnpj', 'terminal']);
        $email = $info["email"];
        $cnpj = $info["cnpj"];
        $database = 'mysql2';
        $terminal = $info["terminal"];
        if (!isset($email) || !isset($terminal) || !isset($cnpj)) {
            $resp = [
                "msg" => "Invalid parameters",
                "status" => 400,
            ];
            return response()->json($resp, 200);
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $resp = [
                "msg" => "Invalid email",
                "status" => 400,
            ];
            return response()->json($resp, 200);
        } else if(!$this->VerifyCNPJ->verifyCNPJ($cnpj)){
            $resp = [
                "msg" => "Invalid CNPJ",
                "status" => 400,
            ];
            return response()->json($resp, 200);
        }
        else{
            try {
                // Chama o serviço e retorna uma resposta
                $terminal = $info["terminal"];
                $resp = $this->AuthService->signIn(
                    $email,
                    $cnpj,
                    $terminal,
                    $database
                );
                Log::info("Sucesso na rota signIn com o email : " . $email);
                return response()->json($resp, $resp["status"]);
            } catch (Exception $error) {
                Log::error("Error na rota signIn com o email : " . $email . "message"
                    . $error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response = json_encode($response);
                return response($response, 200);
            }

        }
    }
    public function teste()
    {
        $resposta = $this->AuthService->deleteExpired();
        return response()->json($resposta);
    }
}
