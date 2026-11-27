let timeJogador;
let timeOponente;
let arrayMoves;
let posicaoPokemonSelecionadoJogador;
let posicaoPokemonSelecionadoOponente;
let pokemonSelecionadoJogador;
let pokemonSelecionadoOponente;
let roundN = 0;
let pokemonVivoJogador = [];
let pokemonVivoOponente = [];

async function iniciarBatalha(){

    await getPokemonAndMoves();
    console.log(timeJogador);
    console.log(timeOponente);
    console.log(arrayMoves);
    
    timeJogador.forEach(pokemon => {
        if(pokemon.stats[0].base_stat > 0){
            pokemonVivoJogador.push(true);
        } else {
            pokemonVivoJogador.push(false);
        }
    });
    
    timeOponente.forEach(pokemon => {
        if(pokemon.stats[0].base_stat > 0){
            pokemonVivoOponente.push(true);
        } else {
            pokemonVivoOponente.push(false);
        }
    });

    posicaoPokemonSelecionadoJogador = 0;
    posicaoPokemonSelecionadoOponente = 0;
    pokemonSelecionadoJogador = timeJogador[posicaoPokemonSelecionadoJogador];
    pokemonSelecionadoOponente = timeOponente[posicaoPokemonSelecionadoOponente];
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
        if (timeJogador[posicaoPokemon].stats[0].base_stat <= 0) {
            alert("Este Pokémon está desmaiado e não pode batalhar!");
            return;
        }

        posicaoPokemonSelecionadoJogador = posicaoPokemon;
        pokemonSelecionadoJogador = timeJogador[posicaoPokemonSelecionadoJogador];
        fecharModal('modal-equipe');
        atualizarTela(true, false);
        
        round();
    } else {
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
            modal_equipe.innerHTML += `<button type="Button" disabled>${pokemon.apelido} (Atual)</button>`;
        } else if (pokemon.stats[0].base_stat <= 0) {
            modal_equipe.innerHTML += `<button type="Button" disabled>${pokemon.apelido} (Desmaiado)</button>`;
        } else {
            modal_equipe.innerHTML += `<button type="Button" data-acao="equipe" data-id="${pokemon.posicao}" class="btn-subacao">${pokemon.apelido}</button>`;
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
    for(let i=0; i<4; i++){
        if(arrayMoves[posicaoPokemonSelecionadoJogador][i] != null){
            menu_ataques.innerHTML += `<button type="button" data-acao='ataque' class="btn-subacao" data-id="${i}">${arrayMoves[posicaoPokemonSelecionadoJogador][i].name}</button>`;
        } else {
            menu_ataques.innerHTML += `<button type="button" disabled>vazio</button>`;
        }
    }
    menu_ataques.innerHTML += `<button type="button" onclick="voltarMenuPrincipal()">Cancelar</button>`;
}

function voltarMenuPrincipal() {
    document.getElementById('menu-ataques').style.display = 'none';
    document.getElementById('menu-principal').style.display = 'flex';
}

function turnoJogador(acao, id){
    switch (acao) {
        case "ataque":
            ataque(arrayMoves[posicaoPokemonSelecionadoJogador][id], true);
            break;
        case "equipe":
            trocarPokemon(id, true);
            break;
    }
}

function turnoOponente(acaoOponente){
    switch (acaoOponente.tipo) {
        case "ataque":
            ataque(arrayMoves[posicaoPokemonSelecionadoOponente][acaoOponente.id], false);
            break;
        case "equipe":
            trocarPokemon(acaoOponente.id, false);
            console.log("O oponente trocou de Pokémon estrategicamente!");
            break;
    }
}

