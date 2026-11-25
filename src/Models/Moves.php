<?php

    class Moves{

        private ?int $move_id = null;
        private ?string $pokemon_id = null;
        private ?int $posicao = null;

        public function __construct(?int $move_id = null, ?string $pokemon_id = null, ?int $posicao = null){

            if (!isset($move_id) && !isset($pokemon_id) && !isset($posicao)) return;

            $this->move_id = $move_id;
            $this->pokemon_id = $pokemon_id;
            $this->posicao = $posicao;
        }


        public function getMoveId() { return $this->move_id; }
        public function getPokemonId() { return $this->pokemon_id; }
        public function getPosicao() { return $this->posicao; }

        public function setMoveId($move_id) { $this->move_id = $move_id; }
        public function setPokemonId($pokemon_id) { $this->pokemon_id = $pokemon_id; }
        public function setPosicao($posicao) { $this->posicao = $posicao; }
        
        public function salvar($update = false) {
            $db = getConnection();
            if(!$update){
                $sql = "INSERT INTO pokemon_moves (move_id, pokemon_id, posicao) VALUES (:move_id, :pokemon_id, :posicao);";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':move_id'    => $this->move_id,
                    ':pokemon_id'  => $this->pokemon_id,
                    ':posicao'     => $this->posicao
                ]);
            }
            else{
                $sql = "UPDATE pokemon_moves set posicao = :posicao WHERE move_id = :move_id AND pokemon_id = :pokemon_id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':posicao'      => $this->posicao,
                    ':move_id'      => $this->move_id,
                    ':pokemon_id'   => $this->pokemon_id
                ]);
            }
        }

        public static function delete($pokemon_id){
            $db = getConnection();
            $sql = "DELETE FROM pokemon_moves WHERE pokemon_id = :pokemon_id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':pokemon_id' => $pokemon_id
            ]);
        }

        public static function getPokemonMoves($pokemon_id){
            $db = getConnection();
            $sql = "SELECT * FROM pokemon_moves WHERE pokemon_id = :pokemon_id ORDER BY posicao;";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':pokemon_id' => $pokemon_id
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        private static function organizarPosicoes($pokemon_id){
            $moves = getPokemonMoves($pokemon_id);
            if(!empty($moves)){
                $count = 0;
                foreach ($moves as $move) {
                    $move['posicao'] = $count;
                    $count++;
                    $movePosicaoAtualizada = New self($move['move_id'], $move['pokemon_id'], $posicao);
                    $movePosicaoAtualizada->salvar(true);
                }
            }
        }

    }

?>