function voltarParaJogar() {
    window.location.href = "../main/dashboard.php";
}

let timeEscolhido = [];

function adicionarAoTime(id) {
    if (timeEscolhido.length < 6 && cachePokemon[id] !== null) {
        timeEscolhido.push(cachePokemon[id]);
        atualizarTelaTime();
    } else if (timeEscolhido.length >= 6) {
        alert("Seu time já tem 6 Pokémons!");
    }
}

function removerDoTime(posicao) {1
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
                    <img src="${p.sprites.front_default}">
                    <div class="slot-info">
                        <span class="slot-id">Nº ${p.id}</span>
                        <span class="slot-nome">${p.name}</span>
                    </div>
                </div>
            `;
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }
    let btnSalvar = document.getElementById('btn-salvar-time');
    if (timeEscolhido.length > 0) {
        btnSalvar.style.display = 'block';
    } else {
        btnSalvar.style.display = 'none';
    }
}

async function salvarTime(){

    try{

        const dadosEnviados = await fetch('../pokemon/?acao=salvar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(timeEscolhido)
        });
        const resultado = await dadosEnviados.json();
    }
    catch(erro){
        console.log("Os dados não foram passados corretamente;\nErro: ", erro);
    }

    location.reload();
}


function showPokemonSalvo(pokemonSalvo){

    const listaPokemonSalvo = document.getElementById('pokemonSalvo');
    listaPokemonSalvo.innerHTML = "";

    pokemonSalvo.forEach(pokemon => {
        cachePokemon[pokemon.id] = pokemon;
        listaPokemonSalvo.innerHTML += `
            <div class="cartao-pokemon" style="height: auto; width: 100%; padding-bottom: 15px;">
                <div class="cartao-fundo"></div>
                <img src="${pokemon.sprites.front_default}">
                <h3 style="margin: 5px 0;">Nº ${pokemon.id} - ${pokemon.name}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                <button onclick="adicionarAoTime(${pokemon.id})" class="btn-adicionar">Adicionar ao Time</button>
            </div>
        `;
    });
}