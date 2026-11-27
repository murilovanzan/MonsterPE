<?php

    class UsuarioController {

        public function __construct(){

        }

        private function renderizar($view, array $dados = []){
            extract($dados);
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
                    LogUsuario::registrar($usuario->getId(), LogUsuario::CADASTRO, "username: " . $usuario->getUsername());
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
                    LogUsuario::registrar($user->getId(), LogUsuario::LOGIN, "username: " . $user->getUsername());
                    session_regenerate_id(true);
                    header("Location: ../main/dashboard.php");
                    exit;
                }
                else{
                    $errorMessage = 'Senha incorreta.';
                    LogUsuario::registrar($user->getId(), LogUsuario::LOGIN_FALHOU, "senha incorreta");
                    header("Location: ?acao=login&errorMessage=" . urlencode($errorMessage));
                    exit;
                }
            }
            else{
                $errorMessage = 'Usuário não encontrado.';
                LogUsuario::registrar(null, LogUsuario::LOGIN_FALHOU, "usuário inexistente: " . $_POST['username']);
                header("Location: ?acao=login&errorMessage=" . urlencode($errorMessage));
                exit;
            }
        }

        public function editar() {
            if (empty($_SESSION['login']) || empty($_SESSION['usuario'])) {
                header("Location: ?acao=login&errorMessage=" . urlencode("Faça login para editar suas informações."));
                exit;
            }

            // Busca sempre pelo ID salvo na sessão (previne IDOR)
            $usuario = Usuario::getById($_SESSION['usuario']->getId());
            $_SESSION['usuario'] = $usuario;

            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            $errorMessage   = $_SESSION['flash_erro'] ?? '';
            $successMessage = $_SESSION['flash_sucesso'] ?? '';
            unset($_SESSION['flash_erro'], $_SESSION['flash_sucesso']);

            $this->renderizar('editar', [
                'usuario'        => $usuario,
                'csrfToken'      => $_SESSION['csrf_token'],
                'errorMessage'   => $errorMessage,
                'successMessage' => $successMessage
            ]);
        }

        public function atualizar() {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header("Location: ?acao=editar");
                exit;
            }

            if (empty($_SESSION['login']) || empty($_SESSION['usuario'])) {
                header("Location: ?acao=login&errorMessage=" . urlencode("Sessão expirada. Faça login novamente."));
                exit;
            }

            // Proteção CSRF
            $csrfPost = $_POST['csrf_token'] ?? '';
            if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfPost)) {
                $_SESSION['flash_erro'] = "Requisição inválida. Atualize a página e tente novamente.";
                header("Location: ?acao=editar");
                exit;
            }

            try {
                // Recarrega o usuário real do banco usando APENAS o ID da sessão
                $usuario = Usuario::getById($_SESSION['usuario']->getId());

                // Confirmação obrigatória da senha atual
                $senhaAtual = $_POST['senha_atual'] ?? '';
                if ($senhaAtual === '' || !password_verify($senhaAtual, $usuario->getSenha())) {
                    throw new Exception("A senha atual informada está incorreta.");
                }

                $nome     = $_POST['nome'] ?? '';
                $username = $_POST['username'] ?? '';
                $email    = $_POST['email'] ?? '';

                if (trim($nome) === '' || trim($username) === '' || trim($email) === '') {
                    throw new Exception("Nome, nome de usuário e e-mail são obrigatórios.");
                }

                // Atualiza somente colunas permitidas (nunca altera id, adm ou tokens)
                $usuario->setNome($nome);
                $usuario->setUsername($username);
                $usuario->setEmail($email);

                if (array_key_exists('foto', $_POST)) {
                    $usuario->setFoto($_POST['foto']);
                }

                // Nova senha é opcional: só troca se preenchida
                $novaSenha      = $_POST['nova_senha'] ?? '';
                $confirmarSenha = $_POST['confirmar_senha'] ?? '';

                if ($novaSenha !== '' || $confirmarSenha !== '') {
                    if ($novaSenha !== $confirmarSenha) {
                        throw new Exception("A nova senha e a confirmação não coincidem.");
                    }
                    $usuario->setSenha($novaSenha);
                }

                $usuario->salvar();
                LogUsuario::registrar($usuario->getId(), LogUsuario::EDITAR_PERFIL,
                    "username: " . $usuario->getUsername() . ($novaSenha !== '' ? " (senha alterada)" : ""));

                // Sincroniza a sessão e renova o token CSRF
                $_SESSION['usuario'] = $usuario;
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['flash_sucesso'] = "Informações atualizadas com sucesso!";

                header("Location: ?acao=editar");
                exit;

            } catch (Exception $e) {
                $_SESSION['flash_erro'] = $e->getMessage();
                header("Location: ?acao=editar");
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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['usuario']) && is_object($_SESSION['usuario'])) {
                LogUsuario::registrar($_SESSION['usuario']->getId(), LogUsuario::LOGOUT);
            }

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