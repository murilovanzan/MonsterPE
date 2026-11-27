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