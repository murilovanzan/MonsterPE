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

    }


?>