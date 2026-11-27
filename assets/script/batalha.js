// =====================================================================
//  MonsterPE - Batalha
//  Turnos acontecem em sequência (mensagem por mensagem), a mochila do
//  usuário é usada de verdade e todo o combate escreve no histórico.
// =====================================================================

let timeJogador = [];
let timeOponente = [];
let arrayMoves = [];          // golpes de cada posição do time (o oponente usa os mesmos índices)
let inventario = [];          // mochila do usuário, carregada do servidor
let roundN = 0;
let bloqueado = true;         // true enquanto um turno está sendo executado
let modoEquipe = 'troca';     // 'troca' (voluntária) ou 'forcado' (Pokémon desmaiou)
let resolverSubstituto = null;
let fimDeJogo = false;
let eventosBatalha = [];   // todas as mensagens do combate, enviadas ao log no fim
let batalhaEnviada = false;
let ulRoundAtual = null;

const estado = {
    jogador:  { time: null, pos: 0 },
    oponente: { time: null, pos: 0 }
};

const VELOCIDADE_MSG = 650;   // ms entre mensagens

// ---------------------------------------------------------------------
//  Dados estáticos
// ---------------------------------------------------------------------

const coresTipos = {
    normal: '#A8A77A', fire: '#EE8130', water: '#6390F0', electric: '#F7D02C',
    grass: '#7AC74C', ice: '#96D9D6', fighting: '#C22E28', poison: '#A33EA1',
    ground: '#E2BF65', flying: '#A98FF3', psychic: '#F95587', bug: '#A6B91A',
    rock: '#B6A136', ghost: '#735797', dragon: '#6F35FC', dark: '#705848',
    steel: '#B7B7CE', fairy: '#D685AD'
};

const nomesTipos = {
    normal: 'Normal', fire: 'Fogo', water: 'Água', electric: 'Elétrico', grass: 'Grama',
    ice: 'Gelo', fighting: 'Lutador', poison: 'Venenoso', ground: 'Terra', flying: 'Voador',
    psychic: 'Psíquico', bug: 'Inseto', rock: 'Pedra', ghost: 'Fantasma', dragon: 'Dragão',
    dark: 'Sombrio', steel: 'Metal', fairy: 'Fada'
};

// A PokeAPI devolve os tipos em inglês, então a tabela também é em inglês.
const tabelaTipos = {
    normal:   { rock: 0.5, steel: 0.5, ghost: 0 },
    fire:     { grass: 2, ice: 2, bug: 2, steel: 2, fire: 0.5, water: 0.5, rock: 0.5, dragon: 0.5 },
    water:    { fire: 2, ground: 2, rock: 2, water: 0.5, grass: 0.5, dragon: 0.5 },
    grass:    { water: 2, ground: 2, rock: 2, fire: 0.5, grass: 0.5, poison: 0.5, flying: 0.5, bug: 0.5, dragon: 0.5, steel: 0.5 },
    electric: { water: 2, flying: 2, electric: 0.5, grass: 0.5, dragon: 0.5, ground: 0 },
    ice:      { grass: 2, ground: 2, flying: 2, dragon: 2, fire: 0.5, water: 0.5, ice: 0.5, steel: 0.5 },
    fighting: { normal: 2, ice: 2, rock: 2, dark: 2, steel: 2, poison: 0.5, flying: 0.5, psychic: 0.5, bug: 0.5, fairy: 0.5, ghost: 0 },
    poison:   { grass: 2, fairy: 2, poison: 0.5, ground: 0.5, rock: 0.5, ghost: 0.5, steel: 0 },
    ground:   { fire: 2, electric: 2, poison: 2, rock: 2, steel: 2, grass: 0.5, bug: 0.5, flying: 0 },
    flying:   { grass: 2, fighting: 2, bug: 2, electric: 0.5, rock: 0.5, steel: 0.5 },
    psychic:  { fighting: 2, poison: 2, psychic: 0.5, steel: 0.5, dark: 0 },
    bug:      { grass: 2, psychic: 2, dark: 2, fire: 0.5, fighting: 0.5, poison: 0.5, flying: 0.5, ghost: 0.5, steel: 0.5, fairy: 0.5 },
    rock:     { fire: 2, ice: 2, flying: 2, bug: 2, fighting: 0.5, ground: 0.5, steel: 0.5 },
    ghost:    { psychic: 2, ghost: 2, dark: 0.5, normal: 0 },
    dragon:   { dragon: 2, steel: 0.5, fairy: 0 },
    dark:     { psychic: 2, ghost: 2, fighting: 0.5, dark: 0.5, fairy: 0.5 },
    steel:    { ice: 2, rock: 2, fairy: 2, fire: 0.5, water: 0.5, electric: 0.5, steel: 0.5 },
    fairy:    { fighting: 2, dragon: 2, dark: 2, fire: 0.5, poison: 0.5, steel: 0.5 }
};

const STATUS_ABREV = { paralysis: 'PAR', burn: 'QMD', poison: 'ENV', sleep: 'SON', freeze: 'CGL' };
const STATUS_NOME  = { paralysis: 'paralisado', burn: 'queimado', poison: 'envenenado', sleep: 'dormindo', freeze: 'congelado' };

// Imunidades de tipo a status (como nos jogos)
const IMUNE_STATUS = {
    burn: ['fire'],
    paralysis: ['electric'],
    poison: ['poison', 'steel'],
    freeze: ['ice']
};

const STAT_INDICE = { attack: 'atk', defense: 'def', 'special-attack': 'spa', 'special-defense': 'spd', speed: 'spe' };
const STAT_NOME = { atk: 'Ataque', def: 'Defesa', spa: 'Ataque Esp.', spd: 'Defesa Esp.', spe: 'Velocidade' };
// posição de cada stat dentro de pokemon.stats (formato da PokeAPI)
const STAT_POSICAO = { atk: 1, def: 2, spa: 3, spd: 4, spe: 5 };

// Golpe usado quando o Pokémon está sem nenhum ataque
const LUTA = {
    name: 'struggle', power: 50, accuracy: null, priority: 0,
    type: { name: 'typeless' }, damage_class: { name: 'physical' },
    meta: { drain: -25, ailment: { name: 'none' } }, stat_changes: [], target: { name: 'selected-pokemon' }
};

