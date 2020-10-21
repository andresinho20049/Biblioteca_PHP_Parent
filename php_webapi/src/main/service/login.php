<?php
    namespace Andre\Service;
    // timezone
    date_default_timezone_set('America/Sao_Paulo');
    
    require_once 'vendor/autoload.php';

    //Banco
    use Andre\Resources\Banco;
    use Andre\Service\JWTWrapper;
    use \PDO;

    class Login{

        // Autenticacao
        public function novo_login($usuario, $senha){

            if (isset($usuario) && isset($senha)) {

                // Validação do usuário/senha digitados
                $pdo = Banco::conectar();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sqlQuery = "select id, nome, nivel, email from usuarios where usuario = ? and senha = sha1(?) limit 1";
                $stmt = $pdo->prepare($sqlQuery);
                
                $stmt->bindParam(1, $usuario);
                $stmt->bindParam(2, $senha);
                $stmt->execute();

                $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
                Banco::desconectar();

                if (!is_null($dataRow['nome'])) {
                    // autenticacao valida, gerar token
                    $jwt = JWTWrapper::encode([
                        'expiration_sec' => 3600,
                        'iss' => $_SERVER['HTTP_HOST'],
                        'userdata' => [
                            'nome' => $dataRow['nome'],
                            'email' => $dataRow['email'],
                            'nivel' => $dataRow['nivel']
                        ]
                    ]);
                    return array(
                        'login' => 'true',
                        'jwt' => $jwt
                    );
                }
            }
            return array(
                'login' => 'false',
                'message' => 'Login Invalido'
            );
        }

        public function cadastro($user, $senha, $nome, $email, $nivel){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO
                        usuarios
                    SET
                        id = null,
                        nome = :nome, 
                        usuario = :user, 
                        senha = :senha, 
                        email = :email,
                        nivel = :nivel";
            
            $stmt = $pdo->prepare($sql);
        
            // Traduzir para html
            $nome=htmlspecialchars(strip_tags($nome));
            $user=htmlspecialchars(strip_tags($user));
            $senha=htmlspecialchars(strip_tags($senha));
            $email=htmlspecialchars(strip_tags($email));
            $nivel=htmlspecialchars(strip_tags($nivel));
        
            // Passar parametros STMT
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":user", $user);
            $stmt->bindParam(":senha", $senha);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":nivel", $nivel);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }
    }   
  ?>