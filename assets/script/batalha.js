let timeJogador;
let timeOponente
let arrayMoves;
let posicaoPokemonSelecionadoJogador;
let posicaoPokemonSelecionadoOponente;
let pokemonSelecionadoJogador;
let pokemonSelecionadoOponente;

async function iniciarBatalha(){

    await getPokemonAndMoves();
    console.log(timeJogador);
    console.log(timeOponente);
    console.log(arrayMoves);
    trocarPokemon(0, true);
    trocarPokemon(0, false);
    atualizarTela();
    round();
}

async function getPokemonAndMoves(){

    try{
        const resposta = await fetch("../pokemon/?acao=getPokemonAndMoves");
        const dados = await resposta.json();

        const promissesAtivo = dados[1].map(pokemon => formatarPokemon(pokemon, true));
        timeJogador = await Promise.all(promissesAtivo);
        timeOponente = structuredClone(timeJogador);
        const promissesPokemonMoves = dados[2].map(pokemon => formatarMoves(pokemon));
        arrayMoves = await Promise.all(promissesPokemonMoves);

    }catch (erro) {
        console.error("Erro ao buscar:", erro);
    }

}

function trocarPokemon(posicaoPokemon, usuario = null){
    if(usuario){
        posicaoPokemonSelecionadoJogador = posicaoPokemon;
        pokemonSelecionadoJogador = timeJogador[posicaoPokemonSelecionadoJogador];
        carregarModal_Equipe();
        atualizarTela(true, false);
    }
    else{
        posicaoPokemonSelecionadoOponente = posicaoPokemon;
        pokemonSelecionadoOponente = timeOponente[posicaoPokemonSelecionadoOponente];
        atualizarTela(false, true);
    }
}

function atualizarTela(jogador = true, oponente = true){
    
    if(jogador){
        const sprite_jogador = document.getElementById(`sprite-jogador`);
        const hp_texto_jogador = document.getElementById(`hp-texto-jogador`);
        const level_jogador = document.getElementById(`level-jogador`);
        const nome_jogador = document.getElementById(`nome-jogador`);

        sprite_jogador.src = pokemonSelecionadoJogador.sprites.back_default;
        hp_texto_jogador.innerHTML = pokemonSelecionadoJogador.stats[0].base_stat;
        level_jogador.innerHTML =  pokemonSelecionadoJogador.nivel;
        nome_jogador.innerHTML = pokemonSelecionadoJogador.apelido;
    }

    if(oponente){
        const sprite_oponente = document.getElementById(`sprite-oponente`);
        const hp_texto_oponente = document.getElementById(`hp-texto-oponente`);
        const level_oponente = document.getElementById(`level-oponente`);
        const nome_oponente = document.getElementById(`nome-oponente`);

        sprite_oponente.src = pokemonSelecionadoOponente.sprites.front_default;
        hp_texto_oponente.innerHTML = pokemonSelecionadoOponente.stats[0].base_stat;
        level_oponente.innerHTML =  pokemonSelecionadoOponente.nivel;
        nome_oponente.innerHTML = pokemonSelecionadoOponente.apelido;
    }

}

function carregarModal_Equipe(){
    const modal_equipe = document.querySelector("#modal-equipe > div > div");
    modal_equipe.innerHTML = "";
    timeJogador.forEach(pokemon => {
        if(pokemon.posicao == posicaoPokemonSelecionadoJogador){
            modal_equipe.innerHTML += `<button type="Button" onclick="trocarPokemon(${pokemon.posicao})" disabled>${pokemon.apelido}</button>`
        }
        else{
            modal_equipe.innerHTML += `<button type="Button" onclick="trocarPokemon(${pokemon.posicao}, true)">${pokemon.apelido}</button>`
        }
    });
}

function abrirModal(idModal) {
    document.getElementById(idModal).style.display = 'flex';
}

function fecharModal(idModal) {
    document.getElementById(idModal).style.display = 'none';
}

function mostrarAtaques() {
    document.getElementById('menu-principal').style.display = 'none';
    const menu_ataques = document.getElementById('menu-ataques');
    menu_ataques.style.display = 'flex';
    menu_ataques.innerHTML = "";
    for(let i=0;i<4;i++){
        if(arrayMoves[posicaoPokemonSelecionadoJogador][i] != null){
            menu_ataques.innerHTML += `<button type="button" data-pos=${i}>${arrayMoves[posicaoPokemonSelecionadoJogador][i].name}</button>`;
        }
        else{
            menu_ataques.innerHTML += `<button type="button" onclick="" disabled>vazio</button>`;
        }
    }
    menu_ataques.innerHTML += `<button type="button" onclick="voltarMenuPrincipal()">Cancelar</button>`;

}

function voltarMenuPrincipal() {
    document.getElementById('menu-ataques').style.display = 'none';
    document.getElementById('menu-principal').style.display = 'flex';
}

function round(){
    
    const menu_ataques = document.getElementById('menu-ataques');
    menu_ataques.addEventListener('click', (evento) => {
        const botao = evento.target.closest('button');

        const move = arrayMoves[posicaoPokemonSelecionadoJogador][botao.getAttribute('data-pos')];

        ataque(move);
        atualizarTela();
    });

}

function ataque(move){
    switch (move.damage_class.name) {
        case 'status':
            
            break;

        case 'physical':
            
            break;

        case 'special':
            
            break;

        default:
            break;
    }
}