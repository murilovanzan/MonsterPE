<?php

    class ItemController {

        public function __construct(){
        }

        private function renderizar($view, $pasta = 'pokemon'){
            require_once __DIR__ . "/../Views/{$pasta}/{$view}.php";
        }

        public function loja(){

            $this->renderizar('loja', 'main');

        }

        public function comprar(){
            
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