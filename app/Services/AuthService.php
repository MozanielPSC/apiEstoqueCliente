<?php

namespace App\Services;

use App\Mail\VerifyEmail;
use App\Models\Empresa;
use App\Models\Terminal;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct()
    {

    }

    public function signIn($email, $cnpj, $terminal, $database)
    {
        //Se a empresa não for cadastrada,o serviço cadastra e retorna as credenciais
        //Caso seja cadastrada o serviço apenas retorna as credenciais
        //Chave =ash criado a partir do nome do dispositivo e da data
        //Verify = número aleatório
        $num_length = strlen((string) $cnpj);
        if ($num_length == 14) {
            $empresa = Empresa::on($database)->where("cnpj", "=", $cnpj)->first();
            if ($empresa) {
                $empresa->email = $email;
                $empresa->save();
                $verify = \rand(11111, 99999);
                $chave = \md5($terminal . date("H:i:s"));
                Terminal::on($database)->create([
                    "terminal" => $terminal,
                    "chave" => $chave,
                ]);
                Mail::to($email)->send(new VerifyEmail($verify));
                return [
                    "status" => 200,
                    "message" => "CNPJ ja cadastrado",
                    "verify" => $verify,
                    "chave" => $chave,
                    "id_web" => $empresa->id,
                ];

            } else {
                $cnpj = \preg_replace('/[^0-9]/', '', (string) $cnpj);
                $empresa = Empresa::on($database)->create(
                    [
                        "cnpj" => $cnpj,
                        "email" => $email,
                    ]
                );
                if ($empresa) {
                    $verify = \rand(11111, 99999);
                    $chave = \md5($terminal . date("H:i:s"));
                    Terminal::on($database)->create([
                        "terminal" => $terminal,
                        "chave" => $chave,
                    ]);
                    Mail::to($email)->send(new VerifyEmail($verify));
                    return [
                        "status" => 200,
                        "message" => "CNPJ ja cadastrado",
                        "verify" => $verify,
                        "chave" => $chave,
                        "id_web" => $empresa->id,
                    ];
                }
            }
        } else {
            return [
                "msg" => "Invalid Cnpj",
                "status" => 400,
            ];
        }
    }

}