// ---------------------------------------------------------------------
//  Efeitos dos itens da loja dentro da batalha (chave = nome em minúsculo)
//  alvo: true  -> o jogador escolhe qual Pokémon do time recebe o item
// ---------------------------------------------------------------------
const EFEITOS_ITENS = {
    'potion':          { tipo: 'cura', valor: 20, alvo: true },
    'super potion':    { tipo: 'cura', valor: 50, alvo: true },
    'hyper potion':    { tipo: 'cura', valor: 200, alvo: true },
    'max potion':      { tipo: 'cura', total: true, alvo: true },
    'full restore':    { tipo: 'cura', total: true, status: 'todos', alvo: true },
    'revive':          { tipo: 'revive', alvo: true },
    'antidote':        { tipo: 'status', status: ['poison'], alvo: true },
    'awakening':       { tipo: 'status', status: ['sleep'], alvo: true },
    'burn heal':       { tipo: 'status', status: ['burn'], alvo: true },
    'paralyze heal':   { tipo: 'status', status: ['paralysis'], alvo: true },
    'ice heal':        { tipo: 'status', status: ['freeze'], alvo: true },
    'full heal':       { tipo: 'status', status: 'todos', alvo: true },
    'rare candy':      { tipo: 'candy', alvo: true },
    'sweet honey':     { tipo: 'mel', alvo: false },
    'precious ruby':   { tipo: 'protecao', alvo: false },
    'lucky egg':       { tipo: 'sorte', alvo: true },
    'evolution stone': { tipo: 'indisponivel', motivo: 'Só pode ser usada fora da batalha.' }
};

// ---------------------------------------------------------------------
//  Utilidades
// ---------------------------------------------------------------------

const sleep = (ms) => new Promise(r => setTimeout(r, ms));

function esc(texto) {
    const d = document.createElement('div');
    d.textContent = texto ?? '';
    return d.innerHTML;
}

