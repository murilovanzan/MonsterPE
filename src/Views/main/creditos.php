<?php
    $caminhoModelo = $_SERVER['DOCUMENT_ROOT'] . '/MonsterPE/src/Models/Usuario.php';

    if (file_exists($caminhoModelo)) {
        require_once $caminhoModelo;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $nomeSeguro = 'Jogador';
    $emailSeguro = 'email@desconhecido.com';

    if (isset($_SESSION['usuario']) && is_object($_SESSION['usuario']) && method_exists($_SESSION['usuario'], 'getUsername')) {
        $nomeSeguro = $_SESSION['usuario']->getUsername();
        $emailSeguro = $_SESSION['usuario']->getEmail();
    }
    require_once '../../../assets/script/restricoes.php';
    verificaLogin();
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Créditos</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav style="justify-content:space-around;">
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav" style="position: relative;">
          <a class="userview" style="cursor: pointer;" 
            data-username="<?php echo $nomeSeguro; ?>" 
            data-email="<?php echo $emailSeguro; ?>"
            onclick="toggleDropdown(event)">
            <img id="avatar-nav" src="" alt="Avatar">
        </a>
            <a href="../usuario/?acao=logout">Logout</a>
        </div>
    </nav>
    <main class="maindash">
        <div id="tela-equipe" class="menugens" style="display:flex;">
            <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
            
            <div class="layout-creditos">
                <div class="area-creditos">
                        <h2 class="titulo-geracoes">CRIADORES DO MONSTERPE</h2>
                        <div class="grid-creditos">
                            <div class="grid-autores">
                                <div class="slot-autor">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/Davi Gross.jpg" alt="DaviGross img" class="autor-imagem">
                                    <div class="infosautor" >
                                    <span class="item-nome" style="color: black;">DAVI GROSS</span>
                                    <span class="item-preco" style="font-size: 20px;">Davi Gross Viegas da Silva é um dos criadores do jogo MonsterPE, tem 18 anos, é colorado e muito fã de pokémon, e o seu favorito é o Greninja.</span></div>
                                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/showdown/658.gif" class="pokefav" style="width: 230px; height: 150px;">
                                </div>
                                <div class="slot-autor">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/Gabriel Mello.jpg" alt="GabrielMello img" class="autor-imagem">
                                    <div class="infosautor" >
                                    <span class="item-nome" style="color: black;">GABRIEL MELLO</span>
                                    <span class="item-preco" style="font-size: 20px;">Gabriel Mello de Azevedo é um dos criadores do jogo MonsterPE, tem 18 anos, é gremista e muito fã de pokémon, e o seu favorito é a Melloeta.</span></div>
                                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/showdown/648.gif" class="pokefav" style="width: auto; height: 200px;">
                                </div>
                                <div class="slot-autor">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/Murilo Vanzan.jpg" alt="MuriloVanzan img" class="autor-imagem">
                                    <div class="infosautor" >
                                    <span class="item-nome" style="color: black;">MURILO VANZAN</span>
                                    <span class="item-preco" style="font-size: 20px;">Murilo Vanzan da Silva é um dos criadores do jogo MonsterPE, tem 17 anos, é gremista e muito fã de pokémon, e o seu favorito é a Sableye.</span></div>
                                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/showdown/10066.gif" class="pokefav" style="width: auto; height: 200px;">
                                </div>
                            </div>
                        </div>
                            <h2 class="titulo-geracoes">PROFESSORES ORIENTADORES</h2>
                            <div class="grid-professores">
                                <div class="slot-prof">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/Raíssa.png" alt="Raissa" class="autor-imagem">
                                    <span class="item-nome" style="color: black;">Raíssa Scheeren</span>
                                    <span class="item-preco" style="font-size:14px;">Profª de Programação Orientada a Objetos I</span>
                                </div>
                                <div class="slot-prof">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/MarcioB.jpeg" alt="Marcio" class="autor-imagem">
                                    <span class="item-nome" style="color: black;">Márcio Bigolin</span>
                                    <span class="item-preco" style="font-size:14px;">Profª de Linguagens para Internet II</span>
                                </div>
                                <div class="slot-prof">
                                    <img src="/MonsterPE/assets/imgs/CreditosPessoas/Jacqueline.png" alt="Jacqueline" class="autor-imagem">
                                    <span class="item-nome" style="color: black;">Jacqueline Akazaki</span>
                                    <span class="item-preco" style="font-size:14px;">Profª de Banco de Dados II</span>
                                </div>
                            </div>
            </div>
        </div>
     </main>

    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/6VaQrXhea" target="_blank">Clique aqui!</a>
        </div>
</footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/dashboard.js"></script>
<script src="../../../assets/script/time.js"></script>
    <div id="modal-avatar" class="modal-fundo" style="display: none;">
        <div class="modal-card" style="width: 360px; text-align: center;">
            <span class="btn-fechar" onclick="document.getElementById('modal-avatar').style.display='none'">X</span>
            <h3>Escolher Avatar</h3>
            <div class="grid-avatares">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-alola.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-capbackward.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-hoenn.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-johto.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-kalos.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-sinnoh.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-unova.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/marcio.png" onclick="trocarAvatar(this.src)">
            </div>
        </div>
    </div>
</body>
</html>