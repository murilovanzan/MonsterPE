<?php

class Pokemon {

    private ?int $id = null;
    private ?int $usuario_id = null;
    private ?string $pokemon = null;
    private ?int $nivel = 1;
    private ?int $hp = null;
    private ?int $speed = null;
    private ?int $attack = null;
    private ?int $spAttack = null;
    private ?int $defense = null;
    private ?int $spDefense = null;
    private ?int $posicao = null;
    private ?string $item = null;
    private ?string $status = null;

    public function __construct(
        ?int $usuario_id = null,
        ?string $pokemon = null,
        ?int $nivel = 1,
        ?int $hp = null,
        ?int $speed = null,
        ?int $attack = null,
        ?int $spAttack = null,
        ?int $defense = null,
        ?int $spDefense = null,
        ?int $posicao = null,
        ?string $item = null,
        ?string $status = null
    ) {
        if (!isset($usuario_id) && !isset($pokemon)) return;

        $this->usuario_id = $usuario_id;
        $this->pokemon = $pokemon;
        $this->hp = $hp;
        $this->speed = $speed;
        $this->attack = $attack;
        $this->spAttack = $spAttack;
        $this->defense = $defense;
        $this->spDefense = $spDefense;
        $this->posicao = $posicao;
        $this->item = $item;
        $this->status = $status;
    }

    // --- GETTERS ---
    public function getId() { return $this->id; }
    public function getUsuarioId() { return $this->usuario_id; }
    public function getPokemon() { return $this->pokemon; }
    public function getNivel() { return $this->nivel; }
    public function getHp() { return $this->hp; }
    public function getSpeed() { return $this->speed; }
    public function getAttack() { return $this->attack; }
    public function getSpAttack() { return $this->spAttack; }
    public function getDefense() { return $this->defense; }
    public function getSpDefense() { return $this->spDefense; }
    public function getPosicao() { return $this->posicao; }
    public function getItem() { return $this->item; }
    public function getStatus() { return $this->status; }

    // --- SETTERS ---
    public function setUsuario_id($usuario_id) { $this->usuario_id = $usuario_id; }
    public function setPokemon($pokemon) { $this->pokemon = $pokemon; }
    public function setNivel($nivel) { $this->nivel = $nivel; }
    public function setHp($hp) { $this->hp = $hp; }
    public function setSpeed($speed) { $this->speed = $speed; }
    public function setAttack($attack) { $this->attack = $attack; }
    public function setSpAttack($spAttack) { $this->spAttack = $spAttack; }
    public function setDefense($defense) { $this->defense = $defense; }
    public function setSpDefense($spDefense) { $this->spDefense = $spDefense; }
    public function setPosicao($posicao) { $this->posicao = $posicao; }
    public function setItem($item) { $this->item = $item; }
    public function setStatus($status) { $this->status = $status; }

    public function salvar() {
        $db = getConnection();

        $sql = "INSERT INTO pokemon (usuario_id, pokemon, nivel, hp, speed, attack, spAttack, defense, spDefense, posicao, item, status) VALUES (:u_id, :p, :n, :hp, :s, :a, :sa, :d, :sd, :pos, :item, :st);";
        $stmt = $db->prepare($sql);
        $inserido = $stmt->execute([
            ':u_id' => $this->usuario_id,
            ':p'    => $this->pokemon,
            ':n'    => $this->nivel,
            ':hp'   => $this->hp,
            ':s'    => $this->speed,
            ':a'    => $this->attack,
            ':sa'   => $this->spAttack,
            ':d'    => $this->defense,
            ':sd'   => $this->spDefense,
            ':pos'  => $this->posicao,
            ':item' => $this->item,
            ':st'   => $this->status
        ]);
    
        if ($inserido) {
            $this->id = (int) $db->lastInsertId();
        }
        return $inserido;
    
    }

    public static function getUsuarioPokemon($usuario_id) {
        $db = getConnection();
        $sql = "SELECT * FROM pokemon WHERE usuario_id = :usuario_id;";
        $stmt = $db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        $pokemonSalvo = [];
        foreach ($resultados as $obj) {
            array_push($pokemonSalvo, self::hydrate($obj));
        }
        return $pokemonSalvo;
    }

    public static function desativarTime($usuario_id){
        $db = getConnection();
        $sql = "UPDATE pokemon SET ativo = 0 WHERE usuario_id = :id";
        $stmt = $db->prepare($sql);
        $timeInativo = $stmt->execute([':id' => $usuario_id]);

    }

    public static function hydrate($obj) {
        $poke = new self();
        $poke->id = $obj->id;
        $poke->usuario_id = $obj->usuario_id;
        $poke->pokemon = $obj->pokemon;
        $poke->nivel = $obj->nivel;
        $poke->hp = $obj->hp;
        $poke->speed = $obj->speed;
        $poke->attack = $obj->attack;
        $poke->spAttack = $obj->spAttack;
        $poke->defense = $obj->defense;
        $poke->spDefense = $obj->spDefense;
        $poke->posicao = $obj->posicao;
        $poke->item = $obj->item;
        $poke->status = $obj->status;
        return $poke;
    }
}