function gerarInteiro(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function outro(lado) { return lado === 'jogador' ? 'oponente' : 'jogador'; }
function ativo(lado) { return estado[lado].time[estado[lado].pos]; }
function hpAtual(p) { return p.stats[0].base_stat; }
function vivo(p) { return hpAtual(p) > 0; }
function setHp(p, valor) { p.stats[0].base_stat = Math.max(0, Math.min(p.b.hpMax, Math.floor(valor))); }
function tiposDe(p) { return p.types.map(t => t.type.name); }

function nomeGolpe(move) {
    const pt = move.names?.find(n => n.language?.name === 'pt-BR')?.name;
    if (pt) return pt;
    return move.name.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
}

// "Seu X" / "X do oponente" para as mensagens ficarem claras
function rotulo(lado, p) {
    return lado === 'jogador' ? p.apelido : `${p.apelido} (oponente)`;
}

function spriteDe(p, costas) {
    const s = p.sprites || {};
    const show = s.other?.showdown;
    if (costas) return show?.back_default || s.back_default || s.front_default || '';
    return show?.front_default || s.front_default || '';
}

function prepararPokemon(p) {
    const hp = p.stats[0].base_stat;
    p.b = {
        hpMax: Math.max(hp, 1),
        status: null,      // paralysis | burn | poison | sleep | freeze
        sono: 0,
        confuso: 0,
        protecao: 0,       // turnos restantes do Precious Ruby
        sorte: false,      // Lucky Egg: dobra a chance de crítico
        desmaiou: hp <= 0,
        stages: { atk: 0, def: 0, spa: 0, spd: 0, spe: 0 }
    };
}

function resetarEstadoTemporario(p) {
    p.b.confuso = 0;
    p.b.protecao = 0;
    p.b.stages = { atk: 0, def: 0, spa: 0, spd: 0, spe: 0 };
}

// ---------------------------------------------------------------------
//  Início da batalha
// ---------------------------------------------------------------------

async function iniciarBatalha() {

    await getPokemonAndMoves();

    if (!timeJogador || timeJogador.length === 0) {
        definirMensagem("Não foi possível carregar a batalha. Volte e tente de novo.");
        return;
    }

    timeJogador.forEach(prepararPokemon);
    timeOponente.forEach(prepararPokemon);

    estado.jogador.time = timeJogador;
    estado.oponente.time = timeOponente;
    estado.jogador.pos = Math.max(0, timeJogador.findIndex(vivo));
    estado.oponente.pos = Math.max(0, timeOponente.findIndex(vivo));

    await carregarInventario();

    atualizarTela();
    abrirRound(true);
    registrar(`Batalha iniciada! Vai, ${ativo('jogador').apelido}!`);
    bloquear(false);
}

async function getPokemonAndMoves() {
    try {
        const resposta = await fetch("../pokemon/?acao=getPokemonAndMoves");
        const dados = await resposta.json();

        const promissesAtivo = dados[1].map(pokemon => formatarPokemon(pokemon, true));
        timeJogador = await Promise.all(promissesAtivo);
        timeOponente = structuredClone(timeJogador);
        const promissesMoves = dados[2].map(pokemon => formatarMoves(pokemon));
        arrayMoves = (await Promise.all(promissesMoves)).map(lista => (lista || []).filter(Boolean));
    } catch (erro) {
        console.error("Erro ao buscar:", erro);
        timeJogador = [];
        timeOponente = [];
    }
}

async function carregarInventario() {
    try {
        const resposta = await fetch("../item/?acao=mochila");
        const dados = await resposta.json();
        inventario = dados.sucesso ? dados.itens : [];
    } catch (erro) {
        console.error("Erro ao carregar a mochila:", erro);
        inventario = [];
    }
}

// ---------------------------------------------------------------------
//  Tela
// ---------------------------------------------------------------------

function corHp(pct) {
    if (pct > 50) return '#32cd32';
    if (pct > 20) return '#f5c518';
    return '#e53935';
}

function atualizarCard(lado) {
    const p = ativo(lado);
    const sufixo = lado;
    const costas = lado === 'jogador';

    const sprite = document.getElementById(`sprite-${sufixo}`);
    const novoSrc = spriteDe(p, costas);
    if (sprite.getAttribute('src') !== novoSrc) sprite.src = novoSrc;
    sprite.classList.toggle('sprite-desmaiado', !vivo(p));

    document.getElementById(`nome-${sufixo}`).textContent = p.apelido;
    document.getElementById(`level-${sufixo}`).textContent = `Lv ${p.nivel}`;

    document.getElementById(`tipos-${sufixo}`).innerHTML = tiposDe(p).map(t =>
        `<span class="tipo-badge" style="background:${coresTipos[t] || '#777'}">${esc(nomesTipos[t] || t)}</span>`
    ).join('');

    let badges = '';
    if (p.b.status) badges += `<span class="status-badge status-${p.b.status}">${STATUS_ABREV[p.b.status]}</span>`;
    if (p.b.confuso > 0) badges += `<span class="status-badge status-confusion">CNF</span>`;
    if (p.b.protecao > 0) badges += `<span class="status-badge status-protecao">ESC</span>`;
    document.getElementById(`status-${sufixo}`).innerHTML = badges;

    const hp = hpAtual(p);
    const pct = Math.max(0, Math.min(100, (hp / p.b.hpMax) * 100));
    const fill = document.getElementById(`hp-${sufixo}-fill`);
    fill.style.width = `${pct}%`;
    fill.style.background = corHp(pct);
    document.getElementById(`hp-texto-${sufixo}`).textContent = `${hp}/${p.b.hpMax}`;
}

function atualizarTela() {
    atualizarCard('jogador');
    atualizarCard('oponente');
}

async function animarSprite(lado, classe, ms = 450) {
    const sprite = document.getElementById(`sprite-${lado}`);
    sprite.classList.add(classe);
    await sleep(ms);
    sprite.classList.remove(classe);
}

function definirMensagem(texto) {
    const caixa = document.getElementById('mensagem-batalha');
    if (caixa) caixa.textContent = texto;
}

function abrirRound(inicio = false) {
    const lista = document.getElementById('log-rounds');
    ulRoundAtual = document.createElement('ul');
    const titulo = document.createElement('h3');
    titulo.textContent = inicio ? 'Início' : `Round ${roundN}`;
    ulRoundAtual.appendChild(titulo);
    lista.appendChild(ulRoundAtual);
}

function registrar(texto, classe = '') {
    eventosBatalha.push({ round: roundN, texto: texto });
    if (!ulRoundAtual) abrirRound(true);
    const li = document.createElement('li');
    li.textContent = texto;
    if (classe) li.className = classe;
    ulRoundAtual.appendChild(li);
    const lista = document.getElementById('log-rounds');
    lista.scrollTop = lista.scrollHeight;
}

// Escreve no histórico, mostra na caixa de mensagem e espera um pouco
async function msg(texto, classe = '', ms = VELOCIDADE_MSG) {
    registrar(texto, classe);
    definirMensagem(texto);
    await sleep(ms);
}

function bloquear(valor) {
    bloqueado = valor;
    document.getElementById('menu-principal').style.display = valor ? 'none' : 'flex';
    document.getElementById('menu-ataques').style.display = 'none';
    if (!valor && !fimDeJogo) {
        definirMensagem(`O que ${ativo('jogador').apelido} vai fazer?`);
    }
}

function abrirModal(idModal) {
    document.getElementById(idModal).style.display = 'flex';
}

function fecharModal(idModal) {
    document.getElementById(idModal).style.display = 'none';
}

// ---------------------------------------------------------------------
//  Menus: ataques, equipe, mochila
// ---------------------------------------------------------------------

function mostrarAtaques() {
    if (bloqueado) return;
    document.getElementById('menu-principal').style.display = 'none';
    const menu = document.getElementById('menu-ataques');
    menu.style.display = 'flex';
    menu.innerHTML = '';

    const moves = arrayMoves[estado.jogador.pos] || [];
    if (moves.length === 0) {
        menu.innerHTML = `<button type="button" class="btn-golpe" data-luta="1">Luta</button>`;
    } else {
        moves.forEach((move, i) => {
            const tipo = move.type?.name;
            const poder = move.power ? `Poder ${move.power}` : 'Status';
            menu.innerHTML += `
                <button type="button" class="btn-golpe" data-idx="${i}" style="border-color:${coresTipos[tipo] || '#fff'}">
                    <span class="golpe-nome">${esc(nomeGolpe(move))}</span>
                    <span class="golpe-info">${esc(nomesTipos[tipo] || tipo)} · ${poder}</span>
                </button>`;
        });
    }
    menu.innerHTML += `<button type="button" onclick="voltarMenuPrincipal()">Cancelar</button>`;
}

function voltarMenuPrincipal() {
    document.getElementById('menu-ataques').style.display = 'none';
    document.getElementById('menu-principal').style.display = 'flex';
}

function renderEquipe() {
    const lista = document.getElementById('equipe-lista');
    const forcado = modoEquipe === 'forcado';
    document.getElementById('equipe-titulo').textContent = forcado ? 'Escolha o próximo Pokémon' : 'Sua Equipe';
    document.getElementById('equipe-fechar').style.display = forcado ? 'none' : '';

    lista.innerHTML = timeJogador.map((p, i) => {
        const pct = Math.max(0, (hpAtual(p) / p.b.hpMax) * 100);
        let rotuloExtra = '';
        let desabilitado = false;
        if (i === estado.jogador.pos && vivo(p)) { rotuloExtra = ' (Em campo)'; desabilitado = true; }
        else if (!vivo(p)) { rotuloExtra = ' (Desmaiado)'; desabilitado = true; }
        const st = p.b.status ? ` <span class="status-badge status-${p.b.status}">${STATUS_ABREV[p.b.status]}</span>` : '';
        return `
            <button type="button" class="linha-equipe btn-equipe" data-idx="${i}" ${desabilitado ? 'disabled' : ''}>
                <img src="${esc(spriteDe(p, false))}" alt="">
                <span class="linha-nome">${esc(p.apelido)}${rotuloExtra}${st}<small>Lv ${p.nivel}</small></span>
                <span class="linha-hp">
                    <span class="mini-hp"><span style="width:${pct}%;background:${corHp(pct)}"></span></span>
                    ${hpAtual(p)}/${p.b.hpMax}
                </span>
            </button>`;
    }).join('');
}

function abrirEquipe() {
    if (bloqueado) return;
    modoEquipe = 'troca';
    renderEquipe();
    abrirModal('modal-equipe');
}

// Pokémon desmaiou: o jogador é obrigado a escolher outro
function escolherSubstituto() {
    modoEquipe = 'forcado';
    renderEquipe();
    abrirModal('modal-equipe');
    return new Promise(resolve => { resolverSubstituto = resolve; });
}

// ---------------------------------------------------------------------
//  Mochila
// ---------------------------------------------------------------------

function efeitoDoItem(item) {
    return EFEITOS_ITENS[item.nome.toLowerCase().trim()] || { tipo: 'indisponivel', motivo: 'Este item não tem uso em batalha.' };
}

function abrirMochila() {
    if (bloqueado) return;
    renderMochilaLista();
    abrirModal('modal-mochila');
}

function mostrarAvisoMochila(texto) {
    const aviso = document.getElementById('mochila-aviso');
    aviso.textContent = texto || '';
}

function renderMochilaLista() {
    document.getElementById('mochila-titulo').textContent = '🎒 Sua Mochila';
    mostrarAvisoMochila('');
    const conteudo = document.getElementById('mochila-conteudo');

    if (inventario.length === 0) {
        conteudo.innerHTML = `<p class="mochila-vazia-batalha">Sua mochila está vazia.<br>Compre itens no PokéMart!</p>`;
        return;
    }

    conteudo.innerHTML = inventario.map(item => {
        const efeito = efeitoDoItem(item);
        const indisponivel = efeito.tipo === 'indisponivel';
        return `
            <button type="button" class="linha-item btn-item" data-item="${item.id}" ${indisponivel ? 'disabled' : ''}>
                <img src="${esc(item.imagem)}" alt="">
                <span class="linha-nome">${esc(item.nome)}<small>${esc(indisponivel ? efeito.motivo : item.efeito)}</small></span>
                <span class="item-qtd">x${item.quantidade}</span>
            </button>`;
    }).join('');
}

function renderAlvosItem(item) {
    const efeito = efeitoDoItem(item);
    document.getElementById('mochila-titulo').textContent = `Usar ${item.nome} em quem?`;
    mostrarAvisoMochila('');
    const conteudo = document.getElementById('mochila-conteudo');

    conteudo.innerHTML = timeJogador.map((p, i) => {
        const pct = Math.max(0, (hpAtual(p) / p.b.hpMax) * 100);
        const motivo = motivoInvalido(efeito, p);
        const st = p.b.status ? ` <span class="status-badge status-${p.b.status}">${STATUS_ABREV[p.b.status]}</span>` : '';
        const emCampo = (i === estado.jogador.pos && vivo(p)) ? ' (Em campo)' : '';
        return `
            <button type="button" class="linha-equipe btn-alvo-item" data-item="${item.id}" data-idx="${i}" ${motivo ? 'disabled' : ''}>
                <img src="${esc(spriteDe(p, false))}" alt="">
                <span class="linha-nome">${esc(p.apelido)}${emCampo}${st}<small>${esc(motivo || `Lv ${p.nivel}`)}</small></span>
                <span class="linha-hp">
                    <span class="mini-hp"><span style="width:${pct}%;background:${corHp(pct)}"></span></span>
                    ${hpAtual(p)}/${p.b.hpMax}
                </span>
            </button>`;
    }).join('') + `<button type="button" onclick="renderMochilaLista()" style="margin-top:10px;">⬅ Voltar</button>`;
}

// Devolve o motivo pelo qual o item NÃO pode ser usado nesse Pokémon (ou null se pode)
function motivoInvalido(efeito, p) {
    switch (efeito.tipo) {
        case 'cura':
            if (!vivo(p)) return 'Desmaiado';
            if (efeito.status === 'todos') {
                if (hpAtual(p) >= p.b.hpMax && !p.b.status && !p.b.confuso) return 'Nada a curar';
                return null;
            }
            if (hpAtual(p) >= p.b.hpMax) return 'HP cheio';
            return null;
        case 'revive':
            return vivo(p) ? 'Não está desmaiado' : null;
        case 'status':
            if (!vivo(p)) return 'Desmaiado';
            if (efeito.status === 'todos') return (p.b.status || p.b.confuso) ? null : 'Sem status negativo';
            return efeito.status.includes(p.b.status) ? null : 'Sem esse status';
        case 'candy':
            if (!vivo(p)) return 'Desmaiado';
            return p.nivel >= 100 ? 'Nível máximo' : null;
        case 'sorte':
            if (!vivo(p)) return 'Desmaiado';
            return p.b.sorte ? 'Já está com sorte' : null;
        default:
            return null;
    }
}

function motivoInvalidoSemAlvo(efeito) {
    if (efeito.tipo === 'mel') {
        const op = ativo('oponente');
        if (op.b.confuso > 0) return `${op.apelido} já está confuso.`;
    }
    if (efeito.tipo === 'protecao') {
        const p = ativo('jogador');
        if (p.b.protecao > 0) return `${p.apelido} já está protegido.`;
    }
    return null;
}

async function usarItemDaMochila(itemId, idxAlvo = null) {
    const item = inventario.find(i => i.id === itemId);
    if (!item) return;
    const efeito = efeitoDoItem(item);
    const alvo = idxAlvo !== null ? timeJogador[idxAlvo] : null;

    const motivo = alvo ? motivoInvalido(efeito, alvo) : motivoInvalidoSemAlvo(efeito);
    if (motivo) { mostrarAvisoMochila(motivo); return; }

    // O servidor desconta o item: assim não dá para usar o que não se tem
    let resposta;
    try {
        const r = await fetch("../item/?acao=usar", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ item_id: item.id, pokemon_id: efeito.tipo === 'candy' ? alvo.id : null })
        });
        resposta = await r.json();
    } catch (erro) {
        mostrarAvisoMochila("Não foi possível usar o item. Tente novamente.");
        return;
    }

    if (!resposta.sucesso) {
        mostrarAvisoMochila(resposta.mensagem || "Não foi possível usar o item.");
        await carregarInventario();
        return;
    }

    item.quantidade = resposta.restante;
    if (item.quantidade <= 0) inventario = inventario.filter(i => i.id !== item.id);

    fecharModal('modal-mochila');
    await executarTurno({ tipo: 'item', item, efeito, idxAlvo, novoNivel: resposta.nivel });
}

