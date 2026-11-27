let itemAtual = null; 
let quantidadeAtual = 1;
let carrinho = []; 

function MostrarItem(elementoClicado) {
    let imgElemento = elementoClicado.querySelector('.item-imagem');
    let nomeElemento = elementoClicado.querySelector('.item-nome');
    let precoElemento = elementoClicado.querySelector('.item-preco');
    let descrElemento = elementoClicado.querySelector('.item-desc');
    let imgUrl = imgElemento.src;
    let nome = nomeElemento.innerText;
    let precoTexto = precoElemento.innerText; 
    let precoNumero = parseFloat(precoTexto.replace("R$ ", "").replace(",", "."));
    let descricao = descrElemento ? descrElemento.innerText : "Sem descrição.";
    itemAtual = { nome: nome, preco: precoNumero };
    quantidadeAtual = 1; 
    
    document.getElementById("modal-nome").innerText = nome;
    document.getElementById("modal-preco").innerText = "R$ " + precoNumero.toFixed(2).replace(".", ",");
    document.getElementById("modal-img").src = imgUrl;
    document.getElementById("modal-qtd").innerText = quantidadeAtual;
    document.getElementById("modal-descricao").innerText = descricao;
    document.getElementById("modal-compra").style.display = "flex";
}

function fecharModal() {
    document.getElementById("modal-compra").style.display = "none";
}

function alterarQuantidade(valor) {
    quantidadeAtual += valor;
    if (quantidadeAtual < 1) {
        quantidadeAtual = 1;
    }
    document.getElementById("modal-qtd").innerText = quantidadeAtual;
}

function adicionarAoCarrinho() {
    let indexExistente = carrinho.findIndex(item => item.nome === itemAtual.nome);

    if (indexExistente !== -1) {
        carrinho[indexExistente].quantidade += quantidadeAtual;
    } else {
        carrinho.push({
            nome: itemAtual.nome,
            preco: itemAtual.preco,
            quantidade: quantidadeAtual
        });
    }

    renderizarCarrinho();
    fecharModal();
}

function removerDoCarrinho(index) {
    carrinho.splice(index, 1);
    renderizarCarrinho();
}

function renderizarCarrinho() {
    let lista = document.getElementById("lista-carrinho");
    const botaoComprar = document.getElementById('comprar');
    botaoComprar.style.display = "flex";
    lista.innerHTML = "";
    
    let totalValorCarrinho = 0;

    carrinho.forEach((item, index) => {
        let subtotalItem = item.quantidade * item.preco;
        totalValorCarrinho += subtotalItem;
        
        lista.innerHTML += `
            <div class="item-no-carrinho">
                <span>${item.quantidade}x ${item.nome}</span>
                <span>
                    R$ ${subtotalItem.toFixed(2).replace(".", ",")}
                    <button onclick="removerDoCarrinho(${index})" style="background: red; color: white; border: none; border-radius: 3px; cursor: pointer; margin-left: 10px; font-weight: bold; padding: 2px 6px;">X</button>
                </span>
            </div>
        `;
    });

    document.getElementById("total-carrinho").innerText = " Total carrinho: R$ " + totalValorCarrinho.toFixed(2).replace(".", ",");
}

finalizarCompra();