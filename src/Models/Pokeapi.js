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
        tiposFormatados += tiposTraduzidos[tipo.type.name] + " | ";
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
            <aside class="dropdown-avatar">
                <img id="foto-perfil" src="${avatarSalvo}" alt="Avatar">
            </aside>
            <div class="dropdown-info">
                <span class="dropdown-nome">${nomeBd}</span>
                <span class="dropdown-email">${emailBd}</span>
                <a class="btn-editar-usuario" onclick="document.getElementById('modal-avatar').style.display='flex'" style="cursor:pointer;">Editar avatar</a>
                <a href="/MonsterPE/src/Views/usuario/?acao=editar" class="btn-editar-usuario">Editar Informações</a>
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

document.addEventListener("DOMContentLoaded", () => {
    const avatarSalvo = localStorage.getItem("meuAvatar") || "/MonsterPE/assets/imgs/Avatars/ash.png";
    const avatarNav = document.getElementById("avatar-nav");
    
    if (avatarNav) {
        avatarNav.src = avatarSalvo;
    }
});

function trocarAvatar(novaImagem) {
    localStorage.setItem("meuAvatar", novaImagem);

    const fotoDropdown = document.getElementById("foto-perfil");
    if (fotoDropdown) {
        fotoDropdown.src = novaImagem;
    }

    const avatarNav = document.getElementById("avatar-nav");
    if (avatarNav) {
        avatarNav.src = novaImagem;
    }

    document.getElementById("modal-avatar").style.display = "none";
}