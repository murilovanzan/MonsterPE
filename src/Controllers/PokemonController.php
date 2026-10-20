<?php

    class PokemonController{

        public function __construct(){

        }

        private function renderizar($view, $dados = []){
            require_once __DIR__ . "/../Views/pokemon/{$view}.php";
        }

        public function listar(){

            $model = new Pokemon();

            $pokemons = $model->getTodos();
            
            $this->renderizar('listar', $pokemons);
        }

    }

?>