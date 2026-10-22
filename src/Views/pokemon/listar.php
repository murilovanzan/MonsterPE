<?php

    require_once '../../../assets/script/restricoes.php';
    verificaLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar</title>
</head>
<body>
    
    <button onclick="Pokemon.showGen('i')">MOSTRAR 1</button>
    <br>
    <button onclick="Pokemon.showGen('ii')">MOSTRAR 2</button>
    <br>
    <button onclick="Pokemon.showGen('iii')">MOSTRAR 3</button>
    <br>
    <button onclick="Pokemon.showGen('iv')">MOSTRAR 4</button>
    <br>
    <button onclick="Pokemon.showGen('v')">MOSTRAR 5</button>
    <br>
    <button onclick="Pokemon.showGen('vi')">MOSTRAR 6</button>
    <br>
    <button onclick="Pokemon.showGen('vii')">MOSTRAR 7</button>
    <br>
    <button onclick="Pokemon.showGen('viii')">MOSTRAR 8</button>
    <br>
    <button onclick="Pokemon.showGen('ix')">MOSTRAR 9</button>
    <br>

    <ul id='pokemon'>



    </ul>


</body>
<script src="../../Models/Pokemon.js"></script>
</html>