async function aplicarItem(acao) {
    const { item, efeito, idxAlvo } = acao;
    const alvo = idxAlvo !== null ? timeJogador[idxAlvo] : null;

    await msg(alvo ? `Você usou ${item.nome} em ${alvo.apelido}!` : `Você usou ${item.nome}!`, 'log-item');

    switch (efeito.tipo) {
        case 'cura': {
            const antes = hpAtual(alvo);
            setHp(alvo, efeito.total ? alvo.b.hpMax : antes + efeito.valor);
            if (efeito.status === 'todos') { alvo.b.status = null; alvo.b.sono = 0; alvo.b.confuso = 0; }
            atualizarTela();
            await msg(`${alvo.apelido} recuperou ${hpAtual(alvo) - antes} HP!`, 'log-cura');
            break;
        }
        case 'revive': {
            alvo.b.desmaiou = false;
            alvo.b.status = null;
            setHp(alvo, Math.ceil(alvo.b.hpMax / 2));
            atualizarTela();
            await msg(`${alvo.apelido} voltou à vida com ${hpAtual(alvo)} HP!`, 'log-cura');
            break;
        }
        case 'status': {
            const curado = alvo.b.status ? STATUS_NOME[alvo.b.status] : 'confuso';
            alvo.b.status = null;
            alvo.b.sono = 0;
            if (efeito.status === 'todos') alvo.b.confuso = 0;
            atualizarTela();
            await msg(efeito.status === 'todos'
                ? `${alvo.apelido} ficou livre dos problemas de status!`
                : `${alvo.apelido} não está mais ${curado}!`, 'log-cura');
            break;
        }
        case 'candy': {
            alvo.nivel = acao.novoNivel ?? alvo.nivel + 1;
            atualizarTela();
            await msg(`${alvo.apelido} subiu para o nível ${alvo.nivel}!`, 'log-cura');
            break;
        }
        case 'mel': {
            const op = ativo('oponente');
            op.b.confuso = gerarInteiro(3, 5);
            atualizarTela();
            await msg(`${op.apelido} ficou confuso com o aroma doce do mel!`, 'log-status');
            break;
        }
        case 'protecao': {
            const p = ativo('jogador');
            p.b.protecao = 3;
            atualizarTela();
            await msg(`${p.apelido} está protegido! Receberá metade do dano por 3 turnos.`, 'log-cura');
            break;
        }
        case 'sorte': {
            alvo.b.sorte = true;
            await msg(`${alvo.apelido} ficou com sorte! Chance de acerto crítico dobrada.`, 'log-cura');
            break;
        }
    }
}

