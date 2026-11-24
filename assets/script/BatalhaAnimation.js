
function abrirModal(idModal) {
    document.getElementById(idModal).style.display = 'flex';
}

function fecharModal(idModal) {
    document.getElementById(idModal).style.display = 'none';
}

function mostrarAtaques() {
    document.getElementById('menu-principal').style.display = 'none';
    document.getElementById('menu-ataques').style.display = 'flex';
}

function voltarMenuPrincipal() {
    document.getElementById('menu-ataques').style.display = 'none';
    document.getElementById('menu-principal').style.display = 'flex';
}

function fugirDaBatalha() {
    alert("Você fugiu em segurança!");
    voltarParaJogar();
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

const ataquesJogador = [
    { nome: "Choque do Trovão", tipo: "electric" },
    { nome: "Investida", tipo: "normal" },
    { nome: "Cauda de Ferro", tipo: "steel" },
    { nome: "Ataque Rápido", tipo: "normal" }
];

function carregarAtaques() {
    const menuAtaques = document.getElementById('menu-ataques');
    menuAtaques.innerHTML = "";
    ataquesJogador.forEach(ataque => {
        const btnAtaque = document.createElement("button");
        btnAtaque.className = "btn-batalha ataque";
        btnAtaque.innerText = ataque.nome;
        btnAtaque.style.background = coresTipos[ataque.tipo] || "#444";
        btnAtaque.style.color = "white";
        btnAtaque.style.textShadow = "1px 1px 2px rgba(0,0,0,0.8)";
        btnAtaque.style.borderColor = "rgba(0,0,0,0.5)";
        btnAtaque.onclick = () => alert(`Você usou ${ataque.nome}!`);
        
        menuAtaques.appendChild(btnAtaque);
    });
    const separador = document.createElement("div");
    separador.className = "separador-menu";
    menuAtaques.appendChild(separador);
    const btnVoltar = document.createElement("button");
    btnVoltar.className = "btn-batalha btn-voltar";
    btnVoltar.innerText = "Voltar";
    btnVoltar.style.background = "rgb(118, 33, 118)"; 
    btnVoltar.onclick = voltarMenuPrincipal;
    
    menuAtaques.appendChild(btnVoltar);
}
document.addEventListener("DOMContentLoaded", () => {
    carregarPokemon("pikachu", "jogador");
    carregarPokemon("gengar", "oponente");
    carregarAtaques(); 
});

async function carregarPokemon(nomeOuId, alvo) {
    try {
        const resposta = await fetch(`https://pokeapi.co/api/v2/pokemon/${nomeOuId}`);
        const dados = await resposta.json();
        document.getElementById(`nome-${alvo}`).innerText = dados.name;
        document.getElementById(`level-${alvo}`).innerText = "Lv 50";
        const hpBase = dados.stats.find(stat => stat.stat.name === 'hp').base_stat;
        const hpTotal = Math.floor(hpBase + 50 + 10); 
        document.getElementById(`hp-texto-${alvo}`).innerText = `${hpTotal}/${hpTotal}`;
        const divTipos = document.getElementById(`tipos-${alvo}`);
        divTipos.innerHTML = ""; 
        dados.types.forEach(tipoInfo => {
            const nomeTipo = tipoInfo.type.name;
            const spanTipo = document.createElement("span");
            spanTipo.innerText = nomeTipo;
            spanTipo.style.padding = "2px 6px";
            spanTipo.style.background = coresTipos[nomeTipo] || "#ddd"; 
            spanTipo.style.color = "white"; 
            spanTipo.style.textShadow = "1px 1px 1px rgba(0,0,0,0.8)";
            spanTipo.style.borderRadius = "4px";
            spanTipo.style.fontWeight = "bold";
            divTipos.appendChild(spanTipo);
        });
        const spriteHtml = document.getElementById(`sprite-${alvo}`);
        const gifs = dados.sprites.versions['generation-v']['black-white'].animated;
        if (alvo === 'jogador') {
            spriteHtml.src = gifs.back_default || dados.sprites.back_default || dados.sprites.front_default;
        } else {
            spriteHtml.src = gifs.front_default || dados.sprites.front_default;
        }
    } catch (erro) {
        console.error(`Erro ao carregar o Pokémon ${nomeOuId}:`, erro);
    }
}
