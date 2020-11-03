<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials:true");
header("Content-Type: application/json; charset=utf-8");
// timezone
date_default_timezone_set('America/Sao_Paulo');
 
require_once __DIR__ . '/vendor/autoload.php';

 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

use Andre\Service\Login; 
use Andre\Service\Livro;
use Andre\Service\JWTWrapper;
 
$app = new Silex\Application();

// Autenticacao
$app->post('/auth', function (Request $request) use ($app) {
	$dados = json_decode($request->getContent(), true);
	
	$usuario = $dados['user'];
	$senha = $dados['password'];
	
	$login = new Login();
    return $app->json($login->novo_login($usuario, $senha));
});

$app->post('/novousers', function (Request $request) use ($app) {
	$dados = json_decode($request->getContent(), true);
	
	$usuario = $dados['user'];
	$senha = sha1($dados['password']);
	$nome = $dados['nome'];
	$email = $dados['email'];
	$nivel = $dados['nivel'];
	
    $login = new Login();
    if($login->cadastro($usuario, $senha, $nome, $email, $nivel)){
        http_response_code(200);
        return $app->json(array('mensagem'=>'Sucesso!','status'=>'200'));
    } else{
        http_response_code(400);
        return $app->json(array('erro'=>'Nao inserido no banco','status'=>'400'));
    }
    
});

// verificar autenticacao
$app->before(function(Request $request, Application $app) {
    $route = $request->get('_route');
 
    if($route != 'POST_auth' && $route != 'POST_novousers') {
        $authorization = $request->headers->get("Authorization");
        list($jwt) = sscanf($authorization, 'Bearer %s');
 
        if($jwt) {
            try {
                $app['jwt'] = JWTWrapper::decode($jwt);
                if ($route != 'GET_verify' && $route != 'GET_livro') {
                    if($app['jwt']->data->nivel != "2"){
                        return new Response('Usuario nao tem permissao', 403);
                    }
                }
            } catch(Exception $ex) {
                // nao foi possivel decodificar o token jwt
                return new Response('Acesso nao autorizado', 403);
            }
		
        } else {
            // nao foi possivel extrair token do header Authorization
            return new Response('Token nao informado', 401);
        }
    }
});

// rota deve ser acessada somente por usuario autorizado com jwt
$app->get('/verify', function(Application $app) {
    return $app->json($app['jwt']->data);
});

$app->post('/livro', function (Request $request) use ($app) {
	$dados = json_decode($request->getContent(), true);
    
	$nome = $dados['nome'];
	$valor = $dados['valor'];
	$isqn = $dados['isqn'];
	$quant = $dados['quant'];
	$genero = $dados['genero'];
	$editora = $dados['editora'];
    $author = $dados['author'];
    $img = $dados['img'];
	
	$livro = new Livro();
    if($livro->createProduto($nome, $valor, $isqn, $quant, $genero, $editora, $author, $img)){
        http_response_code(200);
        return $app->json(array('mensagem'=>'Sucesso!','status'=>'200'));
    } else{
        http_response_code(400);
        return $app->json(array('erro'=>'Nao inserido no banco','status'=>'400'));
    }
});

$app->put('/livro', function (Request $request) use ($app) {
	$dados = json_decode($request->getContent(), true);

    $id = $dados['id'];
    $nome = $dados['nome'];
	$valor = $dados['valor'];
	$isqn = $dados['isqn'];
	$quant = $dados['quant'];
	$genero = $dados['genero'];
	$editora = $dados['editora'];
    $author = $dados['author'];
    $img = $dados['img'];
	
	$livro = new Livro();
    if($livro->atualizaLivro($id, $nome, $valor, $isqn, $quant, $genero, $editora, $author, $img)){
        http_response_code(200);
        return $app->json(array('mensagem'=>'Atualizado com sucesso!','status'=>'200'));
    } else{
        http_response_code(400);
        return $app->json(array('erro'=>'Nao atualizado no banco','status'=>'400'));
    }
});

$app->get('/livro', function(Application $app) {
    $livro = new Livro();
    $stmt = $livro->getLivro();

    $itemCount = $stmt->rowCount();
    if($itemCount > 0){
        
        $lista = array();
        $lista["livro"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //(Extrai variaveis iguai nome na base)
            extract($row); //id, nome, valor, isqn, quant, genero, editora, author, img 
            $p = array(
                "id" => $id,
                "nome" => $nome,
                "valor" => $valor,
                "isqn" => $isqn,
                "quant" => $quant,
                "genero" => $genero,
                "editora" => $editora,
                "author" => $author,
                "img" => $img
            );

            array_push($lista["livro"], $p);
        }
        http_response_code(200);
        return $app->json($lista);
    }

    else{
        http_response_code(400);
        return $app->json(array('erro'=>'Nao retorno itens','status'=>'400'));
    }
});

$app->delete('/livro', function (Request $request) use ($app) {
	$dados = json_decode($request->getContent(), true);

    $id = $dados['id'];
	
	$livro = new Livro();
    if($livro->deletaLivro($id)){
        http_response_code(200);
        return $app->json(array('mensagem'=>'Deletado com sucesso!','status'=>'200'));
    } else{
        http_response_code(400);
        return $app->json(array('erro'=>'Nao deletado do banco','status'=>'400'));
    }
});

$app->error(function(\Exception $e) use ($app) {
    print $e->getMessage(); // Do something with $e
});

$app->run();
?>