async function getPokemonAndMoves(){
    try{
        const resposta = await fetch("../pokemon/?acao=getPokemonAndMoves");
        const dados = await resposta.json();
        formatarPagina(dados[0],dados[1],dados[2]);

    }catch (erro) {
        console.error("Erro ao buscar:", erro);
    }

}

function voltarParaJogar() {
    window.location.href = "../main/dashboard.php";
}

let timeEscolhido = [];
let timeBanco = [];
let moves = [];
let cacheMove = {};
let pokemonSelecionado;

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

function alterarApelido(posicao, alterar = false){

    if(alterar){
        const inputTrocarApelido = document.getElementById('trocarApelido');
        timeEscolhido[posicao].apelido = inputTrocarApelido.value;
        salvarTime();
    }
    else{
        const divPokemon = document.querySelector(`#pokemon-escolhido-${posicao} > div`);
        const divPokemonButton = document.querySelector(`#pokemon-escolhido-${posicao} > div > button`);
        console.log(divPokemon);
        console.log(divPokemonButton);
        divPokemonButton.style.display = "none";
        divPokemon.innerHTML += `
            <input type="text" id="trocarApelido">
            <button onclick="alterarApelido(${posicao}, true)">Alterar</button>
        `;
    }


}

function atualizarTelaTime() {
    let grid = document.getElementById('grid-time');
    grid.innerHTML = "";
    for (let i = 0; i < 6; i++) {
        if (timeEscolhido[i] != null) {
            let p = timeEscolhido[i];
            grid.innerHTML += `
                <div class="slot-pokemon preenchido" id="pokemon-escolhido-${i}">
                    <button class="btn-remover" onclick="removerDoTime(${i}, ${p.ativo})">X</button>
                    <img src="${p.sprites.front_default}">
                    <div class="slot-info">
                        <span class="slot-id">Nº ${p.api_id}</span>
                        <span class="slot-nome">${p.apelido}</span>
                        <button type="button" onclick="alterarApelido(${i})">ALTERAR NOME</button>
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
        btnLimpar.style.display = 'block';
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

function atualizarTimeAtaques(pokemonMoves) {
    let grid = document.getElementById('grid-time-ataques');
    grid.innerHTML = "";
    for (let i = 0; i < 6; i++) {
        if (timeEscolhido[i] != null) {
            timeBanco[i] = timeEscolhido[i];
            let p = timeEscolhido[i];
            
            grid.innerHTML += `
                <div class="slot-pokemon preenchido">
                    <img src="${p.sprites.front_default}">
                    <div class="slot-info">
                        <span class="slot-id">Nível ${p.nivel}</span>
                        <span class="slot-nome">${p.apelido}</span>
                        <button onclick="editarMoves('${p.posicao}')" class="btn-adicionar">EDITAR</button>
                    </div>
                </div>
            `;
            moves[i] = pokemonMoves[i];
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }
}

function toggleMoves(){
    const divTime = document.getElementById('time');
    const divMoves = document.getElementById('time-moves');
    
    if(timeEscolhido.length == 0){
        alert("Seu time está vazio!");
        return;
    };

    if(divTime.style.display == 'flex'){
        divTime.style.display = "none";
        divMoves.style.display = "flex";
    }
    else if(divTime.style.display == "none"){
        divTime.style.display = "flex";
        divMoves.style.display = "none";
    }
}

function editarMoves(posicao = null){

    if(posicao == null){
        pokemonSelecionado = null;
    }
    else{
        pokemonSelecionado = posicao;
        atualizarTelaMove(); 
    }

    const divTime = document.getElementById('time-moves');
    const divMoves = document.getElementById('moves');

    if(divTime.style.display == 'flex'){
        divTime.style.display = "none";
        divMoves.style.display = "flex";
    }
    else if(divTime.style.display == "none"){
        divTime.style.display = "flex";
        divMoves.style.display = "none";
    }
}

function adicionarMove(id){
    if (moves[pokemonSelecionado].length < 4 && cacheMove[id] !== null) {
        moves[pokemonSelecionado].push(cacheMove[id]);
        atualizarTelaMove(); 
    } else if (timeEscolhido.length >= 4) {
        alert("Seu Pokemon já tem 4 Ataques!");
    }
}

function removerMove(posicao) {
    const move = moves[posicao];
    moves[pokemonSelecionado].splice(posicao, 1);
    atualizarTelaMove();
}

function atualizarTelaMove(){
    let grid = document.getElementById('grid-ataques');
    grid.innerHTML = "";
    for (let i = 0; i < 4; i++) {
        if (moves[pokemonSelecionado][i] != null) {
            let move = moves[pokemonSelecionado][i];
            grid.innerHTML += `
                <div class="slot-pokemon preenchido">
                    <button class="btn-remover" onclick="removerMove(${i})">X</button>
                    <img src="">
                    <div class="slot-info">
                        <span class="slot-nome">${move.name}</span>
                        <span class="slot-nome">${move.damage_class.name}</span>
                        <span class="slot-nome">${move.type.name}</span>
                    </div>
                </div>
            `;
        } else {
            grid.innerHTML += `<div class="slot-pokemon">${i + 1}</div>`;
        }
    }

}

async function salvarMoves(){
    try{
        const dadosEnviados = await fetch('../pokemon/?acao=salvarMoves', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({moves: moves[pokemonSelecionado], pokemon_id: timeBanco[pokemonSelecionado].id})
        });
        const resultado = await dadosEnviados.json();
    }
    catch(erro){
        console.log("Os dados não foram passados corretamente;\nErro: ", erro);
    }

}

function verificaMovePokemon(moves, moveRequired){
    let permitido = false;
    moves.forEach(move => {
        if(moveRequired == move.move.name){
            permitido = true;
        }
    });
    return permitido;
}

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

async function formatarPagina(PokemonSalvo,pokemonAtivo,PokemonMoves){

    const pokemonSalvoPoor = PokemonSalvo;
    const pokemonAtivoPoor = pokemonAtivo;
    const pokemonMovesBruto = PokemonMoves;

    const promissesPokemonMoves = pokemonMovesBruto.map(pokemon => formatarMoves(pokemon));
    let pokemonMoves = await Promise.all(promissesPokemonMoves);

    const promissesSalvo = pokemonSalvoPoor.map(pokemon => formatarPokemon(pokemon, true));
    const pokemonSalvoArray = await Promise.all(promissesSalvo);

    const promissesAtivo = pokemonAtivoPoor.map(pokemon => formatarPokemon(pokemon, true));
    const pokemonAtivoArray = await Promise.all(promissesAtivo);

    showPokemonSalvos(pokemonSalvoArray);
    pokemonAtivoArray.forEach(pokemon => {
        adicionarAoTime(pokemon.id);
    });
    atualizarTimeAtaques(pokemonMoves);

}