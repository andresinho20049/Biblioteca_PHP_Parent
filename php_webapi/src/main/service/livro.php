<?php
    namespace Andre\Service;
    use Andre\Resources\Banco;
    use \PDO;
    
    class Livro{
        
        public function getLivro(){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT id, nome, valor, isqn, quant, genero, editora, author, img FROM livro order by id ASC";
            $stmt = $pdo->prepare($sqlQuery);
            $stmt->execute();
            Banco::desconectar();
            return $stmt;
        }
        
        // Inserir
        public function createProduto($nome, $valor, $isqn, $quant, $genero, $editora, $author, $img){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO
                        livro
                    SET
                        nome = :nome, 
                        valor = :valor, 
                        isqn = :isqn, 
                        quant = :quant, 
                        genero = :genero, 
                        editora = :editora,
                        author = :author,
                        img = :img";
            
            $stmt = $pdo->prepare($sql);
        
            // Traduzir para html
            $nome=htmlspecialchars(strip_tags($nome));
            $valor=htmlspecialchars(strip_tags($valor));
            $isqn=htmlspecialchars(strip_tags($isqn));
            $quant=htmlspecialchars(strip_tags($quant));
            $genero=htmlspecialchars(strip_tags($genero));
            $editora=htmlspecialchars(strip_tags($editora));
            $author=htmlspecialchars(strip_tags($author));
            $img=htmlspecialchars(strip_tags($img));
        
            // Passar parametros STMT
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":isqn", $isqn);
            $stmt->bindParam(":quant", $quant);
            $stmt->bindParam(":genero", $genero);
            $stmt->bindParam(":editora", $editora);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":img", $img);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }

        // Retorna um registro, definido pelo {id}
        public function getLivroById($id){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT
                            id, 
                            nome, 
                            valor, 
                            isqn, 
                            quant,
                            genero,
                            editora,
                            author,
                            img
                        FROM 
                            livro
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
        public function atualizaLivro($id, $nome, $valor, $isqn, $quant, $genero, $editora, $author, $img){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE
                        livro
                    SET
                        nome = :nome, 
                        valor = :valor, 
                        isqn = :isqn, 
                        quant = :quant, 
                        genero = :genero, 
                        editora = :editora,
                        author = :author,
                        img = :img
                    WHERE 
                        id = :id";
        
            $stmt = $pdo->prepare($sql);
        
            // Traduzir para html
            $nome=htmlspecialchars(strip_tags($nome));
            $valor=htmlspecialchars(strip_tags($valor));
            $isqn=htmlspecialchars(strip_tags($isqn));
            $quant=htmlspecialchars(strip_tags($quant));
            $genero=htmlspecialchars(strip_tags($genero));
            $editora=htmlspecialchars(strip_tags($editora));
            $author=htmlspecialchars(strip_tags($author));
            $img=htmlspecialchars(strip_tags($img));
            $id=htmlspecialchars(strip_tags($id));
        
            // Passar parametros STMT
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":valor", $valor);
            $stmt->bindParam(":isqn", $isqn);
            $stmt->bindParam(":quant", $quant);
            $stmt->bindParam(":genero", $genero);
            $stmt->bindParam(":editora", $editora);
            $stmt->bindParam(":author", $author);
            $stmt->bindParam(":img", $img);
            $stmt->bindParam(":id", $id);
        
            if($stmt->execute()){
                Banco::desconectar();
                return true;
            }
            Banco::desconectar();
            return false;
        }

        // DELETE
        public function deletaLivro($id){
            $pdo = Banco::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM livro WHERE id = :id";
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