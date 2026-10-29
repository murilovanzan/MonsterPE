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
                let tiposPokemon = tiposTraduzidos[nomeTipo1] || nomeTipo1; // Usa a tradução, ou o original se falhar

                if(pokemon.types.length > 1) {
                    let nomeTipo2 = pokemon.types[1].type.name;
                    tiposPokemon += " / " + (tiposTraduzidos[nomeTipo2] || nomeTipo2);
                }
                lista.innerHTML += `
                    <li class="cartao-pokemon">
                        <div class="cartao-fundo"></div>
                        <img src='${pokemon.sprites.front_default}'>
                        <h3>${pokemon.name}</h3>
                    
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

//para mostrar os botoes

const linkVerPoke = document.getElementById('verpoke');
const menuGens = document.getElementById('opgens');
const menuVoltar = document.getElementById('voltargen');

// Ação ao clicar em "VER POKÉMON"
linkVerPoke.addEventListener('click', function(event) {
    event.preventDefault(); 
    
    // Esconde a lista de Pokémon se estiver aberta
    menuVoltar.classList.remove('ativo'); 
    
    // Alterna a visibilidade dos botões de geração
    menuGens.classList.toggle('ativo'); 
});

// Ação do botão "Voltar para gerações"
function voltarParaGeracoes() {
    menuVoltar.classList.remove('ativo'); // Esconde a lista e o botão voltar
    menuGens.classList.add('ativo');      // Mostra as gerações novamente
}


