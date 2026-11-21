<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia do Jogo</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <style>
    .type-box {
        display: inline-block;
        float: right;
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
</style>
</head>
<body>
    <nav>
        <div class="logonav"><a href="/MonsterPE/src/Views/main/"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php" target="_blank">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php" target="_blank">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php" target="_blank">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php" target="_blank">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex" target="_blank">Discord</a></div>
    </nav>
    <main class="mainguia">
        <div class="descrito">
            O Monster Pocket Edition se baseia no jogo Pokémon Showdown, e nele nós escolhemos um time de 6 pokémon ao total para batalhar contra outro time de 6 pokémon, as mecânicas como poções para restaurar a vida, antidotos, pokédollar para comprar itens na lojinha e Pokémon Center para restaurar a vida deles após a batalha.</br>
            A mecânica dos tipos pokémon também funcionará e as vantagens funcionaram da mesma forma, por exemplo, temos 18 tipos de pokémon, cada um com sua resistência e fraqueza, alguns com imunidade contra alguns golpes, e funciona assim:<br>
            <table>
                <tr>
                    <th>TIPO</th>
                    <th>RESISTÊNCIA</th>
                    <th>FRAQUEZA</th>
                    <th>IMUNIDADE</th>
                </tr>
                <tr>
                    <td>Normal</td>
                    <td>Sem resistência</td>
                    <td>Lutador</td>
                    <td>Fantasma</td>
                </tr>
                <tr>
                    <td>Fogo</td>
                    <td>Fogo, Grama, Gelo, Inseto, Aço, Fada</td>
                    <td>Água, Terra, Pedra</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Água</td>
                    <td>Fogo, Água, Gelo e Aço</td>
                    <td>Elétrico e Grama</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Elétrico</td>
                    <td>Elétrico, Voador e Aço</td>
                    <td>Terra</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Grama</td>
                    <td>Grama, Terra, Elétrico e Água</td>
                    <td>Voador, Inseto, Gelo, Fogo e Veneno</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Gelo</td>
                    <td>Gelo</td>
                    <td>Fogo, Lutador, Aço</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Lutador</td>
                    <td>Inseto, Pedra e Sombrio</td>
                    <td>Psíquico, Fada e Voador</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Venenoso</td>
                    <td>Fada, Grama, Venenoso, Lutador e Inseto</td>
                    <td>Psíquico e Terra</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Terra</td>
                    <td>Pedra e Venenoso</td>
                    <td>Grama, Água e Gelo</td>
                    <td>Elétrico</td>
                </tr>
                <tr>
                    <td>Voador</td>
                    <td>Inseto, Lutador e Grama</td>
                    <td>Pedra, Gelo e Elétrico</td>
                    <td>Terra</td>
                </tr>
                <tr>
                    <td>Psíquico</td>
                    <td>Psíquico e Lutador</td>
                    <td>Sombrio, Fantasma e Inseto</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Inseto</td>
                    <td>Terra, Lutador e Grama</td>
                    <td>Pedra, Voador e Fogo</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Pedra</td>
                    <td>Voador, Venenoso, Fogo e Normal</td>
                    <td>Aço, Terra, Lutador, Água e Grama</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Fantasma</td>
                    <td>Inseto e Venenoso</td>
                    <td>Sombrio e Fantasma</td>
                    <td>Normal e Lutador</td>
                </tr>
                <tr>
                    <td>Dragão</td>
                    <td>Fogo, Elétrico, Grama e Água</td>
                    <td>Gelo, Fada e Dragão</td>
                    <td>Sem imunidade</td>
                </tr>
                <tr>
                    <td>Sombrio</td>
                    <td>Sombrio e Fantasma</td>
                    <td>Fada, Inseto e Lutador</td>
                    <td>Psíquico</td>
                </tr>
                <tr>
                    <td>Aço</td>
                    <td>Voador, Psíquico, Inseto, Pedra, Normal, Dragão, Grama, Gelo, Metal e Fada</td>
                    <td>Fogo, Terra e Lutador</td>
                    <td>Venenoso</td>
                </tr>
                <tr>
                    <td>Fada</td>
                    <td>Lutador, Inseto e Sombrio</td>
                    <td>Aço e Venenoso</td>
                    <td>Dragão</td>
                </tr>
            </table>
        </div>
            <div class="type-box roundy">
        <div class="type-box__title">TIPOS</div>

            <div class="type-grid">
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #9FA19F 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/a/ae/Normal_icon.png/20px-Normal_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/a/ae/Normal_icon.png/30px-Normal_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/a/ae/Normal_icon.png/40px-Normal_icon.png 2x" 
                        alt="Normal" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Normal</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #E62829 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/5/5e/Fire_icon.png/20px-Fire_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/5/5e/Fire_icon.png/30px-Fire_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/5/5e/Fire_icon.png/40px-Fire_icon.png 2x" 
                        alt="Fire" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Fogo</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #FF8000 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/7/7d/Fighting_icon.png/20px-Fighting_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/7/7d/Fighting_icon.png/30px-Fighting_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/7/7d/Fighting_icon.png/40px-Fighting_icon.png 2x" 
                        alt="Fighting" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Lutador</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #2980EF 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/7/7f/Water_icon.png/20px-Water_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/7/7f/Water_icon.png/30px-Water_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/7/7f/Water_icon.png/40px-Water_icon.png 2x" 
                        alt="Water" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Água</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #81B9EF 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/f/f0/Flying_icon.png/20px-Flying_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/f/f0/Flying_icon.png/30px-Flying_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/f/f0/Flying_icon.png/40px-Flying_icon.png 2x" 
                        alt="Flying" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Voador</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #3FA129 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/c/cb/Grass_icon.png/20px-Grass_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/c/cb/Grass_icon.png/30px-Grass_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/c/cb/Grass_icon.png/40px-Grass_icon.png 2x" 
                        alt="Grass" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Grama</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #9141CB 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/8/84/Poison_icon.png/20px-Poison_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/8/84/Poison_icon.png/30px-Poison_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/8/84/Poison_icon.png/40px-Poison_icon.png 2x" 
                        alt="Poison" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Venenoso</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #FAC000 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/a/af/Electric_icon.png/20px-Electric_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/a/af/Electric_icon.png/30px-Electric_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/a/af/Electric_icon.png/40px-Electric_icon.png 2x" 
                        alt="Electric" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Elétrico</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #915121 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/5/58/Ground_icon.png/20px-Ground_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/5/58/Ground_icon.png/30px-Cinema_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/5/58/Ground_icon.png/40px-Ground_icon.png 2x" 
                        alt="Ground" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Terra</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #EF4179 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/a/a6/Psychic_icon.png/20px-Psychic_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/a/a6/Psychic_icon.png/30px-Psychic_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/a/a6/Psychic_icon.png/40px-Psychic_icon.png 2x" 
                        alt="Psychic" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Psíquico</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #AFA981 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/f/ff/Rock_icon.png/20px-Rock_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/f/ff/Rock_icon.png/30px-Rock_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/f/ff/Rock_icon.png/40px-Rock_icon.png 2x" 
                        alt="Rock" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Pedra</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #3DCEF3 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/8/83/Ice_icon.png/20px-Ice_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/8/83/Ice_icon.png/30px-Ice_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/8/83/Ice_icon.png/40px-Ice_icon.png 2x" 
                        alt="Ice" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Gelo</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #91A119 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/7/79/Bug_icon.png/20px-Bug_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/7/79/Bug_icon.png/30px-Bug_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/7/79/Bug_icon.png/40px-Bug_icon.png 2x" 
                        alt="Bug" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Inseto</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #5060E1 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/9/91/Dragon_icon.png/20px-Dragon_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/9/91/Dragon_icon.png/30px-Dragon_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/9/91/Dragon_icon.png/40px-Dragon_icon.png 2x" 
                        alt="Dragon" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Dragão</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #704170 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/8/82/Ghost_icon.png/20px-Ghost_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/8/82/Ghost_icon.png/30px-Ghost_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/8/82/Ghost_icon.png/40px-Ghost_icon.png 2x" 
                        alt="Ghost" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Fantasma</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #624D4E 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/3/33/Dark_icon.png/20px-Dark_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/3/33/Dark_icon.png/30px-Dark_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/3/33/Dark_icon.png/40px-Dark_icon.png 2x" 
                        alt="Dark" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Sombrio</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #60A1B8 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/b/b8/Steel_icon.png/20px-Steel_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/b/b8/Steel_icon.png/30px-Steel_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/b/b8/Steel_icon.png/40px-Steel_icon.png 2x" 
                        alt="Steel" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Aço</span>
                </div>
                </div>
                <div>
                <div class="type-badge" style="background-image: linear-gradient(105deg, #EF70EF 30px, #5A5A5A 31px);">
                    <span class="type-badge__icon">
                    <img src="https://archives.bulbagarden.net/media/upload/thumb/5/5a/Fairy_icon.png/20px-Fairy_icon.png" 
                        srcset="https://archives.bulbagarden.net/media/upload/thumb/5/5a/Fairy_icon.png/30px-Fairy_icon.png 1.5x, https://archives.bulbagarden.net/media/upload/thumb/5/5a/Fairy_icon.png/40px-Fairy_icon.png 2x" 
                        alt="Fairy" width="20" height="20" loading="lazy" decoding="async">
                    </span>
                    <span class="type-badge__text">Fada</span>
                </div>
                </div>
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
</body>
</html>