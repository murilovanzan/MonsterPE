<?php
// Garante que a view não seja acessada diretamente fora do Controller
if (!isset($usuario) || !($usuario instanceof Usuario)) {
    header("Location: ?acao=editar");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Informações - MonsterPE</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=4">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav>
        <div class="logonav">
            <a href="/MonsterPE/src/Views/main/dashboard.php">
                <img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
            </a>
        </div>
        <div class="opnav">
            <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php" target="_blank">Dúvidas</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/guia.php" target="_blank">Guias</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php" target="_blank">Jogos de Pokémon</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/animes.php" target="_blank">Anime</a>|
            <a href="https://discord.gg/uaCCbWHex" target="_blank">Discord</a>
        </div>
    </nav>

    <main style="height: auto; min-height: 80vh;">
        <div class="formeditar">
            <h2 class="titleform" style="font-size: 32px; margin: 0 0 15px 0; text-align: center;">
                EDITAR INFORMAÇÕES
            </h2>

            <?php if (!empty($errorMessage)): ?>
                <div style="background: rgba(255,0,0,0.85); color: #fff; padding: 10px; border-radius: 6px; width: 100%; text-align: center; margin-bottom: 10px; box-sizing: border-box;">
                    <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($successMessage)): ?>
                <div style="background: rgba(34,139,34,0.9); color: #fff; padding: 10px; border-radius: 6px; width: 100%; text-align: center; margin-bottom: 10px; box-sizing: border-box;">
                    <?= htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>

            <form action="?acao=atualizar" method="post" id="formEditar">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

                <div class="opcadastrform">
                    <label for="nome">Nome e sobrenome:</label>
                    <input type="text" name="nome" id="nome" maxlength="128" required
                           value="<?= htmlspecialchars($usuario->getNome() ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="opcadastrform">
                    <label for="username">Nome de usuário:</label>
                    <input type="text" name="username" id="username" maxlength="16" required
                           pattern="[a-zA-Z0-9_.\-]+"
                           title="Use apenas letras, números, ponto (.), hífen (-) ou underline (_)"
                           value="<?= htmlspecialchars($usuario->getUsername() ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="opcadastrform">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" maxlength="320" required
                           value="<?= htmlspecialchars($usuario->getEmail() ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="opcadastrform">
                    <label for="foto">Caminho da Foto / Avatar (opcional):</label>
                    <input type="text" name="foto" id="foto" maxlength="128"
                           placeholder="/MonsterPE/assets/imgs/avatar.png"
                           value="<?= htmlspecialchars($usuario->getFoto() ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="opcadastrform">
                    <label for="nova_senha">Nova senha (deixe em branco para manter a atual):</label>
                    <div class="blocosenha">
                        <input type="password" name="nova_senha" id="nova_senha" minlength="6" placeholder="Nova senha (opcional)">
                        <button type="button" onclick="alternarSenha('nova_senha', this)">Mostrar</button>
                    </div>
                </div>

                <div class="opcadastrform">
                    <label for="confirmar_senha">Confirmar nova senha:</label>
                    <div class="blocosenha">
                        <input type="password" name="confirmar_senha" id="confirmar_senha" minlength="6" placeholder="Repita a nova senha">
                        <button type="button" onclick="alternarSenha('confirmar_senha', this)">Mostrar</button>
                    </div>
                </div>

                <div class="opcadastrform" style="border: 2px solid #ffcb05;">
                    <label for="senha_atual"><strong>Senha atual (obrigatória para salvar):</strong></label>
                    <div class="blocosenha">
                        <input type="password" name="senha_atual" id="senha_atual" required placeholder="Digite sua senha atual">
                        <button type="button" onclick="alternarSenha('senha_atual', this)">Mostrar</button>
                    </div>
                </div>

                <div class="acoes-editar">
                    <a href="/MonsterPE/src/Views/main/dashboard.php" class="btn-voltar-edicao">Voltar</a>
                    <button type="submit" class="btn-salvar-edicao">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot">Entre na nossa comunidade do discord!
            <a href="https://discord.gg/uaCCbWHex">Clique aqui!</a>
        </div>
    </footer>

    <script>
        function alternarSenha(idCampo, botao) {
            const input = document.getElementById(idCampo);
            if (input.type === 'password') {
                input.type = 'text';
                botao.textContent = 'Ocultar';
            } else {
                input.type = 'password';
                botao.textContent = 'Mostrar';
            }
        }
    </script>
</body>
</html>
