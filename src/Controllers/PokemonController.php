<?php

    class PokemonController {

        public function __construct(){

        }

        private function renderizar($view, $pasta = 'pokemon'){
            require_once __DIR__ . "/../Views/{$pasta}/{$view}.php";
        }

        public function time(){

            $this->renderizar("time", "main");
            
        }

        public function getPokemonAndMoves(){

            header('Content-Type: application/json');
            
            $pokemonSalvo = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 0);
            $pokemonAtivo = Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 1);
            $moves = [];
            foreach ($pokemonAtivo  as $pokemon){
                array_push($moves, Moves::getPokemonMoves($pokemon->getId()));
            }
            
            echo json_encode([$pokemonSalvo, $pokemonAtivo, $moves]);
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
            LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::SALVAR_TIME, count((array) $timeJSON) . " Pokémon no time");
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

            LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::SALVAR_MOVES, "pokemon: " . $pokemon_id);
        }

        public function limparTime(){

            Pokemon::desativarTime($_SESSION['usuario']->getId());
            LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::LIMPAR_TIME);

            header('location: ?acao=time');
        }

        public function excluir(){
            
            $id = file_get_contents("php://input");
            
            Pokemon::deletePokemon($id);
            LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::EXCLUIR_POKEMON, "pokemon: " . $id);
        }

        public function batalha(){
            
            if(empty(Pokemon::getUsuarioPokemon($_SESSION['usuario']->getId(), 1))){
                $_SESSION['erroBatalha'] = "Você deve selecionar um pokemon primeiro";
                header('location: ../main/dashboard.php');
                exit;
            }
            // Cria a linha da batalha no log; a tela envia o resultado ao final
            try {
                $_SESSION['batalha_id'] = LogBatalha::iniciar((int) $_SESSION['usuario']->getId());
            } catch (Throwable $e) {
                error_log("MonsterPE - falha ao iniciar log de batalha: " . $e->getMessage());
                $_SESSION['batalha_id'] = 0;
            }

            $this->renderizar("batalha", "main");
        }

        // Recebe o resultado da batalha (vitória, derrota ou fuga) e as mensagens do combate
        public function finalizarBatalha(){

            header('Content-Type: application/json; charset=utf-8');

            if(!isset($_SESSION['usuario'])){
                http_response_code(401);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Você deve fazer login antes!']);
                return;
            }

            if($_SERVER['REQUEST_METHOD'] !== 'POST'){
                http_response_code(405);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido.']);
                return;
            }

            $dados = json_decode(file_get_contents("php://input"), true);
            $batalhaId = filter_var($dados['batalha_id'] ?? null, FILTER_VALIDATE_INT);

            try{
                LogBatalha::finalizar(
                    $_SESSION['usuario']->getId(),
                    (int) $batalhaId,
                    (string) ($dados['resultado'] ?? ''),
                    (int) ($dados['rounds'] ?? 0),
                    is_array($dados['eventos'] ?? null) ? $dados['eventos'] : []
                );
                echo json_encode(['sucesso' => true]);
            }
            catch (InvalidArgumentException $e){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
            }
            catch (Throwable $e){
                http_response_code(500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao registrar a batalha.']);
            }
        }



    }

?>