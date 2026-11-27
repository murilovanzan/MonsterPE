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
    if(isset($_SESSION['erroBatalha'])){
        $erroBatalha = $_SESSION['erroBatalha'];
        unset($_SESSION['erroBatalha']);
    }
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
    <title>Página do usuário</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=3">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav>
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav" style="position: relative;">
          <a class="userview" style="cursor: pointer;" 
            data-username="<?php echo $nomeSeguro; ?>" 
            data-email="<?php echo $emailSeguro; ?>"
            onclick="toggleDropdown(event)">
            <img id="avatar-nav" src="" alt="Avatar">
        </a>
            <span></span>
            <a href="../usuario/?acao=logout" class="btn-logout">| Logout</a>
        </div>
    </nav>
    <div class="conteudo">

        <span><?= $erroBatalha?></span>
        <aside class="dashaside modo-inicial">
                <div class="opdashmain">
            <a href="../main" class="dashmainclick" id="jogarpoke">JOGAR</a>
        </div>
        <div class="opdashmain">
            <a id="verpoke" class="dashmainclick" style="margin-right:15px;">VER POKÉMON</a>
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
            <button onclick="iniciarJogo()">JOGAR <img src="/MonsterPE/assets/imgs/MonsterPE.png" style="height: 35px; width: auto;"></button>
            <button onclick="telaMontarEquipe()">MONTAR EQUIPE <img src="/MonsterPE/assets/imgs/Equipe2.png" alt="" style="height: 60px; width: auto; transform: scale(1.3); padding-right:50px;"></button>   
            <button onclick="IrAoCentro()"><img class="pokemart" src="/MonsterPE/assets/imgs/pokecenter.png" alt="" style="height: 60px; margin-top: 10px; width: auto; transform: scale(2.5);"></button>   
            <button onclick="irParaLoja()"><img class="pokecenter" src="/MonsterPE/assets/imgs/pokemart.png" alt="" style="height: 60px; margin-top: 2px; width: auto; transform: scale(1.6);"></button>
            <button onclick="Creditos()">CRÉDITOS</button>
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
          <a href="https://discord.gg/6VaQrXhea" target="_blank">Clique aqui!</a>
        </div>
</footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/dashboard.js"></script>
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