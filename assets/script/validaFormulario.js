const formulario = document.getElementById('form');

function validaFormulario(evento){

    const nome = document.getElementById('nome').value.trim();
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value.trim();

    let erro = false;

    const errorMessage = document.getElementById('errorMessage');
    errorMessage.innerHTML = "";

    if (!nome || !username || !email || !senha) {
        erro = true;
    }
    if(erro){
        errorMessage.innerHTML = "Você deve preencher todos os campos.";
        evento.preventDefault();
    }
    
}

formulario.addEventListener('submit', validaFormulario);

function mostrarSenha(){

    const input = document.getElementById('senha');
    const botao = document.getElementById('botaoSenha');

    if(input.type == "password"){
        input.type = "text";
        botao.innerText="X";
    }
    else if(input.type == "text"){
        input.type = "password";
        botao.innerText="O";
    }

}