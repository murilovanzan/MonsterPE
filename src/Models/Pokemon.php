<?php

class Pokemon implements JsonSerializable{

    private ?string $id = null;
    private ?int $usuario_id = null;
    private ?int $api_id = null;
    private ?string $apelido = null;
    private ?int $nivel = null;
    private ?int $hp = null;
    private ?int $speed = null;
    private ?int $attack = null;
    private ?int $spAttack = null;
    private ?int $defense = null;
    private ?int $spDefense = null;
    private ?int $posicao = null;
    private ?int $item = null;
    private ?int $status = null;
    private ?int $ativo = null;

    public function jsonSerialize(): mixed {
        return [
            'id'         => $this->id,
            'usuario_id' => $this->usuario_id,
            'api_id'     => $this->api_id,
            'apelido'    => $this->apelido,
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
        ?string $id = null,
        ?int $usuario_id = null,
        ?int $api_id = null,
        ?string $apelido = null,
        ?int $nivel = null,
        ?int $hp = null,
        ?int $speed = null,
        ?int $attack = null,
        ?int $spAttack = null,
        ?int $defense = null,
        ?int $spDefense = null,
        ?int $posicao = null,
        ?int $item = null,
        ?int $status = null,
        ?int $ativo = null
    ) {
        if (!isset($usuario_id) && !isset($api_id)) return;
        
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->api_id = $api_id;
        $this->apelido = $apelido;
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
    public function getApiId() { return $this->api_id; }
    public function getApelido() { return $this->apelido; }
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
    public function setId($id = null) { 
        
        if(is_null($id)){
            $id = self::gerarUuidV7();
        }

        $this->id = $id; 
    }
    public function setUsuarioId($usuario_id) { $this->usuario_id = $usuario_id; }
    public function setApiId($api_id) { $this->api_id = $api_id; }
    public function setApelido($apelido) { $this->apelido = $apelido; }
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
        if(is_null($this->id)){
            $this->setId();
            $sql = "INSERT INTO pokemon (id, usuario_id, api_id, apelido, nivel, hp, speed, attack, spAttack, defense, spDefense, posicao, item, status, ativo) 
                    VALUES (:id, :u_id, :api_id, :ap, :n, :hp, :s, :a, :sa, :d, :sd, :pos, :item, :st, :ativo);";
            
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':id'    => $this->id,
                ':u_id'  => $this->usuario_id,
                ':api_id'     => $this->api_id,
                ':ap'     => $this->apelido,
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
        
        }
        else{
            $sql = "UPDATE pokemon SET usuario_id = :u_id, api_id = :api_id, apelido = :ap, nivel = :n, hp = :hp, speed = :s, attack = :a, spAttack = :sa, defense = :d, spDefense = :sd, posicao = :pos, item = :item, status = :st, ativo = :ativo WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':u_id'  => $this->usuario_id,
                ':api_id'=> $this->api_id,
                ':ap'    => $this->apelido,
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
                'ativo'  => $this->ativo,
                ':id'    => $this->id
            ]);  
        }
    }

    public static function deletePokemon($id){
        $db = getConnection();
        $sql = "DELETE FROM pokemon WHERE id = :id;";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function getUsuarioPokemon($usuario_id, $ativo = null, $objeto = true) {

        $db = getConnection();
        $sql = "SELECT * FROM pokemon WHERE usuario_id = :usuario_id AND ativo = :ativo ORDER BY posicao;";
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
        $sql = "UPDATE pokemon SET ativo = 0, posicao = null WHERE usuario_id = :id";
        $stmt = $db->prepare($sql);
        $timeInativo = $stmt->execute([':id' => $usuario_id]);
    }

    public static function hydrate($obj) {
        $poke = new self();
        $poke->id         = $obj->id;
        $poke->usuario_id = $obj->usuario_id;
        $poke->api_id    = $obj->api_id;
        $poke->apelido    = $obj->apelido;
        $poke->nivel      = $obj->nivel;
        $poke->hp         = $obj->hp;
        $poke->speed      = $obj->speed;
        $poke->attack     = $obj->attack;
        $poke->spAttack   = $obj->spAttack;
        $poke->defense    = $obj->defense;
        $poke->spDefense  = $obj->spDefense;
        $poke->posicao    = $obj->posicao;
        $poke->item       = $obj->item;
        $poke->status     = $obj->status;
        $poke->ativo      = $obj->ativo;
        return $poke;
    }

    private static function gerarUuidV7(): string {
        
        $tempoMs = (int) (microtime(true) * 1000);
        
        $aleatorio = random_bytes(10);
        
        $bytes = pack('J', $tempoMs << 16);
        $bytes = substr($bytes, 0, 6) . $aleatorio;
        
        $bytes[6] = chr((ord($bytes[6]) & 0x0f) | 0x70);
        $bytes[8] = chr((ord($bytes[8]) & 0x3f) | 0x80);
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
    }

}