<?php

class Pokemon implements JsonSerializable{

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
    private ?int $ativo = 1;

    public function jsonSerialize(): mixed {
        return [
            'id'         => $this->id,
            'usuario_id' => $this->usuario_id,
            'pokemon'    => $this->pokemon,
            'nivel'      => $this->nivel,
            'hp'         => $this->hp,
            'speed'      => $this->speed,
            'attack'     => $this->attack,
            'spAttack'   => $this->spAttack,
            'defense'    => $this->defense,
            'spDefense'  => $this->spDefense,
            'posicao'    => $this->posicao,
            'item'       => $this->item,
            'status'     => $this->status,
            'ativo'      => $this->ativo
        ];
    }

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
        ?string $status = null,
        ?int $ativo = 1
    ) {
        if (!isset($usuario_id) && !isset($pokemon)) return;

        $this->usuario_id = $usuario_id;
        $this->pokemon = $pokemon;
        $this->nivel = $nivel;
        $this->hp = $hp;
        $this->speed = $speed;
        $this->attack = $attack;
        $this->spAttack = $spAttack;
        $this->defense = $defense;
        $this->spDefense = $spDefense;
        $this->posicao = $posicao;
        $this->item = $item;
        $this->status = $status;
        $this->ativo = $ativo;
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
    public function getAtivo() { return $this->ativo; }

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
    public function setAtivo($ativo) { $this->ativo = $ativo; }

    public function salvar() {
        $db = getConnection();

        // Incluindo 'ativo' e 'status' no INSERT
        $sql = "INSERT INTO pokemon (usuario_id, pokemon, nivel, hp, speed, attack, spAttack, defense, spDefense, posicao, item, status, ativo) 
                VALUES (:u_id, :p, :n, :hp, :s, :a, :sa, :d, :sd, :pos, :item, :st, :ativo);";
        
        $stmt = $db->prepare($sql);
        $inserido = $stmt->execute([
            ':u_id'  => $this->usuario_id,
            ':p'     => $this->pokemon,
            ':n'     => $this->nivel,
            ':hp'    => $this->hp,
            ':s'     => $this->speed,
            ':a'     => $this->attack,
            ':sa'    => $this->spAttack,
            ':d'     => $this->defense,
            ':sd'    => $this->spDefense,
            ':pos'   => $this->posicao,
            ':item'  => $this->item,
            ':st'    => $this->status,
            ':ativo' => $this->ativo
        ]);
    
        if ($inserido) {
            $this->id = (int) $db->lastInsertId();
        }
        return $inserido;
    }

    public static function getUsuarioPokemon($usuario_id, $ativo = null, $objeto = true) {

        $db = getConnection();
        $sql = "SELECT * FROM pokemon WHERE usuario_id = :usuario_id AND ativo = :ativo;";
        $stmt = $db->prepare($sql);
        $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':ativo' => $ativo
        ]);

        if(!$objeto){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            $pokemonSalvo = [];
            foreach ($resultados as $obj) {
                array_push($pokemonSalvo, self::hydrate($obj));
            }
            return $pokemonSalvo;
        }

    }

    public static function desativarTime($usuario_id){
        $db = getConnection();
        $sql = "UPDATE pokemon SET ativo = 0 WHERE usuario_id = :id";
        $stmt = $db->prepare($sql);
        $timeInativo = $stmt->execute([':id' => $usuario_id]);
    }

    public static function hydrate($obj) {
        $poke = new self();
        $poke->id         = $obj->id ?? null;
        $poke->usuario_id = $obj->usuario_id ?? null;
        $poke->pokemon    = $obj->pokemon ?? null;
        $poke->nivel      = $obj->nivel ?? 1;
        $poke->hp         = $obj->hp ?? null;
        $poke->speed      = $obj->speed ?? null;
        $poke->attack     = $obj->attack ?? null;
        $poke->spAttack   = $obj->spAttack ?? $obj->spattack ?? null;
        $poke->defense    = $obj->defense ?? null;
        $poke->spDefense  = $obj->spDefense ?? $obj->spdefense ?? null;
        $poke->posicao    = $obj->posicao ?? null;
        $poke->item       = $obj->item ?? null;
        $poke->status     = $obj->status ?? null;
        $poke->ativo      = $obj->ativo ?? 1;
        return $poke;
    }
}