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
            <button onclick="Pokemon.showGen('i')">1ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('ii')">2ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('iii')">3ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('iv')">4ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('v')">5ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('vi')">6ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('vii')">7ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('viii')">8ª GERAÇÃO</button>
            <button onclick="Pokemon.showGen('ix')">9ª GERAÇÃO</button>
        </div>
        <div id="opjogar" class="menugens">
            <h2 class="titulo-geracoes">ESCOLHA UMA AÇÃO</h2>
            <button onclick="montarEquipe()">MONTAR EQUIPE</button>
            <button onclick="iniciarJogo()">JOGAR <img src="/MonsterPE/assets/imgs/MonsterPE.png"></button>
        </div>
        <div id="tela-equipe" class="menugens">
            <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
            <div class="layout-equipe">
                <div class="area-time">
                    <h2 class="titulo-geracoes" style="font-size: 40px;">Meu Time</h2>
                    <div class="grid-time" id="grid-time">
                        <div class="slot-pokemon">1</div>
                        <div class="slot-pokemon">2</div>
                        <div class="slot-pokemon">3</div>
                        <div class="slot-pokemon">4</div>
                        <div class="slot-pokemon">5</div>
                        <div class="slot-pokemon">6</div>
                    </div>
                    <button id="btn-salvar-time" onclick="salvarTimeFinal()">SALVAR TIME COMPLETO</button>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">Buscar</h2>
                    <input type="search" id="input-busca"  name="q" placeholder="Nome ou Número (ex: pikachu, 25)">
                    <button onclick="buscarPokemonDaApi()" class="btn-buscar">Pesquisar</button>
                    <div id="resultado-pesquisa"></div>
                </div>
            </div>
        </div>
        <div id="voltargen" class="menugens">
            <button onclick="voltarParaGeracoes()">⬅ Voltar para gerações</button>
        <ul id='pokemon'> </ul>
        </main>
    </div>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex" target="_blank">Clique aqui!</a>
        </div>
</footer>
<script src="../../Models/Pokemon.js"></script>
<script src="../../../assets/script/dashboard.js"></script>
</body>
</html>