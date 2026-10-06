<?php

    $errorMessage = $_GET['errorMessage'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de cadastro</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav>
        <div class="logonav"><a href="/MonsterPE/src/Views/main/index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex">Discord</a></div>
    </nav>
    <main>
        <div class="formcadastro" style="margin: 100px;">
            <h2><div class="titleform" style="margin-bottom: 5%;">FAÇA SEU CADASTRO</div></h2>
        <form action="?acao=registrar" method="post" id="form">

        <div class="opcadastrform">
       <label for="nome">Nome e sobrenome:</label>
        <input type="text" name="nome" id="nome" placeholder="Digite seu nome aqui..." maxlength="128">
        <span id="erroNome"></span></div>
        
        <div class="opcadastrform">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username" placeholder="Digite seu usuário aqui..." maxlength="16">
        <span id="erroUsername"></span></div>

        <div class="opcadastrform">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" placeholder="Digite seu e-mail aqui..." maxlength="320">
        <span id="erroEmail"></span></div>

        <div class="opcadastrform">
        <label for="senha">Senha:</label>
        <div class="blocosenha">
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha aqui...">
        <span id="erroSenha"></span>
        <button type="button" id="botaoSenha" onclick="mostrarSenha()">Mostrar Senha</button></div></div>
        
        <button type="submit">Cadastrar Usuario</button>
        
        <span id="errorMessage" style="color:red; font-weight:bold; display:flex; align-self:center;"><?= htmlspecialchars($errorMessage) ?></span>
        
    </form>
    </div>
    <script src="../../../assets/script/validaFormulario.js"></script>

</main>
<footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex">Clique aqui!</a>
        </div>
</footer>
</body>
</html>