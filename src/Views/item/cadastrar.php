<?php

    require_once '../../../assets/script/restricoes.php';
    isAdmin();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <form action="index.php?acao=cadastrarItem" method="post">
        <label for="nome">
            <input type="text" id="nome" name="nome">
        </label>
        <label for="descricao">
            <input type="text" id="descricao" name="descricao">
        </label>
        <label for="status">
            <input type="text" id="status" name="status">
        </label>
        <label for="efeito">
            <input type="text" id="efeito" name="efeito">
        </label>
        <label for="preco">
            <input type="number" id="preco" name="preco">
        </label>
        <button type="submit">Enviar dados</button>
    </form>
</body>
</html>