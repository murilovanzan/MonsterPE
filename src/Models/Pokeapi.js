let cachePokemon = {};

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

const brincadeirasAmigos = {
    "a buznello ta confusa": {
        url: "/MonsterPE/assets/imgs/Forçadas/Buzconfuzz.png",
        nome: "Buznello",
        tipo: "Confusa",
        descricao: "Finge que te ama, mas ta confusa."
    },

    "ladaia": {
        url: "/MonsterPE/assets/imgs/Forçadas/Ladaia.png",
        nome: "Lukan(O Ladaia)",
        tipo: "Ladaiento",
        descricao: "A gente perde no jogo, mas na briga..."
    }
};

async function showCard() {
    let input = document.getElementById('input-busca').value.toLowerCase().trim();
    let telaResultado = document.getElementById('resultado-pesquisa');
        
    if (input === "") return;
        
    telaResultado.innerHTML = "<p style='color: yellow;'>Buzcando...</p>";

    if (brincadeirasAmigos[input]) {
        const amigo = brincadeirasAmigos[input];
        telaResultado.innerHTML = `
            <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                <div class="cartao-fundo"></div>
                <img src="${amigo.url}" style="border-radius: 10px; max-width: 150px; margin-top: 10px;">
                <h3 style="margin: 5px 0;">${amigo.nome}</h3>
                <h4 style="margin: 5px 0; color:black;">${amigo.descricao}</h4>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${amigo.tipo}</p>
                <p style="font-size: 12px; font-style: italic; padding: 0 10px;">${amigo.descricao}</p>
            </div>
        `;
        return; 
    }
        
    let pokemon = null;

    pokemon = await getByUrl(`https://pokeapi.co/api/v2/pokemon/${input}`);

    if(input === "A buznello ta confusa"){
        pokemon = getByUrl(`/MonsterPE/assets/imgs/Forçadas/Buzconfuzz.png`);
    }
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
                <img src="${pokemon.sprites.front_default}"  style="filter: grayscale(100%);" >
                <h3 style="font-size: 12px; margin: 5px 0; margin-bottom:-5px;">Nº ${pokemon.api_id} - ${pokemon.apelido}</h3>
                <p style="background: rgba(0,0,0,0.1); font-size:10px; padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 2px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                <button onclick="adicionarAoTime(${pokemon.api_id})" class="btn-adicionar" disabled  style=" top:-15px; background-color: red;"> Você não pode adicionar esse pokémon no seu time, pois é uma evolução, compre a pedra da evolução na loja para conseguir evoluí-lo</button>
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
/*async function getPokemon(){
    
    pokemon = await getByUrl(`https://pokeapi.co/api/v2/pokemon/${pokemon.id}`);
}*/


function toggleDropdown(event) {
    event.stopPropagation();
    let dropdown = document.getElementById("dropdown-usuario");

    if (!dropdown) {
        let nomeBd = event.target.getAttribute("data-username");
        let emailBd = event.target.getAttribute("data-email");
        let avatarSalvo = localStorage.getItem("meuAvatar") || "/MonsterPE/assets/imgs/Avatars/ash.png";

        dropdown = document.createElement("div");
        dropdown.id = "dropdown-usuario";
        dropdown.className = "dropdown-branco";
        
        dropdown.innerHTML = `
            <aside class="dropdown-avatar" onclick="document.getElementById('modal-avatar').style.display='flex'" style="cursor:pointer;">
                <img id="foto-perfil" src="${avatarSalvo}" alt="Avatar">
            </aside>
            <div class="dropdown-info">
                <span class="dropdown-nome">${nomeBd}</span>
                <span class="dropdown-email">${emailBd}</span>
                <a class="btn-editar-usuario">Clique no avatar para mudar ele</a>
            </div>
        `;
        event.target.parentElement.appendChild(dropdown);
    }

    dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") ? "flex" : "none";
}
function trocarAvatar(novaImagem) {
    localStorage.setItem("meuAvatar", novaImagem);
    document.getElementById("foto-perfil").src = novaImagem;
    document.getElementById("modal-avatar").style.display = "none";
}