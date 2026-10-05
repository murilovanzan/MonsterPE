<?php

    $errorMessage = $_GET['errorMessage'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <form action="?acao=registrar" method="post" id="form">
        
        <input type="text" name="nome" id="nome" maxlength="128">
        <span id="erroNome"></span>
        
        <input type="text" name="username" id="username" maxlength="16">
        <span id="erroUsername"></span>
        
        <input type="email" name="email" id="email" maxlength="320">
        <span id="erroEmail"></span>
        
        <input type="password" name="senha" id="senha">
        <span id="erroSenha"></span>

        <button type="button" id="botaoSenha" onclick="mostrarSenha()">O</button>
        <button type="submit">Cadastrar Usuario</button>
        
        <span id="errorMessage"><?= htmlspecialchars($errorMessage) ?></span>
        
    </form>
    <script src="../../../assets/script/validaFormulario.js"></script>
</body>
</html>