<?php

    if(isset($_SESSION['salvarTimeErro'])){
        if($_SESSION['salvarTimeErro']){
            $salvarTimeErro = "Não foi possivel salvar o time com sucesso!";
            unset($_SESSION['salvarTimeErro']);
        }
        else{
            $salvarTimeErro = "Time salvo com sucesso!";
            unset($_SESSION['salvarTimeErro']);
        }
    }
    else{
        $salvarTimeErro = "";
    }

?> 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do usuário</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <script src="../../Models/Pokeapi.js"></script>
    <script src="../../../assets/script/time.js"></script>
    <script type="module">
        
        const pokemonSalvoPoor = <?= json_encode($_SESSION['pokemonSalvo']) ?>;
        const pokemonAtivoPoor = <?= json_encode($_SESSION['pokemonAtivo']) ?>;

        const pokemonMovesBruto = <?= json_encode($_SESSION['moves']) ?>;

        const promissesPokemonMoves = pokemonMovesBruto.map(pokemon => formatarMoves(pokemon));
        let pokemonMoves = await Promise.all(promissesPokemonMoves);

        const promissesSalvo = pokemonSalvoPoor.map(pokemon => formatarPokemon(pokemon, true));
        const pokemonSalvoArray = await Promise.all(promissesSalvo);

        const promissesAtivo = pokemonAtivoPoor.map(pokemon => formatarPokemon(pokemon, true));
        const pokemonAtivoArray = await Promise.all(promissesAtivo);

        showPokemonSalvos(pokemonSalvoArray);
        pokemonAtivoArray.forEach(pokemon => {
            adicionarAoTime(pokemon.id);
        });
        atualizarTimeAtaques(pokemonMoves);

    </script>
</head>
<body>
    <nav style="justify-content:space-around;">
        <div class="logonav"><a href="../main/index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
            <a class="userview"> Usuário</a>
            |
            <a href="../usuario/?acao=logout" >Logout</a>
        </div>
    </nav>
    <main class="maindash">
        <div id="tela-equipe" class="menugens" style="display:flex; position:relative;">
            <div class="layout-equipe" id="time" style="display: flex;">
                <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
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
                    <button id="btn-salvar-time" class="btn-time" onclick="salvarTime()">SALVAR TIME COMPLETO</button>
                    <button id="btn-limpar-time" class="btn-time" onclick="limparTime()">LIMPAR TIME</button>
                    <span>
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
                <div>
                    <ul style="list-style-type: none; display: flex;" id="pokemonSalvo"></ul>
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
    </main>
<footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex" target="_blank">Clique aqui!</a>
        </div>
</footer>
</body>
</html>