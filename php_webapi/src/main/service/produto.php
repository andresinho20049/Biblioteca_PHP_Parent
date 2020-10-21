<?php
    require '../config/banco.php';
    
    class Produto{
        
        // Columns
        /*
        private $id;
        private $nome;
        private $valor;
        private $quantidade;
        private $descricao;
        */

        // Retorna todos
        public function getProdutos(){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT id, nome, valor, quantidade, descricao FROM produto";
            $stmt = $pdo->prepare($sqlQuery);
            $stmt->execute();
            Banco::desconectar();
            return $stmt;
        }
        
        // Inserir
        public function createProduto($nome, $valor, $quantidade, $descricao){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO
                        produto
                    SET
                        nome = :nome, 
                        valor = :valor, 
                        quantidade = :quantidade, 
                        descricao = :descricao";
            
            $stmt = $pdo->prepare($sql);
        
            // Traduzir para html
            $nome=htmlspecialchars(strip_tags($nome));
            $valor=htmlspecialchars(strip_tags($valor));
            $quantidade=htmlspecialchars(strip_tags($quantidade));
            $descricao=htmlspecialchars(strip_tags($descricao));
        
            // Passar parametros STMT
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":quantidade", $quantidade);
            $stmt->bindParam(":descricao", $descricao);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }

        // Retorna um registro, definido pelo {id}
        public function getProduto($id){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT
                            id, 
                            nome, 
                            valor, 
                            quantidade, 
                            descricao
                        FROM 
                            produto
                        WHERE 
                            id = ?
                        LIMIT 0,1";

            $stmt = $pdo->prepare($sqlQuery);
            $stmt->bindParam(1, $id);
            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            Banco::desconectar();

            return $dataRow;
        }        

        // Atualizar
        public function atualizaProduto($nome, $valor, $quantidade, $descricao, $id){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE
                        produto
                    SET
                        nome = :nome, 
                        valor = :valor, 
                        quantidade = :quantidade, 
                        descricao = :descricao 
                    WHERE 
                        id = :id";
        
            $stmt = $pdo->prepare($sql);
        
            // Traduzir para html
            $nome=htmlspecialchars(strip_tags($nome));
            $valor=htmlspecialchars(strip_tags($valor));
            $quantidade=htmlspecialchars(strip_tags($quantidade));
            $descricao=htmlspecialchars(strip_tags($descricao));
            $id=htmlspecialchars(strip_tags($id));
        
            // Passar parametros STMT
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":quantidade", $quantidade);
            $stmt->bindParam(":descricao", $descricao);
            $stmt->bindParam(":id", $id);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }

        // DELETE
        public function deleteProduto($id){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM produto WHERE id = :id";
            $stmt = $pdo->prepare($sql);
        
            $id=htmlspecialchars(strip_tags($id));
        
            $stmt->bindParam(":id", $id);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }
    }
?>