function gerarInteiro(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

const tabelaTipos = {
    normal: { pedra: 0.5, aco: 0.5, fantasma: 0.0 },
    fogo: { grama: 2.0, gelo: 2.0, inseto: 2.0, aco: 2.0, fogo: 0.5, agua: 0.5, pedra: 0.5, dragao: 0.5 },
    agua: { fogo: 2.0, terra: 2.0, pedra: 2.0, agua: 0.5, grama: 0.5, dragao: 0.5 },
    grama: { agua: 2.0, terra: 2.0, pedra: 2.0, fogo: 0.5, grama: 0.5, veneno: 0.5, voador: 0.5, inseto: 0.5, dragao: 0.5, aco: 0.5 },
    eletrico: { agua: 2.0, voador: 2.0, eletrico: 0.5, grama: 0.5, dragao: 0.5, terra: 0.0 },
    gelo: { grama: 2.0, terra: 2.0, voador: 2.0, dragao: 2.0, fogo: 0.5, agua: 0.5, gelo: 0.5, aco: 0.5 },
    lutador: { normal: 2.0, gelo: 2.0, pedra: 2.0, sombrio: 2.0, aco: 2.0, veneno: 0.5, voador: 0.5, psiquico: 0.5, inseto: 0.5, fada: 0.5, fantasma: 0.0 },
    veneno: { grama: 2.0, fada: 2.0, veneno: 0.5, terra: 0.5, pedra: 0.5, fantasma: 0.5, aco: 0.0 },
    terra: { fogo: 2.0, eletrico: 2.0, veneno: 2.0, pedra: 2.0, aco: 2.0, grama: 0.5, inseto: 0.5, voador: 0.0 },
    voador: { grama: 2.0, lutador: 2.0, inseto: 2.0, eletrico: 0.5, pedra: 0.5, aco: 0.5 },
    psiquico: { lutador: 2.0, veneno: 2.0, psiquico: 0.5, aco: 0.5, sombrio: 0.0 },
    inseto: { grama: 2.0, psiquico: 2.0, sombrio: 2.0, fogo: 0.5, lutador: 0.5, veneno: 0.5, voador: 0.5, fantasma: 0.5, aco: 0.5, fada: 0.5 },
    pedra: { fogo: 2.0, gelo: 2.0, voador: 2.0, inseto: 2.0, lutador: 0.5, terra: 0.5, aco: 0.5 },
    fantasma: { psiquico: 2.0, fantasma: 2.0, sombrio: 0.5, normal: 0.0 },
    dragao: { dragao: 2.0, aco: 0.5, fada: 0.0 },
    sombrio: { psiquico: 2.0, fantasma: 2.0, lutador: 0.5, sombrio: 0.5, fada: 0.5 },
    aco: { gelo: 2.0, pedra: 2.0, fada: 2.0, fogo: 0.5, agua: 0.5, eletrico: 0.5, aco: 0.5 },
    fada: { lutador: 2.0, dragao: 2.0, sombrio: 2.0, fogo: 0.5, veneno: 0.5, aco: 0.5 }
};

function calcularMultiplicadorTipo(tipoAtaque, tiposOponente) {
    let multiplicadorTotal = 1.0;
    const ataque = tipoAtaque.toLowerCase();

    if (!tabelaTipos[ataque]) return 1.0; 

    for (let tipoDefesa of tiposOponente) {
        let nomeTipo = tipoDefesa.type ? tipoDefesa.type.name : tipoDefesa;
        nomeTipo = nomeTipo.toLowerCase();

        if (tabelaTipos[ataque][nomeTipo] !== undefined) {
            multiplicadorTotal *= tabelaTipos[ataque][nomeTipo];
        }
    }

    return multiplicadorTotal;
}

function escolherAcaoOponente() {
    const movesOponente = arrayMoves[posicaoPokemonSelecionadoOponente];
    const pokemonOponenteAtual = pokemonSelecionadoOponente;
    
    let hpAtual = pokemonOponenteAtual.stats[0].base_stat;
    if (hpAtual < 50) {
        let pokemonsDisponiveisParaTroca = [];
        timeOponente.forEach((poke, index) => {
            if (index !== posicaoPokemonSelecionadoOponente && pokemonVivoOponente[index] && poke.stats[0].base_stat > 0) {
                pokemonsDisponiveisParaTroca.push(index);
            }
        });

        if (pokemonsDisponiveisParaTroca.length > 0 && Math.random() < 0.4) {
            const escolhaTroca = pokemonsDisponiveisParaTroca[Math.floor(Math.random() * pokemonsDisponiveisParaTroca.length)];
            return {
                tipo: "equipe",
                id: escolhaTroca
            };
        }
    }

    let melhorIndiceAque = 0;
    let maiorPontuacaoDano = -1;

    for (let i = 0; i < movesOponente.length; i++) {
        const move = movesOponente[i];
        if (move != null && move.power) {
            let poderBase = move.power;
            let multTipo = calcularMultiplicadorTipo(move.type.name, pokemonSelecionadoJogador.types);
            
            let temStab = false;
            pokemonOponenteAtual.types.forEach(tipo => {
                if (tipo.type.name === move.type.name) temStab = true;
            });
            let bonusStab = temStab ? 1.5 : 1.0;

            let pontuacaoEstimada = poderBase * multTipo * bonusStab;

            if (pontuacaoEstimada > maiorPontuacaoDano) {
                maiorPontuacaoDano = pontuacaoEstimada;
                melhorIndiceAque = i;
            }
        }
    }

    if (maiorPontuacaoDano === -1) {
        for (let i = 0; i < movesOponente.length; i++) {
            if (movesOponente[i] != null) {
                melhorIndiceAque = i;
                break;
            }
        }
    }

    return {
        tipo: "ataque",
        id: melhorIndiceAque
    };
}

function calculoDePrioridade(tipoAcao, idAcao, jogador = null){
    switch (tipoAcao) {
        case "ataque":
            let time;
            let posicaoPokemon;
            if(jogador){
                time = timeJogador;
                posicaoPokemon = posicaoPokemonSelecionadoJogador;
            } else {
                time = timeOponente;
                posicaoPokemon = posicaoPokemonSelecionadoOponente;
            }
            return [arrayMoves[posicaoPokemon][idAcao].priority, time[posicaoPokemon].stats[5].base_stat];
        case "equipe":
            return [10, false];
    }
}

function ataque(move, jogador = null){
    let timeAtacante;
    let timeSofredor;
    let posicaoPokemonAtacante;
    let posicaoPokemonSofredor;
    
    if(jogador){
        timeAtacante = timeJogador;
        timeSofredor = timeOponente;
        posicaoPokemonAtacante = posicaoPokemonSelecionadoJogador;
        posicaoPokemonSofredor = posicaoPokemonSelecionadoOponente;
    } else {
        timeAtacante = timeOponente;
        timeSofredor = timeJogador;
        posicaoPokemonAtacante = posicaoPokemonSelecionadoOponente;
        posicaoPokemonSofredor = posicaoPokemonSelecionadoJogador;
    }

    if (move.meta && move.meta.ailment) {
        let efeito = move.meta.ailment.name;
        timeSofredor[posicaoPokemonSofredor].status = efeito;
    }

    const poder = move.power || 0;
    const nivelDano = timeAtacante[posicaoPokemonAtacante].nivel;
    
    let ataqueStatus;
    let defesaStatus;
    
    const chanceCriticoBase = 1/24;
    const chanceCriticoFinal = chanceCriticoBase + (Math.floor(roundN/3) * (chanceCriticoBase/2));

    let STAB = false;
    
    switch (move.damage_class.name) {
        case 'physical':
            ataqueStatus = timeAtacante[posicaoPokemonAtacante].stats[1].base_stat;
            defesaStatus = timeSofredor[posicaoPokemonSofredor].stats[2].base_stat;
            break;
        case 'special':
            ataqueStatus = timeAtacante[posicaoPokemonAtacante].stats[3].base_stat;
            defesaStatus = timeSofredor[posicaoPokemonSofredor].stats[4].base_stat;
            break;
        default:
            ataqueStatus = timeAtacante[posicaoPokemonAtacante].stats[1].base_stat;
            defesaStatus = timeSofredor[posicaoPokemonSofredor].stats[2].base_stat;
            break;
    }

    let dano = (Math.trunc(((Math.trunc((2*nivelDano)/5)+2) * poder * Math.trunc(ataqueStatus/defesaStatus)) / 50) + 2);
            
    if(Math.random() < chanceCriticoFinal){
        dano *= 1.5;
    }

    dano = (dano * gerarInteiro(85, 100)) / 100;

    timeAtacante[posicaoPokemonAtacante].types.forEach(tipo => {
        if(tipo.type.name == move.type.name){
            STAB = true;
        }
    });
    
    if(STAB){
        dano *= 1.5;
    }
    
    dano *= calcularMultiplicadorTipo(move.type.name, timeSofredor[posicaoPokemonSofredor].types);
    dano = Math.floor(dano);

    timeSofredor[posicaoPokemonSofredor].stats[0].base_stat -= dano;
    if(timeSofredor[posicaoPokemonSofredor].stats[0].base_stat <= 0) {
        timeSofredor[posicaoPokemonSofredor].stats[0].base_stat = 0;
    }

    atualizarTela();
}

function round() {
    roundN++;
    atualizarTela();
    document.getElementById('menu-principal').style.display = 'flex';
    console.log("Round:", roundN);
}

function finalizarBatalha(vencedor) {
    if(vencedor === 'jogador') {
        alert("Parabéns! Você venceu a batalha!");
    } else {
        alert("Você foi derrotado!");
    }
    location.reload(); 
}

function processarTurnoCompleto(tipoAcaoJogador, idAcaoJogador) {

    const acaoOponente = escolherAcaoOponente();

    const prioridadeJogador = calculoDePrioridade(tipoAcaoJogador, idAcaoJogador, true);
    const prioridadeOponente = calculoDePrioridade(acaoOponente.tipo, acaoOponente.id, false);

    let jogadorVaiPrimeiro = false;

    if (tipoAcaoJogador === 'equipe') {
        jogadorVaiPrimeiro = true;
    } else if (acaoOponente.tipo === 'equipe') {
        jogadorVaiPrimeiro = false;
    } else if (prioridadeJogador[0] > prioridadeOponente[0]) {
        jogadorVaiPrimeiro = true;
    } else if (prioridadeJogador[0] < prioridadeOponente[0]) {
        jogadorVaiPrimeiro = false;
    } else {
        jogadorVaiPrimeiro = prioridadeJogador[1] >= prioridadeOponente[1];
    }

    function verificarOponenteMorto() {
        if (pokemonSelecionadoOponente.stats[0].base_stat <= 0) {
            pokemonVivoOponente[posicaoPokemonSelecionadoOponente] = false;
            
            for (let i = 0; i < timeOponente.length; i++) {
                pokemonVivoOponente[i] = timeOponente[i].stats[0].base_stat > 0;
            }

            if (pokemonVivoOponente.includes(true)) {
                let pokemonVivos = [];
                pokemonVivoOponente.forEach((vivo, index) => {
                    if (vivo) pokemonVivos.push(index);
                });
                let novoPokemon = pokemonVivos[Math.floor(Math.random() * pokemonVivos.length)];
                trocarPokemon(novoPokemon, false);
                round();
                return true;
            } else {
                finalizarBatalha('jogador');
                return true;
            }
        }
        return false;
    }

    function verificarJogadorMorto() {
        if (pokemonSelecionadoJogador.stats[0].base_stat <= 0) {
            pokemonVivoJogador[posicaoPokemonSelecionadoJogador] = false;
            
            for (let i = 0; i < timeJogador.length; i++) {
                pokemonVivoJogador[i] = timeJogador[i].stats[0].base_stat > 0;
            }

            if (pokemonVivoJogador.includes(true)) {
                alert("Seu Pokémon desmaiou! Escolha outro.");
                abrirModal('modal-equipe');
                carregarModal_Equipe();
                return true;
            } else {
                finalizarBatalha('oponente');
                return true;
            }
        }
        return false;
    }

    if (jogadorVaiPrimeiro) {
        turnoJogador(tipoAcaoJogador, idAcaoJogador);
        
        if (tipoAcaoJogador === 'equipe') {
            console.log("Você trocou de Pokémon. O oponente aproveita para agir!");
            turnoOponente(acaoOponente);
            if (verificarJogadorMorto()) return;
        } else {
            if (verificarOponenteMorto()) return;
            turnoOponente(acaoOponente);
            if (verificarJogadorMorto()) return;
        }

    } else {
        turnoOponente(acaoOponente);

        if (verificarJogadorMorto()) return;

        if (acaoOponente.tipo === 'equipe') {
            console.log("O oponente trocou de Pokémon.");
        } else {
            turnoJogador(tipoAcaoJogador, idAcaoJogador);
            if (verificarOponenteMorto()) return;
        }
    }

    round();
}

document.addEventListener('DOMContentLoaded', () => {
    
    const menu_principal = document.getElementById('menu-principal');
    if (menu_principal) {
        menu_principal.addEventListener('click', (evento) => {
            const botao = evento.target.closest('button');
            if (!botao) return;

            const acao = botao.getAttribute('data-acao-principal');
            switch (acao) {
                case 'atacar':
                    mostrarAtaques();
                    break;
                case 'mochila':
                    alert("A mochila está indisponível no momento!");
                    break;
                case 'equipe':
                    abrirModal('modal-equipe');
                    carregarModal_Equipe();
                    break;
                case 'fugir':
                    abrirModal('modal-fugir');
                    break;
            }
        });
    }

    document.addEventListener('click', (evento) => {
        const botaoSub = evento.target.closest('.btn-subacao');
        if (!botaoSub) return;

        const tipoAcao = botaoSub.getAttribute('data-acao');
        const idAcao = botaoSub.getAttribute('data-id');

        fecharModal('modal-equipe');
        fecharModal('modal-mochila');
        const menuAtaques = document.getElementById('menu-ataques');
        if (menuAtaques) menuAtaques.style.display = 'none';

        processarTurnoCompleto(tipoAcao, idAcao);
    });
});

function fugirDaBatalha() {
    alert("Você fugiu em segurança!");
    location.href = "../";
}

const coresTipos = {
    normal: '#A8A77A',
    fire: '#EE8130',
    water: '#6390F0',
    electric: '#F7D02C',
    grass: '#7AC74C',
    ice: '#96D9D6',
    fighting: '#C22E28',
    poison: '#A33EA1',
    ground: '#E2BF65',
    flying: '#A98FF3',
    psychic: '#F95587',
    bug: '#A6B91A',
    rock: '#B6A136',
    ghost: '#735797',
    dragon: '#6F35FC',
    dark: '#705848',
    steel: '#B7B7CE',
    fairy: '#D685AD'
};