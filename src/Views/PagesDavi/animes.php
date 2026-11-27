<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animes de Pokémon</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <style>
        .anime-container {
            width: 100%;
            max-width: 1200px;
            margin: 0;
            background-color: #0000005c;
        }

        .anime-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 25px;
            width: 100%;
            box-sizing: border-box;
        }
        .anime-grid > h2{
            padding: 10px;
        }
       .anime-card {
            height: 350px;
            width: 250px;
            background-image: url('/MonsterPE/assets/imgs/GreatBallWall.jpeg');
            background-size: cover;
            background-position: center;
            background-color: #1a1a1a;
            border-radius: 15px;
            overflow: hidden;
            border: 2px solid #3B4CCA;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative; 
            padding-top: 30px;
            cursor: pointer;
        }
        .anime-poster {
            width: 180px; 
            height: 240px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #1a1a1a; 
            z-index: 2;
        }
        .anime-info {
            font-family: Lexend, sans-serif;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.95) 10%, rgba(0,0,0,0.7) 60%, transparent 100%);
            padding: 30px 10px 15px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 2px;
            color: #ffffff;
            box-sizing: border-box;
            z-index: 3;
        }

    </style>
</head>
<body>
    <nav>
        <div class="logonav"><a href="/MonsterPE/src/Views/main/"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex">Discord</a></div>
    </nav>
    <main class="anime-container">
    <h2 class="titulo-geracoes" style="margin-top: 10px;">ANIMES DE POKÉMON</h2>
    <div class="anime-grid">
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/LigaIndigo.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Liga Índigo</h3>
                <span class="anime-geracao">Pokémon - A Série: O Início</br>1ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">1997</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/LigaLaranja.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Aventuras nas Ilhas Laranja</h3>
                <span class="anime-geracao">Pokémon - A Série: O Início</br>1ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">1999</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/AJornadaJohto.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon A Jornada Johto</h3>
                <span class="anime-geracao">Pokémon: Ouro e Prata</br>2ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">1999</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/CampeõesdaLigaJohto.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Campeões da Liga Johto</h3>
                <span class="anime-geracao">Pokémon: Ouro e Prata</br>2ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2000</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/MasterQuest.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Master Quest</h3>
                <span class="anime-geracao">Pokémon: Ouro e Prata</br>2ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2001</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Avançado.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Avançado</h3>
                <span class="anime-geracao">Pokémon: Rubi e Safira</br>3ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2002</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Desafio Avançado.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Desafio Avançado</h3>
                <span class="anime-geracao">Pokémon: Rubi e Safira</br>3ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2003</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Batalha Avançada.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Batalha Avançada</h3>
                <span class="anime-geracao">Pokémon: Rubi e Safira</br>3ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2004</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Batalha da Fronteira .jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Batalha da Fronteira </h3>
                <span class="anime-geracao">Pokémon: Rubi e Safira</br>3ª Geração</br>4ª Temporada</span>
                <span class="anime-ano">2005</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Diamante e Pérola.jpeg " alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Diamante e Pérola</h3>
                <span class="anime-geracao">Pokémon: Diamante e Pérola</br>4ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2006</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Batalha Dimensional.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Batalha Dimensional</h3>
                <span class="anime-geracao">Pokémon: Diamante e Pérola</br>4ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2007</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Batalhas Galácticas.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Batalhas Galácticas</h3>
                <span class="anime-geracao">Pokémon: Diamante e Pérola</br>4ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2008</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Vencedores da Liga Sinnoh.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Vencedores da Liga Sinnoh</h3>
                <span class="anime-geracao">Pokémon: Diamante e Pérola</br>4ª Geração</br>4ª Temporada</span>
                <span class="anime-ano">2010</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Preto e Branco.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Preto e Branco</h3>
                <span class="anime-geracao">Pokémon: Preto e Branco</br>5ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2010</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Destinos Rivais.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Destinos Rivais</h3>
                <span class="anime-geracao">Pokémon: Preto e Branco</br>5ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2011</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Aventuras em Unova.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Aventuras em Unova</h3>
                <span class="anime-geracao">Pokémon: Preto e Branco</br>5ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2012</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Aventuras em Unova e Mais Além.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Aventuras em Unova e Mais Além</h3>
                <span class="anime-geracao">Pokémon: Preto e Branco</br>5ª Geração</br>4ª Temporada</span>
                <span class="anime-ano">2012</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/XY.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon XY</h3>
                <span class="anime-geracao">Pokémon: XY</br>6ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2013</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Desafio em Kalos.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon XY: Desafio em Kalos</h3>
                <span class="anime-geracao">Pokémon: XY</br>6ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2014</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/XYZ.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon XYZ</h3>
                <span class="anime-geracao">Pokémon: XY</br>6ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2015</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Sol e Lua.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Sol e Lua</h3>
                <span class="anime-geracao">Pokémon: Sol e Lua</br>7ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2016</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Ultra Aventuras.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Ultra Aventuras</h3>
                <span class="anime-geracao">Pokémon: Sol e Lua</br>7ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2017</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Ultra Lendas.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Ultra Lendas</h3>
                <span class="anime-geracao">Pokémon: Sol e Lua</br>7ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2018</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Jornadas.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Jornadas</h3>
                <span class="anime-geracao">Pokémon: Jornadas</br>8ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2019</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/JornadasdeMestre.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Jornadas de Mestre</h3>
                <span class="anime-geracao">Pokémon: Jornadas</br>8ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2020</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/JornadasSupremas.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Jornadas Supremas</h3>
                <span class="anime-geracao">Pokémon: Jornadas</br>8ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2021</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Horizontes.jpg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Horizontes</h3>
                <span class="anime-geracao">Pokémon: Horizontes</br>9ª Geração</br>1ª Temporada</span>
                <span class="anime-ano">2023</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/A Busca por Laqua.webp" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon A Busca por Laqua</h3>
                <span class="anime-geracao">Pokémon: Horizontes</br>9ª Geração</br>2ª Temporada</span>
                <span class="anime-ano">2024</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Altas Esperanças.jpeg" alt="Capa do Anime">
            <div class="anime-info">
                <h3 class="anime-nome">Pokémon Altas Esperanças</h3>
                <span class="anime-geracao">Pokémon: Horizontes</br>9ª Geração</br>3ª Temporada</span>
                <span class="anime-ano">2025</span>
            </div>
        </div>
    </div>
