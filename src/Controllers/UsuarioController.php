<?php

    class UsuarioController {

        public function __construct(){

        }

        private function renderizar($view){
            require_once __DIR__ . "/../Views/usuario/{$view}.php";
        }
        public function cadastro(){
            $this->renderizar('cadastro');
        }
        public function login(){
            $this->renderizar('login');
        }

        public function registrar(){

            if(!$this->validaPost($_POST)){
                $errorMessage = 'Você deve preencher todos os campos.';
                header("Location: ?acao=cadastro&errorMessage=" . urlencode($errorMessage));
                exit;
            }
            else{
                try{
                    $usuario = new Usuario($_POST['nome'], $_POST['username'], $_POST['email'], $_POST['senha'], false, null);
                    $usuario->salvar();
                    header("Location: ?acao=login");
                    exit;
                }
                catch (Exception $e){
                    $errorMessage = $e->getMessage();
                    header("Location: ?acao=cadastro&errorMessage=" . urlencode($errorMessage));
                    exit;
                }
            }
        }

        public function fazerLogin(){
            if(!$this->validaPost($_POST)){
                $errorMessage = 'Você deve preencher todos os campos.';
                header("Location: ?acao=login&errorMessage=" . urlencode($errorMessage));
                exit;
            }

            $user = Usuario::getBycolumn($_POST['username'], 'username');

            if($user){

                if(password_verify($_POST['senha'], $user->getSenha())){
                    $_SESSION['usuario'] = $user;
                    $_SESSION['login'] = true;
                    $_SESSION['isAdmin'] = $user->getAdm();
                    session_regenerate_id(true);
                    header("Location: ../main/dashboard.php");
                    exit;
                }
                else{
                    $errorMessage = 'Senha incorreta.';
                    header("Location: ?acao=login&errorMessage=" . urlencode($errorMessage));
                    exit;
                }
            }
            else{
                $errorMessage = 'Usuário não encontrado.';
                header("Location: ?acao=login&errorMessage=" . urlencode($errorMessage));
                exit;
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
        
        public function logout(){
            session_start();

            $_SESSION = array();

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            session_destroy();

            header('Location: /MonsterPE');
            exit();

        }

        
    }

?>