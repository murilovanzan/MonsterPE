let cachePokemon = {};
let cacheMove = {};
let pokemonSelecionado;

async function getByUrl(url){

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

async function isEvolution(pokeID){

    pokemon = await getByUrl(`https://pokeapi.co/api/v2/pokemon-species/${pokeID}`);
    pokePreEvo = pokemon.evolves_from_species;
    if(pokePreEvo === null){
        return false
    }
    else{
        return true;
    }

}

async function formatarPokemon(pokemon, salvo = false){

    let pokemonFormatado = {};
    
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

    let tiposFormatados = "";
    if(!salvo){
        pokemon.apelido = pokemon.name;
        pokemon.api_id = pokemon.id;
        pokemon.ativo = null;
        pokemon.nivel = 1;
        pokemon.item = null;
        pokemon.status = null;
        pokemon.id = null;
        pokemonFormatado = pokemon;
    }
    else{
        pokemonFormatado = await getByUrl(`https://pokeapi.co/api/v2/pokemon/${pokemon.api_id}`);

        pokemonFormatado.id = pokemon.id;
        pokemonFormatado.api_id = pokemon.api_id;
        pokemonFormatado.apelido = pokemon.apelido;
        pokemonFormatado.nivel = pokemon.nivel;
        pokemonFormatado.stats[0].base_stat = pokemon.hp;
        pokemonFormatado.stats[5].base_stat = pokemon.speed;
        pokemonFormatado.stats[1].base_stat = pokemon.attack;
        pokemonFormatado.stats[3].base_stat = pokemon.spAttack;
        pokemonFormatado.stats[2].base_stat = pokemon.defense;
        pokemonFormatado.stats[4].base_stat = pokemon.spDefense;
        pokemonFormatado.posicao = pokemon.posicao;
        pokemonFormatado.item = pokemon.item;
        pokemonFormatado.status = pokemon.status;
        pokemonFormatado.ativo = pokemon.ativo;

        cachePokemon[pokemonFormatado.id] = pokemonFormatado;
    
    }

    pokemonFormatado.types.forEach(tipo => {
        tipo.type.name = tiposTraduzidos[tipo.type.name] || tipo.type.name;
        tiposFormatados += tipo.type.name + " | ";
    });

    tiposFormatados = tiposFormatados.replace(/ \| \s*$/, "");
    pokemonFormatado.tiposFormatados = tiposFormatados;
    
    return pokemonFormatado;

}

async function formatarMoves(pokemon){
    
    const promisses = pokemon.map((move) => getByUrl(`https://pokeapi.co/api/v2/move/${move.move_id}`));
    pokemonMovesFormatados = await Promise.all(promisses);
    
    return pokemonMovesFormatados;

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

async function showCard() {
    let input = document.getElementById('input-busca').value.toLowerCase().trim();
    let telaResultado = document.getElementById('resultado-pesquisa');
        
    if (input === "") return;
        
    telaResultado.innerHTML = "<p style='color: yellow;'>Buscando...</p>";
        
    let pokemon = null;

    pokemon = await getByUrl(`https://pokeapi.co/api/v2/pokemon/${input}`);

    if(pokemon == null){
        
        telaResultado.innerHTML = "<p style='color: red; font-weight: bold;'>Não encontrado!</p>";
        return;
    }

    const isEvolutionBoolean = await isEvolution(input);
    pokemon = await formatarPokemon(pokemon);

    if(isEvolutionBoolean){
        telaResultado.innerHTML = `
            <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                <div class="cartao-fundo"></div>
                <img src="${pokemon.sprites.front_default}">
                <h3 style="margin: 5px 0;">Nº ${pokemon.api_id} - ${pokemon.apelido}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
            </div>
        `;
    }
    else{

        cachePokemon[pokemon.api_id] = pokemon;
        telaResultado.innerHTML = `
            <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                <div class="cartao-fundo"></div>
                <img src="${pokemon.sprites.front_default}">
                <h3 style="margin: 5px 0;">Nº ${pokemon.api_id} - ${pokemon.apelido}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                <button onclick="adicionarAoTime(${pokemon.api_id})" class="btn-adicionar">Adicionar ao Time</button>
            </div>
        `;
    }

}

async function showMove(){
    let input = document.getElementById('input-busca-move').value.toLowerCase().trim();
    let telaResultado = document.getElementById('resultado-pesquisa-move');
        
    if (input === "") return;
        
    telaResultado.innerHTML = "<p style='color: yellow;'>Buscando...</p>";
        
    let move = null;

    move = await getByUrl(`https://pokeapi.co/api/v2/move/${input}`);
    
    if(!verificaMovePokemon(timeEscolhido[pokemonSelecionado].moves, move.name)){
        telaResultado.innerHTML = "<p style='color: red; font-weight: bold;'>Movimento não permitido para este Pokemon!</p>";
        return;
    }
    if(move == null){
        telaResultado.innerHTML = "<p style='color: red; font-weight: bold;'>Não encontrado!</p>";
        return;
    }

    cacheMove[move.id] = move;
    telaResultado.innerHTML = `
        <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
            <div class="cartao-fundo"></div>
            <img src="">
            <h3 style="margin: 5px 0;">Nº ${move.name} - ${move.damage_class.name}</h3>
            <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${move.type.name}</p>
            <button onclick="adicionarMove(${move.id})" class="btn-adicionar">Adicionar ao Pokemon</button>
        </div>
    `;

}


