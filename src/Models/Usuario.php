<?php

    class Usuario {

        private ?int $id = null;
        private ?String $nome = null;
        private ?String $username = null;
        private ?String $email = null;
        private ?String $senha = null;
        private ?int $tokens = 0;
        private ?bool $adm = false;
        private ?String $foto = null;

        public function __construct(?String $nome = null, ?String $username = null, ?String $email = null, ?String $senha = null,?bool $adm = false, ?String $foto = null) {
            if(!isset($nome) && !isset($username) && !isset($email) && !isset($senha)) return;
            
            self::validaNome($nome);
            self::validaUsername($username);
            self::validaEmail($email);
            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $this->nome = $nome;
            $this->username = strtolower(trim($username));
            $this->email = strtolower(trim($email));
            $this->senha = $senha;
            $this->tokens = 0;
            $this->adm = $adm;
            $this->foto = $foto;
        }

        public function getId(){
            return $this->id;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getSenha(){
            return $this->senha;
        }
        public function getTokens(){
            return $this->tokens;
        }
        public function getAdm(){
            return $this->adm;
        }
        public function getFoto(){
            return $this->foto;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setUsername($username){
            self::validaUsername($username);
            $this->username = strtolower(trim($username));
        }
        public function setEmail($email){
            self::validaEmail($email);
            $this->email = strtolower(trim($email));
        }
        public function setSenha($senha){
            $senha = password_hash($senha, PASSWORD_DEFAULT);
            $this->senha = $senha;
        }
        public function setTokens($tokens){
            $tokens ??= 0;
            $this->tokens = $tokens;
        }
        public function setAdm($adm){
            $this->adm = (bool) $adm;
        }
        public function setFoto($foto){
            $this->foto = $foto;
        }

        public function salvar(){
            $db = getConnection();
            $admInt = $this->adm ? 1 : 0;
            if($this->id){
                $sql = "UPDATE usuario SET nome = :n, username = :u, email = :e, senha = :s, tokens = :t, adm = :a, foto = :img WHERE id = :id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([':n' => $this->nome, ':u' => $this->username, ':e' => $this->email, ':s' => $this->senha, ':t' => $this->tokens, ':a' => $admInt, ':img' => $this->foto, ':id' => $this->id]);
            }
            $sql = "INSERT INTO usuario (nome, username, email, senha, tokens, adm, foto) VALUES (:n, :u, :e, :s, :t, :a, :img);";
            $stmt = $db->prepare($sql);
            $inserido = $stmt->execute([':n' => $this->nome, ':u' => $this->username, ':e' => $this->email, ':s' => $this->senha, ':t' => $this->tokens, ':a' => $admInt, ':img' => $this->foto]);
            if($inserido){
                $this->id = (int) $db->lastInsertId();
            }
            return $inserido;
        }

        public static function delete($id){
            $db = getConnection();
            $sql = "DELETE FROM usuario WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        }

        public static function getTodos(){
            $db = getConnection();
            $sql = "SELECT * FROM usuario;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public static function getById($id, $class = true){
            $db = getConnection();
            $sql = "SELECT * FROM usuario WHERE id = :id;";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            if($class){
                $obj = $stmt->fetch(PDO::FETCH_OBJ);
                if(!$obj){
                    throw new Exception('ID não encontrado');
                }
                return self::hydrate($obj);
            }
            else{
                return $stmt->fetch();
            }
        }

        public static function getByColumn($columnValue, $column){
            
            $db = getConnection();
            $sql = "SELECT * FROM usuario WHERE $column = :valor";
            $stmt = $db->prepare($sql);
            $stmt->execute([':valor' => $columnValue]);
            $obj = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$obj){
                return $obj;
            }
            return self::hydrate($obj);
            
        }
        
        public static function hydrate($obj){
                $user = new self();
                $user->id = $obj->id;
                $user->nome = $obj->nome;
                $user->username = $obj->username;
                $user->email = $obj->email;
                $user->senha = $obj->senha;
                $user->tokens = $obj->tokens;
                $user->adm = $obj->adm;
                $user->foto = $obj->foto;
                return $user;
        }

        private static function isAdmin($id){
            $user = self::getById($id);
            return $user->getAdm();
        }

        private static function validaNome($nome){
            if(strlen($nome)>128){
                throw new Exception("O nome digitado excede o limite de 128 caracteres. Se você digitou seu nome corretamente e gostaria de cadastrá-lo, mas está com problemas, entre em contato com o suporte.");
            }
        }
        private static function validaUsername($username){
            if(strlen($username)>16){
                throw new Exception("O username digitado excede o limite de 16 caracteres");
            }
            $resultUsername = self::getByColumn($username, 'username');
            if(!empty($resultUsername) ){
                throw new Exception('Este usúario já existe');
            }
            if(!preg_match('/^[a-zA-Z0-9_.\-]+$/', $username)){
                throw new Exception('O username digitado utiliza caracteres inválidos (utilize apenas: letras, números e . - _ )');
            }
        }

        private static function validaEmail($email){
            if(strlen($email)>320){
                throw new Exception("O email digitado excede o limite de 320 caracteres");
            }
            $resultEmail = self::getByColumn($email, 'email');
            if(!empty($resultEmail)){
                throw new Exception('Este email já esta cadastrado');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('O email informado é invalido');
            }
        }
    }
?>