document.addEventListener("DOMContentLoaded", function() {

    const linkVerPoke = document.getElementById('verpoke');
    const linkJogar = document.getElementById('jogarpoke');

    const menuGens = document.getElementById('opgens');
    const menuVoltar = document.getElementById('voltargen');
    const menuJogar = document.getElementById('opjogar');
    const telaEquipe = document.getElementById('tela-equipe');
    if (linkVerPoke) {
        linkVerPoke.addEventListener('click', function(event) {
            event.preventDefault();
            if(menuJogar) menuJogar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(menuGens) menuGens.classList.toggle('ativo');   
        });
    }
    if (linkJogar) {
        linkJogar.addEventListener('click', function(event) {
            event.preventDefault(); 
            if(menuGens) menuGens.classList.remove('ativo');   
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuJogar) menuJogar.classList.toggle('ativo');  
        });
    }
});

function telaMontarEquipe() {
    document.getElementById('opjogar').classList.remove('ativo');
    document.getElementById('tela-equipe').classList.add('ativo');
}

function voltarParaGeracoes() {
    document.getElementById('voltargen').classList.remove('ativo');
    document.getElementById('opgens').classList.add('ativo');
}

function voltarParaJogar() {
    document.getElementById('tela-equipe').classList.remove('ativo');
    document.getElementById('opjogar').classList.add('ativo');
    document.getElementById('resultado-pesquisa').innerHTML = "";
    document.getElementById('input-busca').value = "";
}

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

let timeEscolhido = [];

function adicionarAoTime(id) {
    if (timeEscolhido.length < 6 && pokemon !== null) {
        timeEscolhido.push(cachePokemon[id]);
        atualizarTelaTime();
    } else if (timeEscolhido.length >= 6) {
        alert("Seu time já tem 6 Pokémons!");
    }
}

function removerDoTime(posicao) {
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

function salvarTime(){

    dadosJSON = JSON.stringify(timeEscolhido, null, 2);
    console.log(dadosJSON);

}