// ---------------------------------------------------------------------
//  Cálculos de combate
// ---------------------------------------------------------------------

function calcularMultiplicadorTipo(tipoAtaque, tiposDefensor) {
    const linha = tabelaTipos[String(tipoAtaque).toLowerCase()];
    if (!linha) return 1.0;                 // 'typeless' (Luta): sem vantagem nem imunidade
    let total = 1.0;
    for (const t of tiposDefensor) {
        const nome = (t.type ? t.type.name : t).toLowerCase();
        if (linha[nome] !== undefined) total *= linha[nome];
    }
    return total;
}

function multEstagio(s) {
    return s >= 0 ? (2 + s) / 2 : 2 / (2 - s);
}

function statEfetivo(p, chave) {
    let valor = p.stats[STAT_POSICAO[chave]].base_stat * multEstagio(p.b.stages[chave]);
    if (chave === 'atk' && p.b.status === 'burn') valor *= 0.5;
    if (chave === 'spe' && p.b.status === 'paralysis') valor *= 0.5;
    return Math.max(1, valor);
}

function temStab(p, move) {
    return tiposDe(p).includes(move.type.name);
}

function calcularDano(atacante, alvo, move) {
    const especial = move.damage_class.name === 'special';
    const A = statEfetivo(atacante, especial ? 'spa' : 'atk');
    const D = statEfetivo(alvo, especial ? 'spd' : 'def');
    const L = atacante.nivel;

    // fórmula dos jogos, sem arredondar a razão ataque/defesa
    let dano = Math.floor(Math.floor((Math.floor((2 * L) / 5) + 2) * move.power * A / D) / 50) + 2;

    const chanceBase = 1 / 24;
    let chanceCritico = chanceBase + Math.floor(roundN / 3) * (chanceBase / 2);
    if (atacante.b.sorte) chanceCritico *= 2;
    chanceCritico = Math.min(chanceCritico, 0.5);
    const critico = Math.random() < chanceCritico;
    if (critico) dano *= 1.5;

    dano = (dano * gerarInteiro(85, 100)) / 100;
    if (temStab(atacante, move)) dano *= 1.5;

    const mult = calcularMultiplicadorTipo(move.type.name, alvo.types);
    dano *= mult;
    if (alvo.b.protecao > 0) dano *= 0.5;

    dano = mult === 0 ? 0 : Math.max(1, Math.floor(dano));
    return { dano, mult, critico };
}

// Quanto vale um golpe (usado pela IA do oponente)
function pontuacaoGolpe(atacante, move, defensor) {
    if (!move.power) return 0;
    const mult = calcularMultiplicadorTipo(move.type.name, defensor.types);
    const stab = temStab(atacante, move) ? 1.5 : 1;
    const precisao = (move.accuracy ?? 100) / 100;
    return move.power * mult * stab * precisao;
}

// ---------------------------------------------------------------------
//  Efeitos de golpe: dano, status, stats
// ---------------------------------------------------------------------

async function causarDano(lado, p, dano, anim = true) {
    if (dano <= 0) return;
    setHp(p, hpAtual(p) - dano);
    atualizarTela();
    if (anim) await animarSprite(lado, 'sprite-dano', 400);
    if (!vivo(p) && !p.b.desmaiou) {
        p.b.desmaiou = true;
        p.b.status = null;
        atualizarTela();
        await msg(`${rotulo(lado, p)} desmaiou!`, 'log-desmaio', 900);
    }
}

async function curar(lado, p, quantidade) {
    const antes = hpAtual(p);
    setHp(p, antes + quantidade);
    atualizarTela();
    return hpAtual(p) - antes;
}

