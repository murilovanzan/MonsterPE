<?php

    class PokemonController{

        public function __construct(){

        }

        private function renderizar($view){
            require_once __DIR__ . "/../Views/pokemon/{$view}.php";
        }

        public function listar(){
            $this->renderizar('listar');
        }

    }

?>