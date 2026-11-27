<?php

    class ItemController {

        public function __construct(){
        }

        private function renderizar($view, $pasta = 'pokemon'){
            require_once __DIR__ . "/../Views/{$pasta}/{$view}.php";
        }

        public function loja(){

            if(!isset($_SESSION['usuario'])){
                header("Location: /MonsterPE/src/Views/main/?errorMessage=" . urlencode("Você deve fazer login antes!"));
                exit;
            }

            // Atualiza o saldo da sessão com o valor real do banco
            $usuario = Usuario::getById($_SESSION['usuario']->getId());
            $_SESSION['usuario']->setTokens($usuario->getTokens());

            $this->renderizar('loja', 'main');

        }

        public function comprar(){

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
            $carrinho = $dados['carrinho'] ?? null;

            try{
                $novoSaldo = Item::comprar($_SESSION['usuario']->getId(), $carrinho);
                $_SESSION['usuario']->setTokens($novoSaldo);
                LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::COMPRA,
                    json_encode(['itens' => $carrinho, 'saldo_restante' => $novoSaldo], JSON_UNESCAPED_UNICODE));

                echo json_encode(['sucesso' => true, 'mensagem' => 'Compra realizada com sucesso!', 'saldo' => $novoSaldo]);
            }
            catch (SaldoInsuficienteException | InvalidArgumentException $e){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
            }
            catch (Throwable $e){
                http_response_code(500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao processar a compra. Tente novamente.']);
            }
        }

        // Lista a mochila do usuário (usada pela batalha)
        public function mochila(){

            header('Content-Type: application/json; charset=utf-8');

            if(!isset($_SESSION['usuario'])){
                http_response_code(401);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Você deve fazer login antes!']);
                return;
            }

            $itens = Item::getInventario($_SESSION['usuario']->getId());
            foreach ($itens as $indice => $item) {
                $itens[$indice]['imagem'] = Item::getImagem($item['nome']);
            }

            echo json_encode(['sucesso' => true, 'itens' => $itens]);
        }

        // Gasta um item da mochila. O efeito em batalha é aplicado pelo front-end.
        public function usar(){

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
            $itemId = filter_var($dados['item_id'] ?? null, FILTER_VALIDATE_INT);

            if($itemId === false || $itemId < 1){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Item inválido.']);
                return;
            }

            try{
                $restante = Item::consumir($_SESSION['usuario']->getId(), $itemId);
                LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::USO_ITEM, "item: " . $itemId);
                echo json_encode(['sucesso' => true, 'restante' => $restante]);
            }
            catch (InvalidArgumentException $e){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
            }
            catch (Throwable $e){
                http_response_code(500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao usar o item. Tente novamente.']);
            }
        }

        // Usa a Pedra da Evolução para evoluir um Pokémon (fora da batalha)
        public function evoluir(){

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
            $pokemonId = is_string($dados['pokemon_id'] ?? null) ? $dados['pokemon_id'] : '';
            $itemId = filter_var($dados['item_id'] ?? null, FILTER_VALIDATE_INT);

            if($pokemonId === '' || $itemId === false || $itemId < 1){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Dados inválidos.']);
                return;
            }

            try{
                $usuarioId = $_SESSION['usuario']->getId();
                $resultado = Evolucao::evoluir($usuarioId, $pokemonId, $itemId);
                LogUsuario::registrar($usuarioId, LogUsuario::EVOLUIR,
                    "pokemon: " . $pokemonId . ", de " . $resultado['nomeAntigo'] . " para " . $resultado['nome']);

                echo json_encode(['sucesso' => true, 'nome' => $resultado['nome'], 'restante' => $resultado['restante']]);
            }
            catch (InvalidArgumentException $e){
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
            }
            catch (RuntimeException $e){
                http_response_code(502);
                echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
            }
            catch (Throwable $e){
                http_response_code(500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao evoluir o Pokémon. Tente novamente.']);
            }
        }

        public function cadastrar(){
            $this->renderizar('cadastrar', 'item');
        }

        public function cadastrarItem(){
            if(!$this->validaPost($_POST)){
                $errorMessage = 'Você deve preencher todos os campos.';
                header("Location: ?acao=cadastrar&errorMessage=" . urlencode($errorMessage));
                exit;
            }else{
                try{
                    $item = new Item($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['efeito'], $_POST['preco']);
                    $item->salvar();
                    header("Location: ?acao=login");
                    exit;
                } catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    header("Location: ?acao=cadastro&errorMessage=" . urlencode($errorMessage));
                    exit;
                }
            }
        }

        private function validaPost($post){
            foreach ($post as $input => $dado){
                if(!isset($dado) || empty(trim($dado))){
                    return false;
                }
            }
            return true;
        }

    }

?>