async function tentarAplicarStatus(ladoAlvo, alvo, ailment) {
    if (!vivo(alvo)) return;

    if (ailment === 'confusion') {
        if (alvo.b.confuso > 0) return;
        alvo.b.confuso = gerarInteiro(3, 5);
        atualizarTela();
        await msg(`${rotulo(ladoAlvo, alvo)} ficou confuso!`, 'log-status');
        return;
    }

    if (!STATUS_NOME[ailment]) return;              // status que o jogo não implementa
    if (alvo.b.status) return;                      // só um status por vez
    const imunes = IMUNE_STATUS[ailment] || [];
    if (tiposDe(alvo).some(t => imunes.includes(t))) return;

    alvo.b.status = ailment;
    if (ailment === 'sleep') alvo.b.sono = gerarInteiro(2, 4);
    atualizarTela();
    await msg(`${rotulo(ladoAlvo, alvo)} ficou ${STATUS_NOME[ailment]}!`, 'log-status');
}

async function aplicarMudancaStat(ladoAlvo, alvo, chave, mudanca) {
    const atual = alvo.b.stages[chave];
    const novo = Math.max(-6, Math.min(6, atual + mudanca));
    if (novo === atual) {
        await msg(`${STAT_NOME[chave]} de ${rotulo(ladoAlvo, alvo)} não pode ${mudanca > 0 ? 'subir' : 'baixar'} mais!`, 'log-status');
        return;
    }
    alvo.b.stages[chave] = novo;
    const verbo = mudanca > 0 ? 'subiu' : 'baixou';
    const intensidade = Math.abs(mudanca) >= 2 ? ' bastante' : '';
    await msg(`${STAT_NOME[chave]} de ${rotulo(ladoAlvo, alvo)} ${verbo}${intensidade}!`, 'log-status');
}

async function aplicarEfeitosSecundarios(ladoAtacante, atacante, ladoAlvo, alvo, move, causouDano) {
    const meta = move.meta || {};
    const status = move.damage_class.name === 'status';
    let algumEfeito = false;

    // Status (queimar, paralisar, dormir, confundir...)
    const ailment = meta.ailment?.name;
    if (ailment && ailment !== 'none' && ailment !== 'unknown') {
        const chance = meta.ailment_chance > 0 ? meta.ailment_chance : (status ? 100 : 0);
        if (chance > 0) {
            algumEfeito = true;
            if (Math.random() * 100 < chance) {
                const antes = alvo.b.status;
                const antesConf = alvo.b.confuso;
                await tentarAplicarStatus(ladoAlvo, alvo, ailment);
                if (status && alvo.b.status === antes && alvo.b.confuso === antesConf) {
                    await msg('Mas não surtiu efeito!', '', 500);
                }
            }
        }
    }

    // Mudança de stats
    const mudancas = move.stat_changes || [];
    if (mudancas.length > 0) {
        const chance = meta.stat_chance > 0 ? meta.stat_chance : 100;
        const alvoSelf = ['user', 'user-or-ally', 'users-field'].includes(move.target?.name);
        algumEfeito = true;
        if (Math.random() * 100 < chance) {
            for (const mud of mudancas) {
                const chave = STAT_INDICE[mud.stat.name];
                if (!chave) continue;               // precisão/evasão não são usadas
                let paraUsuario = alvoSelf;
                if (!status) {
                    // golpes de dano: queda garantida é "custo" do usuário, bônus é do usuário
                    paraUsuario = mud.change > 0 || (mud.change < 0 && meta.stat_chance >= 100);
                }
                if (paraUsuario) await aplicarMudancaStat(ladoAtacante, atacante, chave, mud.change);
                else if (vivo(alvo)) await aplicarMudancaStat(ladoAlvo, alvo, chave, mud.change);
            }
        }
    }

    // Golpes de cura (Recover etc.)
    if (meta.healing > 0 && status) {
        algumEfeito = true;
        const curou = await curar(ladoAtacante, atacante, Math.ceil(atacante.b.hpMax * meta.healing / 100));
        await msg(curou > 0 ? `${rotulo(ladoAtacante, atacante)} recuperou ${curou} HP!` : `${rotulo(ladoAtacante, atacante)} já está com o HP cheio!`, 'log-cura');
    }

    if (status && !algumEfeito) {
        await msg('Mas não surtiu efeito!', '', 500);
    }
}

// ---------------------------------------------------------------------
//  Ações
// ---------------------------------------------------------------------

// Sono, congelamento, paralisia e confusão podem impedir a ação
async function podeAgir(lado, p) {
    const nome = rotulo(lado, p);

    if (p.b.status === 'sleep') {
        p.b.sono--;
        if (p.b.sono > 0) { await msg(`${nome} está dormindo profundamente...`, 'log-status'); return false; }
        p.b.status = null;
        atualizarTela();
        await msg(`${nome} acordou!`, 'log-status');
    }

    if (p.b.status === 'freeze') {
        if (Math.random() < 0.2) {
            p.b.status = null;
            atualizarTela();
            await msg(`${nome} descongelou!`, 'log-status');
        } else {
            await msg(`${nome} está congelado e não consegue se mover!`, 'log-status');
            return false;
        }
    }

    if (p.b.status === 'paralysis' && Math.random() < 0.25) {
        await msg(`${nome} está paralisado e não consegue se mover!`, 'log-status');
        return false;
    }

    if (p.b.confuso > 0) {
        p.b.confuso--;
        atualizarTela();
        if (p.b.confuso === 0) {
            await msg(`${nome} não está mais confuso!`, 'log-status');
        } else {
            await msg(`${nome} está confuso!`, 'log-status', 400);
            if (Math.random() < 1 / 3) {
                const golpeConfusao = { power: 40, damage_class: { name: 'physical' }, type: { name: 'typeless' } };
                const { dano } = calcularDano(p, p, golpeConfusao);
                await msg(`${nome} se machucou na confusão!`, 'log-status', 400);
                await causarDano(lado, p, dano);
                return false;
            }
        }
    }

    return true;
}

