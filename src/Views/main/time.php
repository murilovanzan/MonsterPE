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

    if(isset($_SESSION['salvarTimeErro'])){
        if($_SESSION['salvarTimeErro']){
            $salvarTimeErro = "Não foi possivel salvar o time com sucesso!";
            unset($_SESSION['salvarTimeErro']);
        }
        else{
            $salvarTimeErro = "Time salvo com sucesso!";
            unset($_SESSION['salvarTimeErro']);
            echo "<script>
                    var audioSucesso = new Audio('/MonsterPE/assets/songs/Salvar time Song.mp3#t=0,15');
                    audioSucesso.volume = 0.2;
                    audioSucesso.play().catch(function(erro) {
                        console.log('Erro ao tocar áudio: ', erro);
                    });
                </script>";
        }
    }
    else{
        $salvarTimeErro = "";
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
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <style>
        .layout-banco {
            height: auto !important;
            max-height: none !important;
            display: flex;
            flex-direction: column;
            padding-bottom: 30px !important;
        }

        .grid-bank, #pokemonSalvo {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center;
            gap: 15px;
            height: auto !important;
            max-height: none !important;
        }

        .cartao-pokemon {
            height: auto !important;
            min-height: 350px !important;
        }

    </style>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/time.js"></script>
    <script type="module">
        getPokemonAndMoves();
    </script>
</head>
<body>
    <nav style="justify-content:space-around; margin-bottom: 10px !important; position: relative; z-index: 100;">
        <div class="logonav"><a href="../main/index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav" style="position: relative;">
             <a class="userview" style="cursor: pointer;" 
                data-username="<?php echo $nomeSeguro; ?>" 
                data-email="<?php echo $emailSeguro; ?>"
                onclick="toggleDropdown(event)">
                <img id="avatar-nav" src="" alt="Avatar">
            </a>
            <a href="../usuario/?acao=logout">Logout</a>
    </nav>
<main style="padding-top: 50px !important; padding-bottom: 267px; display: block !important;">
        <div id="tela-equipe" class="menugens" style="display:flex; min-height: 700px;">
            <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
            <div class="layout-equipe" id="time" style="display: flex;">
                <div class="area-time">
                    <h2 class="titulo-geracoes" style="font-size: 40px; margin-bottom:15px; padding-bottom:10px;">Meu Time</h2>
                    <div class="grid-time" id="grid-time">
                        <div class="slot-pokemon">1</div>
                        <div class="slot-pokemon">2</div>
                        <div class="slot-pokemon">3</div>
                        <div class="slot-pokemon">4</div>
                        <div class="slot-pokemon">5</div>
                        <div class="slot-pokemon">6</div>
                    </div>
                    <button id="btn-salvar-time" class="btn-time" onclick="salvarTime()">SALVAR TIME COMPLETO</button>
                    <button id="btn-limpar-time" class="btn-time" onclick="limparTime()">LIMPAR TIME</button>
                    <span class="titulo-geracoes" style="font-size: 25px; padding-left:150px; padding-top: 25px;">
                        <?= $salvarTimeErro?>
                    </span>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">Buscar</h2>
                    <input type="search" id="input-busca"  name="q" placeholder="Nome ou Número (ex: pikachu, 25)">
                    <button onclick="showCard()" class="btn-buscar">Pesquisar</button>
                    <div id="resultado-pesquisa"></div>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">Ataques</h2>
                    <button onclick="toggleMoves()" class="btn-buscar">Escolher ataques</button>
                </div>
            </div>
            <div class="layout-equipe" id="time-moves" style="display: none;">
                <div class="area-time">
                    <h2 class="titulo-geracoes" style="font-size: 40px;">ESCOLHER ATAQUES</h2>
                    <div class="grid-time" id="grid-time-ataques">
                        <div class="slot-pokemon">1</div>
                        <div class="slot-pokemon">2</div>
                        <div class="slot-pokemon">3</div>
                        <div class="slot-pokemon">4</div>
                        <div class="slot-pokemon">5</div>
                        <div class="slot-pokemon">6</div>
                    </div>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">⬅Montar Time</h2>
                    <button onclick="toggleMoves()" class="btn-buscar">Voltar Para Montagem</button>
                </div>
            </div>

            <div class="layout-equipe" id="moves" style="display: none;">
                <div class="area-time">
                    <h2 class="titulo-geracoes" style="font-size: 40px;">ESCOLHER ATAQUES</h2>
                    <div class="grid-time" id="grid-ataques">
                        <div class="slot-pokemon">1</div>
                        <div class="slot-pokemon">2</div>
                        <div class="slot-pokemon">3</div>
                        <div class="slot-pokemon">4</div>
                    </div>
                    <button id="btn-salvar-ataques" class="btn-time" style="display: block;" onclick="salvarMoves()">SALVAR MOVES</button>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">Buscar</h2>
                    <input type="search" id="input-busca-move"  name="q" placeholder="Nome ou Número (ex: pikachu, 25)">
                    <button onclick="showMove()" class="btn-buscar">Escolher ataque</button>
                    <div id="resultado-pesquisa-move"></div>
                </div>
                <div class="area-pesquisa">
                    <h2 class="titulo-geracoes" style="font-size: 30px;">VER TIME COMPLETO</h2>
                    <button onclick="editarMoves()" class="btn-buscar">VER TIME COMPLETO</button>
                </div>
            </div>
        </div>
        <div class="layout-banco">
            <h2 class="titulo-geracoes" style="font-size: 50px;">PokéBANK</h2>
            <div class="grid-bank" > 
                <ul style="list-style-type: none;" class="slot-banco" id="pokemonSalvo"></ul>
            </div>
        </div>
    </main>
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