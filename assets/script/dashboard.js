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
            if(menuGens) menuGens.classList.add('ativo');   
        });
    }
    if (linkJogar) {
        linkJogar.addEventListener('click', function(event) {
            event.preventDefault(); 
            if(menuGens) menuGens.classList.remove('ativo');   
            if(menuVoltar) menuVoltar.classList.remove('ativo'); 
            if(telaEquipe) telaEquipe.classList.remove('ativo');
            if(menuJogar) menuJogar.classList.add('ativo');  
        });
    }
});

function telaMontarEquipe() {
    window.location.href = "../pokemon/?acao=pokemonSalvo";
}

function voltarParaGeracoes() {
    document.getElementById('voltargen').classList.remove('ativo');
    document.getElementById('opgens').classList.add('ativo');
}

function iniciarJogo(){
    window.location.href = "../pokemon/?acao=batalha";
}
function IrALoja() {
    window.location.href = "../main/loja.php";
}
function Creditos() {
    window.location.href = "../main/creditos.php";
}

document.querySelectorAll('.dashmainclick').forEach(botao => {
    botao.addEventListener('click', () => {
        const aside = document.querySelector('.dashaside');
        if (aside) {
            aside.classList.remove('modo-inicial');
        }
    });
});