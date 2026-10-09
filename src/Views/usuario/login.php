<?php

    $errorMessage = $_GET['errorMessage'] ?? '';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav>
        <div class="logonav"><a href="/MonsterPE/src/Views/main/"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php" target="_blank">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php" target="_blank">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php" target="_blank">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php" target="_blank">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex" target="_blank">Discord</a></div>
    </nav>
    <main>
        <div class="formcadastro" style="margin: 100px;" >
            <h2><div class="titleform" style="margin-bottom: 5%;">FAÇA SEU LOGIN</div></h2>
        <form action="?acao=fazerLogin" method="POST" style="padding-top:50px">
            <div class="opcadastrform">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Digite seu usuário aqui...">
                </div>
            <div class="opcadastrform">
                <label for="password">Password:</label>
                <input type="password" id="password" name="senha" placeholder="Digite sua senha aqui...">
            </div>
            <button type="submit">Login</button>    
            <span id="errorMessage" style="color:red; font-weight:bold; display:flex; align-self:center;"><?= htmlspecialchars($errorMessage) ?></span>
        </form>
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
<?php

    $errorMessage = $_GET['errorMessage'] ?? '';
?>