<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia do Jogo</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
    font-weight: 600;               
    font-size: 18px;
    color: #ffffff;
    text-decoration: none;
    letter-spacing: 0.2px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    }
    .type-box {
        position: fixed;
        top: 280px;
        right: 20px;
        max-height: 80vh; 
        overflow-y: auto;
        display: inline-block;
        text-align: center;
        background: #ffffff;
        border: 2px solid rgba(191, 0, 255, 1);
        border-radius: 12px;
        padding: 6px;
        margin: 5px;
        font-family: Lexend, sans-serif;
    }
    .type-box__title {
        font-weight: bold;
        font-size: 16px;
        padding: 2px 0 6px 0;
        color: #000000;
    }
    .type-box hr {
        border: 0;
        border-top: 1px solid #dcdcdc;
        margin: 6px 0;
    }
    .type-grid {
        display: grid;
        grid-template-columns: repeat(2, auto);
        gap: 4px;
        justify-content: center;
    }
    .type-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 4px;
        border-radius: 15px;
        overflow: hidden;
        background-color: #5a5a5a;
        box-sizing: border-box;
    }
    .type-badge__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 22px;
    }
    .type-badge__icon img {
        display: block;
    }
    .type-badge__text {
        min-width: 52px;
        text-align: center;
        color: #ffffff;
        font-size: 13px;
        font-weight: bold;
        padding-left: 4px;
    }
    .mainguia{
        display:flex;
        flex-direction:row;
        justify-content:space-evenly;
        gap:-20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 20px;
        background-color: #ffffff;
        border: 2px solid #3B4CCA;
    }

    th {
        background-color: #3B4CCA; 
        color: #ffffff;
        text-transform: uppercase;
        padding: 10px;
        border: 1px solid #3B4CCA;
    }

    td {
        padding: 8px;
        border: 1px solid #dcdcdc;
        text-align: center;
        color: #000000; 
        font-size: 16px;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #FFFCE6; 
    }
    .descrito {
        margin-right: 320px;
        background-color: rgba(0, 0, 0, 0.75);
        border-radius: 20px;
        padding-left: 30px;
        padding-right: 30px;
        padding-bottom: 30px;
        color: #ffffff;
        text-align: center;
        padding-top: 15px;
    }
    p{
        font-size: 18px;
    }
    .btn-baixar {
        display: inline-block;
        background-color: #3B4CCA;
        color: #ffffff; 
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        margin-top: 5px;
        margin-bottom: 5px;
        border: 2px solid #24308E;
        cursor: pointer;
    }

    .btn-baixar:hover {
        background-color: #E3350D; 
        color: #ffffff;
    }
</style>
</head>
<body>
    <nav style="padding-top: 20px;">
        <div class="logonav"><a href="/MonsterPE/src/Views/main/"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex">Discord</a></div>
    </nav>
    <main class="mainguia">
        <div class="descrito">
            <h2 class="titulo-geracoes" style="margin-top: 10px;">GUIA DO MONSTERPE</h2>
           <p>a</p>
    </div>
    </main>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/6VaQrXhea">Clique aqui!</a>
        </div>
</footer>
</body>
</html>