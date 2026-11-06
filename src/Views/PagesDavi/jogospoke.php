<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos de Pokémon</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="stylesheet" href="/MonsterPE/assets/css/Dropdown.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
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
    <main style="padding-bottom: 100px;">
        <div class="container">
     <div class="dropdown">
        <input type="checkbox" id="dropdown-toggle">
        <label for="dropdown-toggle" class="dropdown-btn">Geração</label>
        <div class="dropdown-content">
            <button onclick="genx('gen1')"><a>1° geração</a></button>
            <button onclick="genx('gen2')"><a>2° geração</a></button>
            <button onclick="genx('gen3')"><a>3° geração</a></button>
            <button onclick="genx('gen4')"><a>4° geração</a></button>
            <button onclick="genx('gen5')"><a>5° geração</a></button>
            <button onclick="genx('gen6')"><a>6° geração</a></button>
            <button onclick="genx('gen7')"><a>7° geração</a></button>
            <button onclick="genx('gen8')"><a>8° geração</a></button>
            <button onclick="genx('gen9')"><a>9° geração</a></button>
            <button onclick="genx('gen0')"><a>sem geração</a></button> 
        </div>
    </div>
    </div>
    <div class="titlegen" id="tituloGen"></div>

<div class="cardes" id="listaJogos"></div>

<script>



const gens = {

gen1: {
    titulo: "JOGOS DA PRIMEIRA GERAÇÃO",
    jogos: [
        {
            nome: "Pocket Monsters Red",
            imagem: "Red_JP_boxart.webp"
        },
        {
            nome: "Pocket Monsters Green",
            imagem: "Green_JP_boxart.webp"
        },
        {
            nome: "Pocket Monsters Blue",
            imagem: "Blue_JP_boxart.webp"
        },
        {
            nome: "Pokémon Red",
            imagem: "Pokemon_Red.webp"
        },
        {
            nome: "Pokémon Blue",
            imagem: "Pokemon_Blue.webp"
        },
        {
            nome: "Pokémon Yellow",
            imagem: "Pokemon_Yellow.webp"
        }
    ]
},

gen2: {
    titulo: "JOGOS DA SEGUNDA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Gold",
            imagem: "Pokemon_gold.webp"
        },
        {
            nome: "Pokémon Silver",
            imagem: "Pokemon_silver.webp"
        },
        {
            nome: "Pokémon Crystal",
            imagem: "Pokemon_crystal.webp"
        },
        {
            nome: "Pokémon HeartGold",
            imagem: "HeartGold_EN_boxart.webp"
        },
        {
            nome: "Pokémon SoulSilver",
            imagem: "SoulSilver_EN_boxart.webp"
        }
    ]
},

gen3: {
    titulo: "JOGOS DA TERCEIRA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Ruby",
            imagem: "Ruby_boxart.webp"
        },
        {
            nome: "Pokémon Sapphire",
            imagem: "Sapphire_boxart.webp"
        },
        {
            nome: "Pokémon Emerald",
            imagem: "Emerald_EN_boxart.webp"
        },
        {
            nome: "Pokémon Omega Ruby",
            imagem: "Omega_Ruby_EN_boxart.webp"
        },
        {
            nome: "Pokémon Alpha Sapphire",
            imagem: "Alpha_Sapphire_EN_boxart.webp"
        }
    ]
},

gen4: {
    titulo: "JOGOS DA QUARTA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Diamond",
            imagem: "Diamond_EN_boxart.webp"
        },
        {
            nome: "Pokémon Pearl",
            imagem: "Pearl_EN_boxart.webp"
        },
        {
            nome: "Pokémon Platinum",
            imagem: "Platinum_EN_boxart.webp"
        },
        {
            nome: "Pokémon Brilliant Diamond",
            imagem: "Brilliant_Diamond_EN_boxart.webp"
        },
        {
            nome: "Pokémon Shining Pearl",
            imagem: "Shining_Pearl_EN_boxart.webp"
        }
    ]
},

gen5: {
    titulo: "JOGOS DA QUINTA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Black",
            imagem: "Black_EN_boxart.webp"
        },
        {
            nome: "Pokémon White",
            imagem: "White_EN_boxart.webp"
        },
        {
            nome: "Pokémon Black 2",
            imagem: "Black_2_EN_boxart.webp"
        },
        {
            nome: "Pokémon White 2",
            imagem: "White_2_EN_boxart.webp"
        }
    ]
},

gen6: {
    titulo: "JOGOS DA SEXTA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon X",
            imagem: "X_EN_boxart.webp"
        },
        {
            nome: "Pokémon Y",
            imagem: "Y_EN_boxart.webp"
        }
    ]
},

gen7: {
    titulo: "JOGOS DA SÉTIMA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Sun",
            imagem: "SunBoxart.webp"
        },
        {
            nome: "Pokémon Moon",
            imagem: "MoonBoxart.webp"
        },
        {
            nome: "Pokémon Ultra Sun",
            imagem: "DHhA38wXgAE3eeW.webp"
        },
        {
            nome: "Pokémon Ultra Moon",
            imagem: "DHhBDHDXcAApHsU.webp"
        }
    ]
},

gen8: {
    titulo: "JOGOS DA OITAVA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Sword",
            imagem: "Sword_EN_boxart.webp"
        },
        {
            nome: "Pokémon Shield",
            imagem: "Shield_EN_boxart.webp"
        }
    ]
},

gen9: {
    titulo: "JOGOS DA NONA GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Scarlet",
            imagem: "scarlet.webp"
        },
        {
            nome: "Pokémon Violet",
            imagem: "violeta.webp"
        }
    ]
},

gen0: {
    titulo: "JOGOS SEM GERAÇÃO",
    jogos: [
        {
            nome: "Pokémon Let's Go, Pikachu!",
            imagem: "Lets_Go_Pikachu_EN_boxart.webp"
        },
        {
            nome: "Pokémon Let's Go, Eevee!",
            imagem: "Lets_Go_Eevee_EN_boxart.webp"
        },
        {
            nome: "Pokémon Legends: Arceus",
            imagem: "Legends_Arceus_EN_boxart.webp"
        },
        {
            nome: "Pokémon Legends: Z-A",
            imagem: "Legends_Z-A.webp"
        }
    ]
}
};

function genx(geracao){
    const dados = gens[geracao];
    if (!dados){
        return;
    }
    document.getElementById("tituloGen").textContent = dados.titulo;
    const lista = document.getElementById("listaJogos");
    lista.innerHTML = "";

    dados.jogos.forEach(function(jogo) {
        const card = document.createElement("div");
        card.className = "card";

        const personagem = document.createElement("div");
        personagem.className = "personagem";

        const imagem = document.createElement("img");
        imagem.src = "/MonsterPE/assets/Jogos/" + jogo.imagem;
        imagem.alt = jogo.nome;

        const escrita = document.createElement("div");
        escrita.className = "escrita";
        escrita.textContent = jogo.nome;

        personagem.appendChild(imagem);
        card.appendChild(personagem);
        card.appendChild(escrita);

        lista.appendChild(card);
    });

    document.getElementById("dropdown-toggle").checked = false;
}

genx("gen1");


</script>
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
