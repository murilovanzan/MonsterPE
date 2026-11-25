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
            $posicao = 0;
            $vetorErro = [];

            Pokemon::desativarTime($_SESSION['usuario']->getId());

            foreach ($timeJSON as $dadosPokemon){
                $pokemon = new Pokemon(
                    $dadosPokemon['id'],
                    $_SESSION['usuario']->getId(),
                    $dadosPokemon['api_id'],
                    $dadosPokemon['apelido'],
                    $dadosPokemon['nivel'],
                    $dadosPokemon['stats'][0]['base_stat'],
                    $dadosPokemon['stats'][5]['base_stat'],
                    $dadosPokemon['stats'][1]['base_stat'],
                    $dadosPokemon['stats'][3]['base_stat'],
                    $dadosPokemon['stats'][2]['base_stat'],
                    $dadosPokemon['stats'][4]['base_stat'],
                    $posicao,
                    $dadosPokemon['item'],
                    $dadosPokemon['status'],
                    1
                );
                array_push($vetorErro, !$pokemon->salvar());
                $posicao++;
            }
            foreach ($vetorErro as $erro){
                if($erro){
                    $_SESSION['salvarTimeErro'] = $erro;
                    exit;
                }
                else{
                    $_SESSION['salvarTimeErro'] = $erro;
                }
            }
        }

        public function salvarMoves(){

            $dadosBrutos = file_get_contents("php://input");
            $dados = json_decode($dadosBrutos, true);
            $movesPokemon = $dados['moves'];
            $pokemon_id = $dados['pokemon_id'];

            $posicao = 0;
            $vetorErro = [];
            Moves::delete($pokemon_id);
            foreach ($movesPokemon as $moves) {
                $move = new Moves(
                    $moves['id'],
                    $pokemon_id,
                    $posicao
                );
                array_push($vetorErro, !$move->salvar());
                $posicao++;
            }

        }

        public function time(){

            $_SESSION['pokemonSalvo'] = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 0);
            $_SESSION['pokemonAtivo'] = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 1);
            $_SESSION['moves'] = [];
            foreach ($_SESSION['pokemonAtivo'] as $pokemon){
                array_push($_SESSION['moves'], Moves::getPokemonMoves($pokemon->getId()));
            }
            $this->renderizar("time", "main");
            
        }

        public function limparTime(){
            Pokemon::desativarTime($_SESSION['usuario']->getId());

            header('location: ?acao=time');
        }

        public function excluir(){
            
            $id = file_get_contents("php://input");
            
            Pokemon::deletePokemon($id);
        }

        public function batalha(){

            $_SESSION['pokemonAtivo'] = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 1);
            
            $this->renderizar("batalha", "main");
        }

    }

?>