async function atacar(lado, move) {
    const atacante = ativo(lado);
    const ladoAlvo = outro(lado);
    const alvo = ativo(ladoAlvo);

    if (!vivo(atacante) || !vivo(alvo)) return;
    if (!(await podeAgir(lado, atacante))) return;

    await msg(`${rotulo(lado, atacante)} usou ${move.name === 'struggle' ? 'Luta' : nomeGolpe(move)}!`, 'log-golpe', 500);

    if (move.accuracy !== null && move.accuracy !== undefined && Math.random() * 100 >= move.accuracy) {
        await msg(`${rotulo(lado, atacante)} errou o golpe!`, 'log-erro');
        return;
    }

    let causouDano = false;

    if (move.power) {
        const { dano, mult, critico } = calcularDano(atacante, alvo, move);

        if (mult === 0) {
            await msg(`Não afeta ${rotulo(ladoAlvo, alvo)}...`, 'log-erro');
            return;
        }

        await causarDano(ladoAlvo, alvo, dano);
        causouDano = true;
        if (critico) await msg('Acerto crítico!', 'log-critico', 450);
        if (mult > 1) await msg('É super efetivo!', 'log-super', 450);
        else if (mult < 1) await msg('Não é muito efetivo...', 'log-fraco', 450);
        if (alvo.b.protecao > 0 && ladoAlvo === 'jogador') registrar(`A proteção reduziu o dano em ${rotulo(ladoAlvo, alvo)}.`);

        // dreno / recuo
        const drain = move.meta?.drain || 0;
        if (drain > 0 && vivo(atacante)) {
            const curou = await curar(lado, atacante, Math.max(1, Math.floor(dano * drain / 100)));
            if (curou > 0) await msg(`${rotulo(lado, atacante)} drenou ${curou} HP!`, 'log-cura', 450);
        } else if (drain < 0 && vivo(atacante)) {
            await msg(`${rotulo(lado, atacante)} sofreu com o recuo!`, 'log-erro', 400);
            await causarDano(lado, atacante, Math.max(1, Math.floor(dano * -drain / 100)));
        }
    }

    await aplicarEfeitosSecundarios(lado, atacante, ladoAlvo, alvo, move, causouDano);
}

async function trocar(lado, idx) {
    const antigo = ativo(lado);
    const novo = estado[lado].time[idx];

    if (vivo(antigo)) {
        if (lado === 'jogador') await msg(`Volte, ${antigo.apelido}!`, 'log-troca', 450);
        else await msg(`O oponente recolheu ${antigo.apelido}!`, 'log-troca', 450);
    }
    resetarEstadoTemporario(antigo);

    estado[lado].pos = idx;
    atualizarTela();
    await animarSprite(lado, 'sprite-entrada', 400);
    await msg(lado === 'jogador' ? `Vai, ${novo.apelido}!` : `O oponente enviou ${novo.apelido}!`, 'log-troca');
}

async function executarAcao(lado, acao) {
    switch (acao.tipo) {
        case 'ataque': return atacar(lado, acao.move);
        case 'equipe': return trocar(lado, acao.id);
        case 'item':   return aplicarItem(acao);
    }
}

// ---------------------------------------------------------------------
//  IA do oponente
// ---------------------------------------------------------------------

function escolherAcaoOponente() {
    const pOp = ativo('oponente');
    const pJog = ativo('jogador');

    // Pokémon quase caindo: pode trocar
    if (hpAtual(pOp) < pOp.b.hpMax * 0.25) {
        const reservas = timeOponente
            .map((p, i) => ({ p, i }))
            .filter(({ p, i }) => i !== estado.oponente.pos && vivo(p));
        if (reservas.length > 0 && Math.random() < 0.35) {
            return { tipo: 'equipe', id: escolherMelhorReserva(reservas, pJog) };
        }
    }

    const moves = (arrayMoves[estado.oponente.pos] || []);
    if (moves.length === 0) return { tipo: 'ataque', move: LUTA };

    // golpes de status úteis de vez em quando
    if (Math.random() < 0.2) {
        const uteis = moves.filter(m => !m.power && (
            (m.meta?.ailment?.name && m.meta.ailment.name !== 'none' && !pJog.b.status) ||
            (m.stat_changes && m.stat_changes.length > 0) ||
            (m.meta?.healing > 0 && hpAtual(pOp) < pOp.b.hpMax * 0.5)
        ));
        if (uteis.length > 0) return { tipo: 'ataque', move: uteis[gerarInteiro(0, uteis.length - 1)] };
    }

    let melhor = null;
    let maior = 0;
    for (const m of moves) {
        const pontos = pontuacaoGolpe(pOp, m, pJog);
        if (pontos > maior) { maior = pontos; melhor = m; }
    }
    return { tipo: 'ataque', move: melhor || moves[gerarInteiro(0, moves.length - 1)] };
}

function escolherMelhorReserva(reservas, contra) {
    let melhor = reservas[0].i;
    let maior = -1;
    for (const { p, i } of reservas) {
        const golpes = arrayMoves[i] || [];
        const pontos = Math.max(0, ...golpes.map(m => pontuacaoGolpe(p, m, contra)));
        if (pontos > maior) { maior = pontos; melhor = i; }
    }
    return melhor;
}

// ---------------------------------------------------------------------
//  Turno
// ---------------------------------------------------------------------

function prioridadeDe(lado, acao) {
    if (acao.tipo === 'equipe' || acao.tipo === 'item') return 100;
    return acao.move.priority || 0;
}

function definirOrdem(acaoJ, acaoO) {
    const pj = prioridadeDe('jogador', acaoJ);
    const po = prioridadeDe('oponente', acaoO);
    let jogadorPrimeiro;

    if (pj !== po) {
        jogadorPrimeiro = pj > po;
    } else if (pj === 100) {
        jogadorPrimeiro = true;               // trocas e itens do jogador acontecem antes
    } else {
        const sj = statEfetivo(ativo('jogador'), 'spe');
        const so = statEfetivo(ativo('oponente'), 'spe');
        jogadorPrimeiro = sj === so ? Math.random() < 0.5 : sj > so;
    }

    const j = { lado: 'jogador', acao: acaoJ };
    const o = { lado: 'oponente', acao: acaoO };
    return jogadorPrimeiro ? [j, o] : [o, j];
}

function todosDesmaiados(lado) {
    return estado[lado].time.every(p => !vivo(p));
}

