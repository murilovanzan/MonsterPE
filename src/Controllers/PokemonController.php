<?php

    class PokemonController {

        public function __construct(){

        }

        private function renderizar($view){
            require_once __DIR__ . "/../Views/pokemon/{$view}.php";
        }
        public function listar(){
            $this->renderizar('listar');
        }
        public function salvar(){
            
            $dadosBrutos = file_get_contents("php://input");

            $timeJSON = json_decode($dadosBrutos, true);
            $count = 0;
            foreach ($timeJSON as $dadosPokemon){
                $pokemon = new Pokemon(
                    $_SESSION['user']->getId(),
                    $dadosPokemon['id'],
                    $dadosPokemon['stats'][0]['base_stat'],
                    $dadosPokemon['stats'][5]['base_stat'],
                    $dadosPokemon['stats'][1]['base_stat'],
                    $dadosPokemon['stats'][3]['base_stat'],
                    $dadosPokemon['stats'][2]['base_stat'],
                    $dadosPokemon['stats'][4]['base_stat'],
                    $count    
                );
                $pokemon->salvar();
            }
            $count++;
        }

    }

?>