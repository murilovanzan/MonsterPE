//para mostrar a imagem etc

class Pokemon{

    static async getByGen(gen){

        try{

            const resposta = await fetch(`https://pokeapi.co/api/v2/generation/generation-${gen}`);

            if(!resposta.ok){
                throw new Error(`Erro na busca dos Pokémon da geração ${gen}!`);
            }

            const dados = await resposta.json();
            return dados;

        }catch(erro){
            console.error("Falha: ", erro);
        }

    }

    static async getByUrl(url){

        try{

            const resposta = await fetch(url);
            if(!resposta.ok){
                throw new Error('Erro ao buscar a url: ', url);
            }

            const dados = await resposta.json();
            return dados;

        }catch(erro){
            console.error("Erro: ", erro);
        }

    }

    static async showGen(gen){
        document.getElementById('opgens').classList.remove('ativo');
        document.getElementById('voltargen').classList.add('ativo');
        const lista = document.getElementById('pokemon');
        const pokemons = await this.getByGen(gen);
            lista.innerHTML = '';
            for(const species of pokemons.pokemon_species){
                const url = species.url.replace("-species", "");
                const pokemon = await this.getByUrl(url);
                let nomeTipo1 = pokemon.types[0].type.name;
                let tiposPokemon = tiposTraduzidos[nomeTipo1] || nomeTipo1; 

                if(pokemon.types.length > 1) {
                    let nomeTipo2 = pokemon.types[1].type.name;
                    tiposPokemon += " / " + (tiposTraduzidos[nomeTipo2] || nomeTipo2);
                }
                lista.innerHTML += `
                    <li class="cartao-pokemon">
                        <div class="cartao-fundo"></div>
                        <img src='${pokemon.sprites.front_default}'>
                        <h3>${pokemon.name}</h3>
                        <h3>#${pokemon.id}</h3>
                    
                        <div class="costas-seguras">
                            <h3>${pokemon.name}</h3>
                            <p>${tiposPokemon}</p>
                        </div>
                    </li>`
            }
    }

}

const tiposTraduzidos = {
    normal: 'Normal',
    fighting: 'Lutador',
    flying: 'Voador',
    poison: 'Venenoso',
    ground: 'Terra',
    rock: 'Pedra',
    bug: 'Inseto',
    ghost: 'Fantasma',
    steel: 'Metal',
    fire: 'Fogo',
    water: 'Água',
    grass: 'Grama',
    electric: 'Elétrico',
    psychic: 'Psíquico',
    ice: 'Gelo',
    dragon: 'Dragão',
    dark: 'Sombrio',
    fairy: 'Fada'
};
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
            if(menuGens) menuGens.classList.toggle('ativo');   
        });
    }
    if (linkJogar) {
        linkJogar.addEventListener('click', function(event) {
            event.preventDefault(); 
            if(menuGens) menuGens.classList.remove('ativo');   
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuJogar) menuJogar.classList.toggle('ativo');  
        });
    }
});

function montarEquipe() {
    document.getElementById('opjogar').classList.remove('ativo');
    document.getElementById('tela-equipe').classList.add('ativo');
}

function voltarParaGeracoes() {
    document.getElementById('voltargen').classList.remove('ativo');
    document.getElementById('opgens').classList.add('ativo');
}

function iniciarJogo() {
    alert("Iniciando MonsterPE!");
}


function voltarParaJogar() {
    document.getElementById('tela-equipe').classList.remove('ativo');
    document.getElementById('opjogar').classList.add('ativo');
    document.getElementById('resultado-pesquisa').innerHTML = "";
    document.getElementById('input-busca').value = "";
}



// AQUI
let timeEscolhido = [];
let pokemonTemp = null;

async function buscarPokemonDaApi() {
    let input = document.getElementById('input-busca').value.toLowerCase().trim();
    let telaResultado = document.getElementById('resultado-pesquisa');
    
    if (input === "") return;
    
    telaResultado.innerHTML = "<p style='color: yellow;'>Buscando...</p>";

    try {
        let resposta = await fetch(`https://pokeapi.co/api/v2/pokemon/${input}`);
        let dados = await resposta.json();

        let tipo1 = tiposTraduzidos[dados.types[0].type.name] || dados.types[0].type.name;
        let tiposFinais = tipo1;
        
        if (dados.types.length > 1) {
            let tipo2 = tiposTraduzidos[dados.types[1].type.name] || dados.types[1].type.name;
            tiposFinais += " / " + tipo2;
        }

        pokemonTemp = {
            id: dados.id,
            nome: dados.name,
            sprite: dados.sprites.front_default,
            tipo: tiposFinais
        };

        telaResultado.innerHTML = `
            <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                <div class="cartao-fundo"></div>
                <img src="${pokemonTemp.sprite}">
                <h3 style="margin: 5px 0;">Nº ${pokemonTemp.id} - ${pokemonTemp.nome}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemonTemp.tipo}</p>
                <button onclick="adicionarAoTime()" class="btn-adicionar">Adicionar ao Time</button>
            </div>
        `;
    } catch (e) {
        telaResultado.innerHTML = "<p style='color: red; font-weight: bold;'>Não encontrado!</p>";
    }
}

function adicionarAoTime() {
    if (timeEscolhido.length < 6 && pokemonTemp !== null) {
        timeEscolhido.push(pokemonTemp);
        atualizarTelaTime();
    } else if (timeEscolhido.length >= 6) {
        alert("Seu time já tem 6 Pokémons!");
    }
}
function removerDoTime(posicao) {
    timeEscolhido.splice(posicao, 1);
    atualizarTelaTime();
}
function atualizarTelaTime() {
    let grid = document.getElementById('grid-time');
    grid.innerHTML = "";
    for (let i = 0; i < 6; i++) {
        if (timeEscolhido[i] != null) {
            let p = timeEscolhido[i];
            grid.innerHTML += `
                <div class="slot-pokemon preenchido">
                    <button class="btn-remover" onclick="removerDoTime(${i})">X</button>
                    <img src="${p.sprite}">
                    <div class="slot-info">
                        <span class="slot-id">Nº ${p.id}</span>
                        <span class="slot-nome">${p.nome}</span>
                    </div>
                </div>
            `;
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }
    let btnSalvar = document.getElementById('btn-salvar-time');
    if (timeEscolhido.length === 6) {
        btnSalvar.style.display = 'block';
    } else {
        btnSalvar.style.display = 'none';
    }
}