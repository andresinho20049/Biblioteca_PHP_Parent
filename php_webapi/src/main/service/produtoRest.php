<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../dao/produto.php';

    #Ta miando um pouco, mas esse código ta um gato diz ai ;)
    if($_SERVER['REQUEST_METHOD']==='GET'){
        $produtoRest = new ProdutoRest();
        if(isset($_GET['id'])){
            echo $produtoRest->metodoGetParametro();
        }else{
            echo $produtoRest->metodoGet();
        }
    } elseif($_SERVER['REQUEST_METHOD']==='POST'){
        $produtoRest = new ProdutoRest();
        echo $produtoRest->metodoPost();
    } elseif($_SERVER['REQUEST_METHOD']==='PUT'){
        $produtoRest = new ProdutoRest();
        echo $produtoRest->metodoPut();
    } elseif($_SERVER['REQUEST_METHOD']==='DELETE'){
        $produtoRest = new ProdutoRest();
        echo $produtoRest->metodoDelete();
    } else {
        die('Mano se ta fazendo bosta');
    }

    class ProdutoRest{

        public function metodoGet(){
            $produto = new Produto();
            $stmt = $produto->getProdutos();
            $itemCount = $stmt->rowCount();

            if($itemCount > 0){
                
                $produtos = array();
                $produtos["produtos"] = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $p = array(
                        "id" => $id,
                        "nome" => $nome,
                        "valor" => $valor,
                        "quantidade" => $quantidade,
                        "descricao" => $descricao
                    );

                    array_push($produtos["produtos"], $p);
                }
                http_response_code(200);
                return json_encode($produtos);
            }

            else{
                http_response_code(400);
                return json_encode(
                    array("erro" => "Nao possui itens!",'status'=>'400')
                );
            }
        }


        public function metodoGetParametro(){
            $id = isset($_GET['id']) ? $_GET['id'] : die();
            $produto = new Produto();
            $dataRow = $produto->getProduto($id);

            if(!is_null($dataRow['nome'])){    
                $p_arr = array(
                    "id" =>  $dataRow['id'],
                    "nome" => $dataRow['nome'],
                    "valor" => $dataRow['valor'],
                    "quantidade" => $dataRow['quantidade'],
                    "descricao" => $dataRow['descricao']
                );
                
                http_response_code(200);
                return json_encode($p_arr);
            
            } else {
                http_response_code(400);
                return json_encode(array("erro" => "Registro nao encontrado",'status'=>'400'));
            }
        }


        public function metodoPost(){
            $data = file_get_contents("php://input");
            $obj = json_decode($data, true);
            
            if(!is_null($obj)){
                $nome = $obj['nome'];
                $valor = $obj['valor'];
                $quantidade = $obj['quantidade'];
                $descricao = $obj['descricao'];
                
                $produto = new Produto();
                if($produto->createProduto($nome, $valor, $quantidade, $descricao)){
                    http_response_code(200);
                    return json_encode(array('mensagem'=>'Sucesso!','status'=>'200'));
                } else{
                    http_response_code(500);
                    return json_encode(array('erro'=>'Nao inserido no banco','status'=>'400'));
                }
            } else {
                http_response_code(400);
                return json_encode(array('request'=>$data, 'erro'=>'Falha no request','status'=>'400'));
            }
        }

        public function metodoPut(){
            $data = file_get_contents("php://input");
            $obj = json_decode($data, true);
            
            if(!is_null($obj)){
                $id = $obj['id'];
                $nome = $obj['nome'];
                $valor = $obj['valor'];
                $quantidade = $obj['quantidade'];
                $descricao = $obj['descricao'];
                
                $produto = new Produto();
                if($produto->atualizaProduto($nome, $valor, $quantidade, $descricao, $id)){
                    http_response_code(200);
                    return json_encode(array('mensagem'=>'Sucesso!','status'=>'200'));
                } else{
                    http_response_code(500);
                    return json_encode(array('erro'=>'Nao atualizado no banco','status'=>'500'));
                }
            } else {
                http_response_code(400);
                return json_encode(array('request'=>$data, 'erro'=>'Falha no request','status'=>'400'));
            }
        }


        public function metodoDelete(){
            $data = file_get_contents("php://input");
            $obj = json_decode($data, true);
            
            if(!is_null($obj)){
                $id = $obj['id'];

                $produto = new Produto();
                if($produto->deleteProduto($id)){
                    http_response_code(200);
                    return json_encode(array('mensagem'=>'Sucesso!','status'=>'200'));
                } else{
                    http_response_code(400);
                    return json_encode(array('erro'=>'Falha no delete','status'=>'400'));
                }
            } else {
                http_response_code(400);
                return json_encode(array('request'=>$data, 'erro'=>'Falha no request','status'=>'400'));
            }
        }
    }

?>