<h2 class="titulo-geracoes" style="margin-top: 10px;">FILMES DE POKÉMON</h2>
    <div class="anime-grid">
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Mewtwo Contra-Ataca.jpg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Mewtwo Contra-Ataca</h3>
                <span class="anime-ano">1999</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/O poder de Um.jpeg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon O Poder de Um</h3>
                <span class="anime-ano">1999</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/O feitico dos Unown.jpg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon O Feitiço dos Unown</h3>
                <span class="anime-ano">2000</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Celebi.jpeg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Celebi, A Voz da Floresta</h3>
                <span class="anime-ano">2001</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Latios e Latias.jpeg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Latios e Latias</h3>
                <span class="anime-ano">2002</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/Jirachi.jpg" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Jirachi - Realizador de Desejos </h3>
                <span class="anime-ano">2003</span>
            </div>
        </div>
     <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_7_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Alma Gêmea</h3>
                <span class="anime-ano">2004</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_8_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Lucario e o Mistério de Mew</h3>
                <span class="anime-ano">2005</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_9_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Ranger e o Lendário Templo do Mar</h3>
                <span class="anime-ano">2006</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_10_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon O Pesadelo de Darkrai</h3>
                <span class="anime-ano">2007</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_11_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Giratina e o Cavaleiro do Céu </h3>
                <span class="anime-ano">2008</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_12_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Arceus e a Jóia da Vida</h3>
                <span class="anime-ano">2009</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_13_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Zoroark - Mestre das Ilusões</h3>
                <span class="anime-ano">2010</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_14_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Branco - Victini e Zekrom</h3>
                <span class="anime-ano">2011</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_15_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Preto - Victini e Reshiram</h3>
                <span class="anime-ano">2011</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_16_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Kyurem contra a Espada da Justiça</h3>
                <span class="anime-ano">2012</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_17_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Genesect e a Lenda Revelada</h3>
                <span class="anime-ano">2013</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_18_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Diancie e o Casulo da Destruição</h3>
                <span class="anime-ano">2014</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_19_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Hoopa e o Duelo Lendário</h3>
                <span class="anime-ano">2015</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_20_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Volcanion e a Maravilha Mecânica</h3>
                <span class="anime-ano">2016</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_21_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Eu Escolho Você!</h3>
                <span class="anime-ano">2017</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_22_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon O Poder de Todos</h3>
                <span class="anime-ano">2018</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_23_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Detetive Pikachu</h3>
                <span class="anime-ano">2019</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_24_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Segredos da Selva</h3>
                <span class="anime-ano">2020</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_25_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon Mewtwo Contra-Ataca - Evolução</h3>
                <span class="anime-ano">2020</span>
            </div>
        </div>
        <div class="anime-card" style="">
            <img class="anime-poster" src="/MonsterPE/assets/imgs/Animes/filme_26_poster.webp" alt="Capa do Anime">
            <div class="anime-info" style="padding-bottom: 35px;">
                <h3 class="anime-nome">Pokémon As Crônicas de Arceus</h3>
                <span class="anime-ano">2022</span>
            </div>
        </div>


    </div>
</main>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/6VaQrXhea">Clique aqui!</a>
        </div>
</footer>
<script>
    document.querySelectorAll('.anime-card').forEach(card => {
        card.addEventListener('click', () => {
            const nomeAnime = card.querySelector('.anime-nome').textContent.trim();
            window.open(`https://www.google.com/search?q=${encodeURIComponent(nomeAnime)}`, '_blank');
        });
    });
</script>
</body>
</html>