<?php

    class Pokemon {

        private ?int $id = null;
        private ?string $nome = null;
        private ?string $descricao = null;
        private ?int $geracao = null;
        private ?int $hp = null;
        private ?int $speed = null;
        private ?int $attack = null;
        private ?int $defense = null;
        private ?int $spAttack = null;
        private ?int $spDefense = null;

        public function __construct(?string $nome = null, ?string $descricao = null, ?int $geracao = null, ?int $hp = null, ?int $speed = null, ?int $attack = null, ?int $defense = null, ?int $spAttack = null, ?int $spDefense = null) {
            
            if(!isset($nome) && !isset($descricao) && !isset($geracao) && !isset($hp) && !isset($speed) && !isset($attack) && !isset($defense) && !isset($spAttack) && !isset($spDefense)) return;
        
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->geracao = $geracao;
            $this->hp = $hp;
            $this->speed = $speed;
            $this->attack = $attack;
            $this->defense = $defense;
            $this->spAttack = $spAttack;
            $this->spDefense = $spDefense;
        }

        public function getId(): ?int {
            return $this->id;
        }
        public function getNome(): ?string {
            return $this->nome;
        }
        public function getDescricao(): ?string {
            return $this->descricao;
        }
        public function getGeracao(): ?int {
            return $this->geracao;
        }
        public function getHp(): ?int {
            return $this->hp;
        }
        public function getSpeed(): ?int {
            return $this->speed;
        }
        public function getAttack(): ?int {
            return $this->attack;
        }
        public function getDefense(): ?int {
            return $this->defense;
        }
        public function getSpAttack(): ?int {
            return $this->spAttack;
        }
        public function getSpDefense(): ?int {
            return $this->spDefense;
        }
        
        public function setNome(?string $nome): void {
            $this->nome = $nome;
        }
        public function setDescricao(?string $descricao): void {
            $this->descricao = $descricao;
        }
        public function setGeracao(?int $geracao): void {
            $this->geracao = $geracao;
        }
        public function setHp(?int $hp): void {
            $this->hp = $hp;
        }
        public function setSpeed(?int $speed): void {
            $this->speed = $speed;
        }
        public function setAttack(?int $attack): void {
            $this->attack = $attack;
        }
        public function setDefense(?int $defense): void {
            $this->defense = $defense;
        }
        public function setSpAttack(?int $spAttack): void {
            $this->spAttack = $spAttack;
        }
        public function setSpDefense(?int $spDefense): void {
            $this->spDefense = $spDefense;
        }

        public function salvar(){
            $db = getConnection();
            
            if($this->id){
                $sql = "UPDATE pokemon SET nome = :nome, descricao = :descricao, geracao = :geracao, hp = :hp, speed = :speed, attack = :attack, defense = :defense, spAttack = :spAttack, spDefense = :spDefense WHERE id = :id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([ ':nome' => $this->nome, ':descricao' => $this->descricao, ':geracao' => $this->geracao, ':hp' => $this->hp, ':speed' => $this->speed, ':attack' => $this->attack, ':defense' => $this->defense, ':spAttack' => $this->spAttack, ':spDefense' => $this->spDefense, ':id' => $this->id]);
            }
            
            $sql = "INSERT INTO pokemon (nome, descricao, geracao, hp, speed, attack, defense, spAttack, spDefense) VALUES (:nome, :descricao, :geracao, :hp, :speed, :attack, :defense, :spAttack, :spDefense);";
            $stmt = $db->prepare($sql);
            
            $inserido = $stmt->execute([':nome' => $this->nome, ':descricao' => $this->descricao, ':geracao' => $this->geracao, ':hp' => $this->hp, ':speed' => $this->speed, ':attack' => $this->attack, ':defense' => $this->defense, ':spAttack' => $this->spAttack, ':spDefense' => $this->spDefense]);
            
            if($inserido){
                $this->id = (int) $db->lastInsertId();
            }
            
            return $inserido;
        }

        public static function delete($id){
            $db = getConnection();
            $sql = "DELETE FROM pokemon WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        }

        public static function getTodos(){
            $db = getConnection();
            $sql = "SELECT * FROM pokemon;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public static function getById($id, $class = true){
            $db = getConnection();
            $sql = "SELECT * FROM pokemon WHERE id = :id;";
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
            $sql = "SELECT * FROM pokemon WHERE $column = :valor";
            $stmt = $db->prepare($sql);
            $stmt->execute([':valor' => $columnValue]);
            $obj = $stmt->fetch(PDO::FETCH_OBJ);
            if(!$obj){
                return $obj;
            }
            return self::hydrate($obj);
            
        }
        
        public static function hydrate($obj){
                $pokemon = new self();
                $pokemon->id = $obj->id;
                $pokemon->nome = $obj->nome;
                $pokemon->descricao = $obj->descricao;
                $pokemon->geracao = $obj->geracao;
                $pokemon->hp = $obj->hp;
                $pokemon->speed = $obj->speed;
                $pokemon->attack = $obj->attack;
                $pokemon->spAttack = $obj->spAttack;
                $pokemon->defense = $obj->defense;
                $pokemon->spDefense = $obj->spDefense;
                return $pokemon;
        }

    }


?>