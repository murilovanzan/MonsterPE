<?php
    session_start();

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
</head>
<body>
    <nav style="justify-content:space-around;">
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
            <a class="userview"> Usuário</a>|
            <a href="../usuario/?acao=logout" >Logout</a>
        </div>
    </nav>
    <main class="maindash">
        <div id="tela-equipe" class="menugens" style="display:flex;">
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
                    <button id="btn-salvar-time" onclick="salvarTime()">SALVAR TIME COMPLETO</button>
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
            </div>
        </div>
        <div>
            <ul style="list-style-type: none;">
                <?php
                
                    foreach ($_SESSION['pokemonBD'] as $pokemon){
                        $id = $pokemon['id'];
                        $name = $pokemon['name'];
                        $sprite = $pokemon['sprites']['front_default'];
                        $tiposFormatados = $pokemon['tiposFormatados'];

                        echo <<<HTML
                            <li>
                                <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                                    <div class="cartao-fundo"></div>
                                    <img src="$sprite" alt="$name">
                                    <h3 style="margin: 5px 0;">Nº $id - $name</h3>
                                    <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">$tiposFormatados</p>
                                    <button onclick="adicionarAoTime($id)" class="btn-adicionar">Adicionar ao Time</button>
                                </div>
                            </li>
                        HTML;
                    }
                    
                ?>
            </ul>
        </div>
    </main>
<footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex" target="_blank">Clique aqui!</a>
        </div>
</footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/time.js"></script>
</body>
</html>