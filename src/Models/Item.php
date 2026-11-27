<?php

    class Item {

        private ?int $id = null;
        private ?string $nome = null;
        private ?string $descricao = null;
        private ?string $status = null;
        private ?string $efeito = null;
        private ?float $preco = null;

        public function __construct(?int $id = null, ?string $nome = null, ?string $descricao = null, ?string $status = null, ?string $efeito = null, ?float $preco = null){

            if (!isset($id) && !isset($nome) && !isset($descricao) && !isset($status) && !isset($efeito) && !isset($preco)) return;

            $this->id =$id;
            $this->nome =$nome;
            $this->descricao =$descricao;
            $this->status =$status;
            $this->efeito =$efeito;
            $this->preco =$preco;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNome() { return $this->nome; }
        public function getDescricao() { return $this->descricao; }
        public function getStatus() { return $this->status; }
        public function getEfeito() { return $this->efeito; }
        public function getPreco() { return $this->preco; }

        // Setters
        public function setId($id) { $this->id =$id; }
        public function setNome($nome) { $this->nome =$nome; }
        public function setDescricao($descricao) { $this->descricao =$descricao; }
        public function setStatus($status) { $this->status =$status; }
        public function setEfeito($efeito) { $this->efeito =$efeito; }
        public function setPreco($preco) { $this->preco =$preco; }
        
        public function salvar($update = false) {$db = getConnection();
            if(!$update){$sql = "INSERT INTO itens (nome, descricao, status, efeito, preco) VALUES (:nome, :descricao, :status, :efeito, :preco);";
                $stmt = $db->prepare($sql);
                $resultado =$stmt->execute([
                    ':nome'      => $this->nome,
                    ':descricao' => $this->descricao,
                    ':status'    => $this->status,
                    ':efeito'    => $this->efeito,
                    ':preco'     => $this->preco
                ]);
                
                if ($resultado) {
                    $this->id =$db->lastInsertId();
                }
                return $resultado;
            }
            else{
                $sql = "UPDATE itens SET nome = :nome, descricao = :descricao, status = :status, efeito = :efeito, preco = :preco WHERE id = :id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':nome'      => $this->nome,
                    ':descricao' => $this->descricao,
                    ':status'    => $this->status,
                    ':efeito'    => $this->efeito,
                    ':preco'     => $this->preco,
                    ':id'        => $this->id
                ]);
            }
        }

        public static function delete($id){
            $db = getConnection();$sql = "DELETE FROM itens WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':id' => $id
            ]);
        }

        public static function getAllItens(){
            $db = getConnection();$sql = "SELECT * FROM itens;";
            $stmt =$db->prepare($sql);$stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getById($id){
            $db = getConnection();$sql = "SELECT * FROM itens WHERE id = :id;";
            $stmt =$db->prepare($sql);$stmt->execute([
                ':id' => $id
            ]);
            $dados =$stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($dados) {
                return new self(
                    $dados['id'],$dados['nome'], 
                    $dados['descricao'],$dados['status'], 
                    $dados['efeito'],$dados['preco']
                );
            }
            return null;
        }

        

    }

?>