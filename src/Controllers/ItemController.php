<?php

    class ItemController {

        public function __construct(){
        }

        private function renderizar($view, $pasta = 'pokemon'){
            require_once __DIR__ . "/../Views/{$pasta}/{$view}.php";
        }

        public function loja(){
            require_once '../../../assets/script/restricoes.php';
            verificaLogin();
            $this->renderizar('loja', 'main');
        }

    }

?>