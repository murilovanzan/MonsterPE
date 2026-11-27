document.addEventListener("DOMContentLoaded", function() {

    const linkVerPoke = document.getElementById('verpoke');
    const linkJogar = document.getElementById('jogarpoke');

    const menuGens = document.getElementById('opgens');
    const menuVoltar = document.getElementById('voltargen');
    const menuJogar = document.getElementById('opjogar');
    const telaEquipe = document.getElementById('tela-equipe');
    if (linkVerPoke) {
        linkVerPoke.addEventListener('click', function(event) {
            event.preventDefault();
            if(menuJogar) menuJogar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(menuGens) menuGens.classList.add('ativo');   
        });
    }
    if (linkJogar) {
        linkJogar.addEventListener('click', function(event) {
            event.preventDefault(); 
            if(menuGens) menuGens.classList.remove('ativo');   
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuJogar) menuJogar.classList.add('ativo');  
        });
    }
});

function telaMontarEquipe() {
    window.location.href = "../pokemon/?acao=time";
}

function voltarParaGeracoes() {
    document.getElementById('voltargen').classList.remove('ativo');
    document.getElementById('opgens').classList.add('ativo');
}

function iniciarJogo(){
    window.location.href = "../pokemon/?acao=batalha";
}
function IrAoCentro() {
    window.location.href = "../main/centro.php";
}
function IrALoja() {
    window.location.href = "../main/loja.php";
}
function Creditos() {
    window.location.href = "../main/creditos.php";
}

async function showGen(gen){
    document.getElementById('opgens').classList.remove('ativo');
    document.getElementById('voltargen').classList.add('ativo');
    const lista = document.getElementById('pokemon');
    const pokemons = await getByUrl(`https://pokeapi.co/api/v2/generation/generation-${gen}`);
        lista.innerHTML = '';
        for(const species of pokemons.pokemon_species){
            const url = species.url.replace("-species", "");
            let pokemon = await getByUrl(url);
            
            pokemon = await formatarPokemon(pokemon);

            lista.innerHTML += `
                <li class="cartao-pokemon">
                    <div class="cartao-fundo"></div>
                    <img src='${pokemon.sprites.front_default}'>
                    <h3>${pokemon.apelido}</h3>
                    <h3>#${pokemon.api_id}</h3>
                
                    <div class="costas-seguras">
                        <h3>${pokemon.apelido}</h3>
                        <p>${pokemon.tiposFormatados}</p>
                    </div>
                </li>
            `
        }
}

document.querySelectorAll('.dashmainclick').forEach(botao => {
    botao.addEventListener('click', () => {
        const aside = document.querySelector('.dashaside');
        if (aside) {
            aside.classList.remove('modo-inicial');
        }
    });
});

