<?php

    require_once '../../../assets/script/restricoes.php';
    verificaLogin();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do usuário</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav style="justify-content:space-around;">
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
            <a class="userview"> Usuário</a>|
            <a href="../usuario/?acao=logout" >Logout</a>
        </div>
    </nav>
    <div class="conteudo">
        <aside class="dashaside">
        <div class="opdashmain">
            <a id="verpoke" class="dashmainclick">VER POKÉMON</a>
            <ul class="ulescondida">
                <li>Aqui é possível visualizar os pokémons separados por geração podendo voltar depois para entrar na aba Jogar e escolher seu time depois de ver todas opções.</li>
            </ul>
        </div>
        <div class="opdashmain">
            <a href="../main" class="dashmainclick" id="jogarpoke">JOGAR</a>
            <ul class="ulescondida">
                <li>Aqui você terá duas opções uma para montar a sua equipe e outra para jogar o MonsterPE.
            </ul>
        </div>
    </aside>
    <main class="maindash">
        <div id="opgens" class="menugens">
            <h2 class="titulo-geracoes">MOSTRAR POKÉMON PELA GERAÇÃO</h2>
            <button onclick="showGen('i')">1ª GERAÇÃO</button>
            <button onclick="showGen('ii')">2ª GERAÇÃO</button>
            <button onclick="showGen('iii')">3ª GERAÇÃO</button>
            <button onclick="showGen('iv')">4ª GERAÇÃO</button>
            <button onclick="showGen('v')">5ª GERAÇÃO</button>
            <button onclick="showGen('vi')">6ª GERAÇÃO</button>
            <button onclick="showGen('vii')">7ª GERAÇÃO</button>
            <button onclick="showGen('viii')">8ª GERAÇÃO</button>
            <button onclick="showGen('ix')">9ª GERAÇÃO</button>
        </div>
        <div id="opjogar" class="menugens">
            <h2 class="titulo-geracoes">ESCOLHA UMA AÇÃO</h2>
            <button onclick="telaMontarEquipe()">MONTAR EQUIPE</button>
            <button onclick="iniciarJogo()">JOGAR <img src="/MonsterPE/assets/imgs/MonsterPE.png"></button>
        </div>
        
        <div id="voltargen" class="menugens">
            <button onclick="voltarParaGeracoes()">⬅ Voltar para gerações</button>
        <ul id='pokemon'></ul>
        </main>
    </div>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex" target="_blank">Clique aqui!</a>
        </div>
</footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/dashboard.js"></script>
</body>
</html>