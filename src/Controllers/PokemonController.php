<?php

    class PokemonController {

        public function __construct(){

        }

        private function renderizar($view, $pasta = 'pokemon'){
            require_once __DIR__ . "/../Views/{$pasta}/{$view}.php";
        }

        public function salvar(){

            $dadosBrutos = file_get_contents("php://input");

            $timeJSON = json_decode($dadosBrutos, true);
            $count = 0;
            $vetorErro = [];

            Pokemon::desativarTime($_SESSION['usuario']->getId());

            foreach ($timeJSON as $dadosPokemon){
                $pokemon = new Pokemon(
                    $_SESSION['usuario']->getId(),
                    $dadosPokemon['id'],
                    1,
                    $dadosPokemon['stats'][0]['base_stat'],
                    $dadosPokemon['stats'][5]['base_stat'],
                    $dadosPokemon['stats'][1]['base_stat'],
                    $dadosPokemon['stats'][3]['base_stat'],
                    $dadosPokemon['stats'][2]['base_stat'],
                    $dadosPokemon['stats'][4]['base_stat'],
                    $count    
                );
                $salvarTimeErro = !$pokemon->salvar();
                $count++;
            }
            $_SESSION['salvarTimeErro'] = $salvarTimeErro;
        }

        public function pokemonSalvo(){

            $_SESSION['pokemonSalvo'] = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), false, false);
            $_SESSION['pokemonAtivo'] = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), true, false);
            $this->renderizar("time", "main");
            
        }

    }

?>