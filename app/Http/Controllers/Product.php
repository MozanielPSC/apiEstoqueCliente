<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductsService;
use App\Services\SwitchDatabaseService;
use App\Services\ConvertToUTFService;
use App\Services\VerifyCNPJ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Produto;
use Exception;

class Product extends Controller
{
    private $ProductsService;
    private $SwitchDatabaseService;
    private $VerifyCNPJ;
    private $ConvertToUTFService;
    public function __construct(){
        $this->ProductsService = new ProductsService();
        $this->SwitchDatabaseService = new SwitchDatabaseService();
        $this->VerifyCNPJ = new VerifyCNPJ();
        $this->ConvertToUTFService = new ConvertToUTFService();

    }
    public function select(Request $request){
        $req = $request->all(['desc']);
        $product = $this->ProductsService->getProductByDesc($req['desc']);
        return response()->json($product);
    }

    public function getByCode(Request $request){
        $req = $request->all(['code','cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if(!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])){
            $resp = [
                "msg"=> 'Envie um cnpj válido'
            ];
            return response()->json($resp,200);
        }else if(!isset($req['code'])){
            return response('Não foi possivel encontrar o produto',400);
        }else if(!isset($req['cnpj'])){
            return response('Envie um cnpj válido',400);
        }else if($database == ''){
            return response('Envie um cnpj válido',400);
        }else{
            try{
                $product = $this->ProductsService->getProductByCode($req['code'],$database);
                    if(isset($product)){
                        if(\sizeof($product)== 1){
                            $product =  $this->ConvertToUTFService->convertToUTF($product);
                            $json['response'] = $product[0];
                            $json['status'] = 200;  
                            Log::info("Sucesso na rota product/getByCode buscando pela descricao: ".$req['code']);
                            return response()->json($json,200);
                        }else{
                            $json['message'] = "Não foi possivel encontrar o produto";
                            $json['status'] = 400;
                            $json =  json_encode($json);
                            return response($json,200);
                        }
                    }else{
                        $json['message'] = "Não foi possivel encontrar o produto";
                        $json['status'] = 400;
                        $json =  json_encode($json);
                        return response($json,200);
                    }
            }catch(Exception $error){
                Log::error("Error na rota product/getByCode cnpj: ".$req['code']."message"
                .$error->getMessage());
                $response['msg'] = $error->getMessage();
                $response['status'] = 400;
                $response =  json_encode($response);
                return response($response,200);
            }
            
        }
    }

   
    public function getByDesc(Request $request){
        $req = $request->all(['desc','cnpj']);
        $database = $this->SwitchDatabaseService->switchDatabase($req['cnpj']);
        if(!$this->VerifyCNPJ->verifyCNPJ($req['cnpj'])){
            $resp = [
                "msg"=> 'Envie um cnpj válido'
            ];
            return response()->json($resp,200);
        }
        else if(!isset($req['desc'])){
            return response('Não foi possivel encontrar o produto',200);
        }else if(!isset($req['cnpj'])){
            return response('Envie um cnpj válido',200);
        }else if($database == ''){
            return response('Envie um cnpj válido',200);
        }else{
            if(!is_numeric($req['desc'])){
                try{
                    $product = $this->ProductsService->getProductByDesc($req['desc'],$database);
                    if(isset($product)){
                        $product =  $this->ConvertToUTFService->convertToUTF($product);
                        $json['response'] = $product;
                        $json['status'] = 200;
                        $json =  json_encode($json);
                        Log::info("Sucesso na rota byDesc buscando pela descricao: ".$req['desc']);
                        //return response($json,200);
                        return response($json,200);
                    }else{
                        return response('Não foi possivel encontrar o produto',200);
                    }
                }catch(Exception $error){
                    Log::error("Error na rota byDesc buscando pela descricao: ".$req['desc']."message"
                    .$error->getMessage());
                    $response['msg'] = $error->getMessage();
                    $response['status'] = 400;
                    $response =  json_encode($response);
                    return response($response,200);
                }
                
            }
            else{
                $num_length = strlen((string)$req['desc']);
                if($num_length < 10){
                    try{
                        $product = $this->ProductsService->getProductByCode($req['desc'],$database);
                    if(isset($product)){
                        $product =  $this->ConvertToUTFService->convertToUTF($product);
                        $json['response'] = $product;
                        $json['status'] = 200;
                        $json =  json_encode($json);
                        Log::info("Sucesso na rota byDesc buscando pelo codigo: ".$req['desc']);
                        return response($json,200);
                    }  
                    }catch(Exception $error){
                        Log::error("Error na rota byDesc buscando pela codigo: ".$req['desc']."message"
                        .$error->getMessage());
                        $response['msg'] = $error->getMessage();
                        $response['status'] = 400;
                        $response =  json_encode($response);
                        return response($response,200); 
                    }
                    
                }else{
                    try{
                        $convert = \strval($req['desc']);
                        $product = $this->ProductsService->getProductByInt($convert,$database);
                        if(isset($product)){
                            $product =  $this->ConvertToUTFService->convertToUTF($product);
                            $json['response'] = $product;
                            $json['status'] = 200;
                            $json =  json_encode($json);
                            Log::info("Sucesso na rota byDesc buscando pelo codigo integean: ".$req['desc']);
                            return response($json,200);
                        }else{
                            return response('Não foi possivel encontrar o produto',400);
                        }
                    }catch(Exception $error){
                        Log::error("Error na rota byDesc buscando pelo codigo integean: ".$req['desc']."message"
                        .$error->getMessage());
                        $response['msg'] = $error->getMessage();
                        $response['status'] = 400;
                        $response =  json_encode($response);
                        return response($response,200);
                    }
                    
                }
            }
        }
    }
}