function voltarParaJogar() {
    window.location.href = "../main/dashboard.php";
}

let timeEscolhido = [];
function adicionarAoTime(id, salvo = false) {
    if (timeEscolhido.length < 6 && cachePokemon[id] !== null) {
        timeEscolhido.push(cachePokemon[id]);
        atualizarTelaTime(); 
        if(salvo){
            const pokemonSalvo = document.getElementById(`${id}`);
            pokemonSalvo.remove();
        }
    } else if (timeEscolhido.length >= 6) {
        alert("Seu time já tem 6 Pokémons!");
    }

}

function removerDoTime(posicao, salvo = null) {
    if(salvo !== null){
        const pokemon = timeEscolhido[posicao];
        const listaPokemonSalvo = document.getElementById('pokemonSalvo');
        listaPokemonSalvo.innerHTML += `
            <div class="cartao-pokemon" style="height: auto; width: 270px; padding-bottom: 15px;" id="${pokemon.id}">
                <div class="cartao-fundo"></div>
                <img style="height: 200px; width: 200px;"  src="${pokemon.sprites.front_default}" >
                <h4 style="margin: 5px 0;">Nº ${pokemon.api_id} - ${pokemon.apelido}</h4>
                <h3 style="margin: 5px 0;">${pokemon.apelido}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                <button onclick="adicionarAoTime('${pokemon.id}', true)" class="btn-adicionar">Adicionar ao Time</button>
                <button onclick="excluirPokemonSalvo('${pokemon.id}')" class="btn-adicionar" style="background-color: red;">Excluir</button>
            </div>
        `;
    }
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
                    <button class="btn-remover" onclick="removerDoTime(${i}, ${p.ativo})">X</button>
                    <img src="${p.sprites.front_default}">
                    <div class="slot-info">
                        <span class="slot-id">Nº${p.api_id}</span>
                        <span class="slot-nome">${p.apelido}</span>
                    </div>
                </div>
            `;
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }
    let btnSalvar = document.getElementById('btn-salvar-time');
    let btnLimpar = document.getElementById('btn-limpar-time');
    if (timeEscolhido.length > 0) {
        btnSalvar.style.display = 'block';
        btnLimpar.style.display = 'none';
    } else {
        btnSalvar.style.display = 'none';
        btnLimpar.style.display = 'Block';
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

async function excluirPokemonSalvo(id){
    try{

        const dadosEnviados = await fetch('../pokemon/?acao=excluir', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: id
        });
        const resultado = await dadosEnviados.json();

    }
    catch(erro){
        console.log("Os dados não foram passados corretamente;\nErro: ", erro);
    }
    
    salvarTime();
}

function limparTime(){
    window.location.href = "?acao=limparTime";
}
function showPokemonSalvos(pokemonSalvo){

    const listaPokemonSalvo = document.getElementById('pokemonSalvo');
    listaPokemonSalvo.innerHTML = "";

    pokemonSalvo.forEach(pokemon => {
        cachePokemon[pokemon.id] = pokemon;
        listaPokemonSalvo.innerHTML += `
            <div class="cartao-pokemon" style="height: auto; width: 270px; padding-bottom: 15px;" id="${pokemon.id}">
                <div class="cartao-fundo"></div>
                <img style="height: 200px; width: 200px;"  src="${pokemon.sprites.front_default}" >
                <h4 style="margin: 5px 0;">Nº ${pokemon.api_id} - ${pokemon.apelido}</h4>
                <h3 style="margin: 5px 0;">${pokemon.apelido}</h3>
                <p style="background: rgba(0,0,0,0.1); padding: 5px 10px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; color: black; font-family: Lexend, sans-serif;">${pokemon.tiposFormatados}</p>
                <button onclick="adicionarAoTime('${pokemon.id}', true)" class="btn-adicionar">Adicionar ao Time</button>
                <button onclick="excluirPokemonSalvo('${pokemon.id}')" class="btn-adicionar" style="background-color: red;">Excluir</button>
            </div>
        `;
    });
}