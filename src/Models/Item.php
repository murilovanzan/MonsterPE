<?php

    class Item {

        private ?int $item_id = null;
        private ?int $usuario_id = null;
        private ?int $quantidade = null;

        public function __construct(?int $item_id = null, ?int $usuario_id = null, ?int $quantidade = null){

            if (!isset($item_id) && !isset($usuario_id) && !isset($quantidade)) return;

            $this->item_id = $item_id;
            $this->usuario_id = $usuario_id;
            $this->quantidade = $quantidade;
        }

        // Getters
        public function getItemId() { return $this->item_id; }
        public function getUsuarioId() { return $this->usuario_id; }
        public function getQuantidade() { return $this->quantidade; }

        // Setters
        public function setItemId($item_id) { $this->item_id = $item_id; }
        public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }
        public function setQuantidade($quantidade) { $this->quantidade = $quantidade; }
        
        public function salvar($update = false) {
            $db = getConnection();
            if(!$update){
                $sql = "INSERT INTO usuario_itens (item_id, usuario_id, quantidade) VALUES (:item_id, :usuario_id, :quantidade);";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':item_id'    => $this->item_id,
                    ':usuario_id' => $this->usuario_id,
                    ':quantidade' => $this->quantidade
                ]);
            }
            else{
                $sql = "UPDATE usuario_itens SET quantidade = :quantidade WHERE item_id = :item_id AND usuario_id = :usuario_id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':quantidade' => $this->quantidade,
                    ':item_id'    => $this->item_id,
                    ':usuario_id' => $this->usuario_id
                ]);
            }
        }

        public static function delete($item_id, $usuario_id){
            $db = getConnection();
            $sql = "DELETE FROM usuario_itens WHERE item_id = :item_id AND usuario_id = :usuario_id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':item_id'    => $item_id,
                ':usuario_id' => $usuario_id
            ]);
        }

        public static function getItensPorUsuario($usuario_id){
            $db = getConnection();
            $sql = "SELECT * FROM usuario_itens WHERE usuario_id = :usuario_id;";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $usuario_id
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getByItemAndUser($item_id, $usuario_id){
            $db = getConnection();
            $sql = "SELECT * FROM usuario_itens WHERE item_id = :item_id AND usuario_id = :usuario_id;";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':item_id'    => $item_id,
                ':usuario_id' => $usuario_id
            ]);
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($dados) {
                return new self($dados['item_id'], $dados['usuario_id'], $dados['quantidade']);
            }
            return null;
        }

    }

?>