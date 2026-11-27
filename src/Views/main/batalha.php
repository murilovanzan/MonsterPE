<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de batalha</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="stylesheet" href="/MonsterPE/assets/css/batalha.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <script src="../../../assets/script/batalha.js"></script>
    <script type="module">
        iniciarBatalha();
    </script>
</head>
<body class="bodybattle">

    <nav style="justify-content:space-around; margin-bottom: 5px;">
        <div class="logonav"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo" style="height: 10vh;"></a></div>
    </nav>

    <main class="jogo">

            <div class="telajogo">
                <div class="pokemon-area oponente-area">
                    <div class="info-card">
                        <div class="nome-level-container">
                            <h3 id="nome-oponente">Carregando...</h3>
                            <span id="level-oponente">Lv --</span>
                        </div>
                        
                        <div id="tipos-oponente" class="tipos"></div>
                        <div class="hp-container">
                            <div class="hp-bar"><div id="hp-oponente-fill" class="hp-fill"></div></div>
                            <span id="hp-texto-oponente" class="hp-texto">--/--</span>
                        </div>
                    </div>
                    <img id="sprite-oponente" class="pokemon-sprite" src="" alt="Oponente">
                </div>
                <div class="pokemon-area jogador-area">
                    <div class="info-card">
                        <div class="nome-level-container">
                            <h3 id="nome-jogador">Carregando...</h3>
                            <span id="level-jogador">Lv --</span>
                        </div>
                        
                        <div id="tipos-jogador" class="tipos"></div>
                        <div class="hp-container">
                            <div class="hp-bar"><div id="hp-jogador-fill" class="hp-fill"></div></div>
                            <span id="hp-texto-jogador" class="hp-texto">--/--</span>
                        </div>
                    </div>
                    <img id="sprite-jogador" class="pokemon-sprite sprite-costas" src="" alt="Jogador">
                </div>
                <div class="painel-batalha">
                    <div id="menu-principal" class="menu-botoes">
                        <button class="btn-batalha btn-atacar" onclick="mostrarAtaques()">Atacar</button>
                        <button class="btn-batalha btn-mochila" onclick="abrirModal('modal-mochila')">Mochila</button>
                        <button class="btn-batalha btn-pokemon" onclick="abrirModal('modal-equipe')">Pokémon</button>
                        <button class="btn-batalha btn-fugir" onclick="abrirModal('modal-fugir')">Fugir</button>
                    </div>
                    <div id="menu-ataques" class="menu-botoes" style="display: none;">
                    </div>
                </div>
            </div>

            <div id="modal-mochila" class="modal-fundo" style="display: none;">
                <div class="modal-card">
                    <span class="btn-fechar" onclick="fecharModal('modal-mochila')">X</span>
                    <h3>Sua Mochila</h3>
                    <p>Poções, Pokebolas, etc...</p>
                </div>
            </div>
            <div id="modal-equipe" class="modal-fundo" style="display: none;">
                <div class="modal-card">
                    <span class="btn-fechar" onclick="fecharModal('modal-equipe')">X</span>
                    <h3>Sua Equipe</h3>
                    <p>Selecione um Pokémon para trocar.</p>
                    <div></div>
                </div>
            </div>
            <div id="modal-fugir" class="modal-fundo" style="display: none;">
                <div class="modal-card">
                    <h3>Você tem certeza que quer sair da batalha?</h3>
                    <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: center;">
                        <button onclick="fugirDaBatalha()">Sim, Fugir</button>
                        <button onclick="fecharModal('modal-fugir')">Cancelar</button>
                    </div>
                </div>
            </div>

            <div class="logacoes">
                <h2>Histórico dos Rounds</h2>
                <div class="round">
                    <ul>
                        <h3>Round X</h3>
                        <li>Seu ataque</li>
                        <li>Ataque do oponente</li>
                        <li>mais acoes sla inha</li>
                    </ul>
                    <ul>
                        <h3>Round X</h3>
                        <li>Seu ataque</li>
                        <li>Ataque do oponente</li>
                        <li>mais acoes sla inha</li>
                    </ul>
                    <ul>
                        <h3>Round X</h3>
                        <li>Seu ataque</li>
                        <li>Ataque do oponente</li>
                        <li>mais acoes sla inha</li>
                    </ul>
                    <ul>
                        <h3>Round X</h3>
                        <li>Seu ataque</li>
                        <li>Ataque do oponente</li>
                        <li>mais acoes sla inha</li>
                    </ul>
                    <ul>
                        <h3>Round X</h3>
                        <li>Seu ataque</li>
                        <li>Ataque do oponente</li>
                        <li>mais acoes sla inha</li>
                    </ul>
                    
                </div>
            </div>
     </main>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex">Clique aqui!</a>
        </div>
    </footer>

<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/BatalhaAnimation.js"></script>
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