// Dano de queimadura/veneno e contagem da proteção
async function fimDeTurno() {
    for (const lado of ['jogador', 'oponente']) {
        const p = ativo(lado);
        if (!vivo(p)) continue;

        if (p.b.status === 'burn') {
            await msg(`${rotulo(lado, p)} sofre com a queimadura!`, 'log-status', 400);
            await causarDano(lado, p, Math.max(1, Math.floor(p.b.hpMax / 16)));
        } else if (p.b.status === 'poison') {
            await msg(`${rotulo(lado, p)} sofre com o veneno!`, 'log-status', 400);
            await causarDano(lado, p, Math.max(1, Math.floor(p.b.hpMax / 8)));
        }

        if (vivo(p) && p.b.protecao > 0) {
            p.b.protecao--;
            if (p.b.protecao === 0) {
                atualizarTela();
                await msg(`A proteção de ${rotulo(lado, p)} acabou.`, 'log-status', 400);
            }
        }
    }
}

// Reposição de Pokémon desmaiados. Devolve 'jogador' / 'oponente' se a batalha acabou.
async function resolverDesmaios() {
    const op = ativo('oponente');
    if (!vivo(op)) {
        if (todosDesmaiados('oponente')) return 'jogador';
        const reservas = timeOponente.map((p, i) => ({ p, i })).filter(({ p }) => vivo(p));
        const escolhido = escolherMelhorReserva(reservas, ativo('jogador'));
        await trocar('oponente', escolhido);
    }

    const jog = ativo('jogador');
    if (!vivo(jog)) {
        if (todosDesmaiados('jogador')) return 'oponente';
        definirMensagem('Escolha o próximo Pokémon!');
        const idx = await escolherSubstituto();
        await trocar('jogador', idx);
    }
    return null;
}

async function executarTurno(acaoJogador) {
    if (bloqueado || fimDeJogo) return;
    bloquear(true);

    try {
        roundN++;
        abrirRound();

        const acaoOponente = escolherAcaoOponente();
        const ordem = definirOrdem(acaoJogador, acaoOponente);

        for (const { lado, acao } of ordem) {
            await executarAcao(lado, acao);
            if (todosDesmaiados('jogador') || todosDesmaiados('oponente')) break;
        }

        if (!todosDesmaiados('jogador') && !todosDesmaiados('oponente')) {
            await fimDeTurno();
        }

        const vencedor = await resolverDesmaios();
        if (vencedor) {
            finalizarBatalha(vencedor);
            return;
        }
    } catch (erro) {
        console.error("Erro durante o turno:", erro);
        registrar("Ocorreu um erro inesperado neste turno.");
    }

    atualizarTela();
    bloquear(false);
}

// ---------------------------------------------------------------------
//  Fim de batalha
// ---------------------------------------------------------------------

function finalizarBatalha(vencedor) {
    fimDeJogo = true;
    bloqueado = true;
    document.getElementById('menu-principal').style.display = 'none';
    document.getElementById('menu-ataques').style.display = 'none';

    const venceu = vencedor === 'jogador';
    const vivos = timeJogador.filter(vivo).length;
    registrar(venceu ? 'Você venceu a batalha!' : 'Você foi derrotado...', venceu ? 'log-super' : 'log-erro');
    definirMensagem(venceu ? 'Você venceu a batalha!' : 'Você foi derrotado...');

    document.getElementById('fim-titulo').textContent = venceu ? '🏆 Vitória!' : '💀 Derrota';
    document.getElementById('fim-texto').textContent = venceu
        ? `Você venceu em ${roundN} rounds, com ${vivos} Pokémon em pé.`
        : `Todos os seus Pokémon desmaiaram em ${roundN} rounds.`;
    abrirModal('modal-fim');
    enviarFimBatalha(venceu ? 'vitoria' : 'derrota');
}

// Grava o resultado e o histórico da batalha no log (só envia uma vez por batalha)
async function enviarFimBatalha(resultado) {
    if (batalhaEnviada || typeof BATALHA_ID === 'undefined' || !BATALHA_ID) return;
    batalhaEnviada = true;
    try {
        const resposta = await fetch("../pokemon/?acao=finalizarBatalha", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                batalha_id: BATALHA_ID,
                resultado: resultado,
                rounds: roundN,
                eventos: eventosBatalha
            })
        });
        if (!resposta.ok) console.error("Não foi possível registrar a batalha no log.");
    } catch (erro) {
        console.error("Erro ao registrar a batalha:", erro);
    }
}

async function fugirDaBatalha() {
    await enviarFimBatalha('fuga');
    location.href = "../main/dashboard.php";
}

// ---------------------------------------------------------------------
//  Eventos
// ---------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('menu-principal').addEventListener('click', (evento) => {
        const botao = evento.target.closest('button');
        if (!botao || bloqueado) return;

        switch (botao.getAttribute('data-acao-principal')) {
            case 'atacar':  mostrarAtaques(); break;
            case 'mochila': abrirMochila(); break;
            case 'equipe':  abrirEquipe(); break;
            case 'fugir':   abrirModal('modal-fugir'); break;
        }
    });

    document.getElementById('menu-ataques').addEventListener('click', (evento) => {
        const botao = evento.target.closest('.btn-golpe');
        if (!botao || bloqueado) return;

        const move = botao.dataset.luta ? LUTA : arrayMoves[estado.jogador.pos][parseInt(botao.dataset.idx)];
        if (!move) return;
        executarTurno({ tipo: 'ataque', move });
    });

    document.getElementById('equipe-lista').addEventListener('click', (evento) => {
        const botao = evento.target.closest('.btn-equipe');
        if (!botao || botao.disabled) return;
        const idx = parseInt(botao.dataset.idx);

        fecharModal('modal-equipe');
        if (modoEquipe === 'forcado') {
            const resolver = resolverSubstituto;
            resolverSubstituto = null;
            if (resolver) resolver(idx);
        } else {
            executarTurno({ tipo: 'equipe', id: idx });
        }
    });

    document.getElementById('mochila-conteudo').addEventListener('click', (evento) => {
        const botaoItem = evento.target.closest('.btn-item');
        if (botaoItem && !botaoItem.disabled) {
            const item = inventario.find(i => i.id === parseInt(botaoItem.dataset.item));
            if (!item) return;
            if (efeitoDoItem(item).alvo) renderAlvosItem(item);
            else usarItemDaMochila(item.id);
            return;
        }

        const botaoAlvo = evento.target.closest('.btn-alvo-item');
        if (botaoAlvo && !botaoAlvo.disabled) {
            usarItemDaMochila(parseInt(botaoAlvo.dataset.item), parseInt(botaoAlvo.dataset.idx));
        }
    });
});
