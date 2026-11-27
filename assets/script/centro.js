let timeCentro = [];

function voltarParaJogar() {
    window.location.href = "../main/dashboard.php";
}

async function carregarTimeCentro() {
    try {
        const resposta = await fetch("../pokemon/?acao=getPokemonAndMoves");
        const dados = await resposta.json();

        // dados[1] traz apenas os Pokémons ativos no time
        const pokemonAtivoBruto = dados[1] || [];
        const promissesAtivo = pokemonAtivoBruto.map(pokemon => formatarPokemon(pokemon, true));
        timeCentro = await Promise.all(promissesAtivo);

        exibirTimeCentro();
    } catch (erro) {
        console.error("Erro ao carregar o time no Centro Pokémon:", erro);
    }
}

function exibirTimeCentro() {
    const grid = document.getElementById('grid-time');
    if (!grid) return;

    grid.innerHTML = "";

    for (let i = 0; i < 6; i++) {
        if (timeCentro[i] != null) {
            const p = timeCentro[i];

      
            const hpMax = p.hp_max ?? p.hp_total ?? p.hp ?? 100;
            const hpAtual = p.hp_atual ?? p.hp ?? hpMax;
            const porcentagem = Math.max(0, Math.min(100, (hpAtual / hpMax) * 100));

      
            let corHp = "#4CAF50"; 
            if (porcentagem <= 20) {
                corHp = "#f44336"; 
            } else if (porcentagem <= 50) {
                corHp = "#ffcb05";
            }

            grid.innerHTML += `
                <div class="slot-pokemon preenchido" id="pokemon-centro-${i}">
                    <img src="${p.sprites.front_default}" alt="${p.apelido}">
                    <div class="slot-info">
                        <span class="slot-id">Nº ${p.api_id} • Nível ${p.nivel ?? 1}</span>
                        <span class="slot-nome">${p.apelido}</span>
                    </div>
                    <div class="hp-container">
                        <div class="hp-barra-fundo">
                            <div class="hp-barra-preenchimento" style="width: ${porcentagem}%; background-color: ${corHp};"></div>
                        </div>
                        <span class="hp-texto">HP ${hpAtual}/${hpMax}</span>
                    </div>
                </div>
            `;
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }
}
async function curarTime() {
    if (timeCentro.length === 0) {
        alert("Você não tem Pokémons no time para curar!");
        return;
    }

    timeCentro.forEach(p => {
        const hpMax = p.hp_max ?? p.hp_total ?? p.hp ?? 100;
        p.hp_atual = hpMax;
        p.hp = hpMax;
        if (p.status !== undefined) p.status = null;
    });


    exibirTimeCentro();

    const audioCura = new Audio('/MonsterPE/assets/songs/Salvar time Song.mp3#t=0,5');
    audioCura.volume = 0.2;
    audioCura.play().catch(() => {});


    try {
        await fetch("../pokemon/?acao=curarTime", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(timeCentro)
        });
    } catch (erro) {
        console.error("Erro ao salvar a cura no servidor:", erro);
    }
}
document.addEventListener("DOMContentLoaded", carregarTimeCentro);