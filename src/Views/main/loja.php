<?php
    
    $caminhoModelo = $_SERVER['DOCUMENT_ROOT'] . '/MonsterPE/src/Models/Usuario.php';

    if (file_exists($caminhoModelo)) {
        require_once $caminhoModelo;
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $nomeSeguro = 'Jogador';
    $emailSeguro = 'email@desconhecido.com';

    if (isset($_SESSION['usuario']) && is_object($_SESSION['usuario']) && method_exists($_SESSION['usuario'], 'getUsername')) {
        $nomeSeguro = $_SESSION['usuario']->getUsername();
        $emailSeguro = $_SESSION['usuario']->getEmail();
    }
    require_once '../../../assets/script/restricoes.php';
    verificaLogin();
    $mochila = Item::getInventario($_SESSION['usuario']->getId());
    $pokemonsUsuario = Pokemon::getTodosDoUsuario($_SESSION['usuario']->getId());
?>

<style>
    html {
        height: auto;
        min-height: 100%;
    }

    body {
        height: auto;
        overflow-y: visible;
        overflow-x: hidden;
    }

    #tela-equipe.menugens {
        max-height: none;
        overflow-y: visible;
    }

    .mochila-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(78px, 1fr));
        gap: 8px;
        width: 100%;
        margin-top: 15px;
    }
    .mochila-item {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid #888;
        border-radius: 6px;
        padding: 6px 4px;
        display: flex;
        flex-direction: column;
        align-items: center;
        color: white;
        font-size: 11px;
        text-align: center;
    }
    .mochila-item img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        image-rendering: pixelated;
    }
    .mochila-qtd {
        font-weight: bold;
        color: #ffd54f;
        margin-top: 2px;
    }
    .mochila-vazia {
        color: #ccc;
        font-size: 14px;
        margin-top: 12px;
    }
    .mochila-usavel {
        cursor: pointer;
        border-color: #ffcb05;
    }
    .mochila-usavel:hover {
        background: rgba(255, 203, 5, 0.25);
    }
    .lista-evolucao {
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 50vh;
        overflow-y: auto;
        margin-top: 12px;
    }
    .lista-evolucao button {
        padding: 10px 14px;
        font-size: 15px;
        text-align: left;
        border: 2px solid #333;
        border-radius: 5px;
        background: #444;
        color: #fff;
        cursor: pointer;
    }
    .lista-evolucao button:hover:not(:disabled) {
        background: #5b5a5a;
    }
    .lista-evolucao button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
</head>
<body>
    <nav style="justify-content:space-around;">
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav" style="position: relative;">
                  <a class="userview" style="cursor: pointer;" 
                    data-username="<?php echo $nomeSeguro; ?>" 
                    data-email="<?php echo $emailSeguro; ?>"
                    onclick="toggleDropdown(event)">
                    <img id="avatar-nav" src="" alt="Avatar">
                </a>
            <a href="../usuario/?acao=logout">Logout</a>
    </nav>
    <main class="maindash">
        <div id="tela-equipe" class="menugens" style="display:flex;">
            <aside class="aside-voltar" style="margin-left: -67px">
                <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
            </aside>
            <div class="layout-loja">
                <div class="area-loja">
                    <h2 class="titulo-loja" style="font-size: 50px; margin-top: -5px;">PokéMart</h2>
                    <div class="grid-time" id="grid-time">
                        <?php $itens = Item::getAtivos(); ?>
                        <?php if (empty($itens)): ?>
                            <p style="color: white;">Nenhum item disponível no momento.</p>
                        <?php endif; ?>
                        <?php foreach ($itens as $item): ?>
                        <div class="slot-item" data-id="<?= (int) $item['id'] ?>" data-preco="<?= htmlspecialchars($item['preco']) ?>" onclick="MostrarItem(this)">
                            <img src="<?= htmlspecialchars(Item::getImagem($item['nome'])) ?>" alt="<?= htmlspecialchars($item['nome']) ?>" class="item-imagem">
                            <span class="item-nome"><?= htmlspecialchars($item['nome']) ?></span>
                            <span class="item-preco">R$ <?= number_format((float) $item['preco'], 2, ',', '') ?></span>
                            <span class="item-desc" style="display: none;"><?= htmlspecialchars($item['descricao']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <span>
                    
                    </span>
                    </div>
                    <div class="areacompras">
                        <div class="area-pesquisa">
                            <h2 class="titulo-geracoes" style="font-size: 30px;">CARTEIRA</h2>
                            <div class="btn-buscar" id="saldo-carteira" style="align-self: center;"> R$ <?= $_SESSION['usuario']->getTokens() ?></div>
                        </div>
                        <div class="area-pesquisa">
                            <h2 class="titulo-geracoes" style="font-size: 30px;">MOCHILA</h2>
                            <div class="mochila-grid">
                                <?php if (empty($mochila)): ?>
                                    <p class="mochila-vazia">Sua mochila está vazia.</p>
                                <?php endif; ?>
                                <?php foreach ($mochila as $m): ?>
                                    <div class="mochila-item<?= strtolower(trim($m['nome'])) === 'evolution stone' ? ' mochila-usavel' : '' ?>" data-item-id="<?= (int) $m['id'] ?>" title="<?= htmlspecialchars($m['descricao']) ?><?= strtolower(trim($m['nome'])) === 'evolution stone' ? ' (clique para evoluir um Pokémon)' : '' ?>">
                                        <img src="<?= htmlspecialchars(Item::getImagem($m['nome'])) ?>" alt="<?= htmlspecialchars($m['nome']) ?>">
                                        <span><?= htmlspecialchars($m['nome']) ?></span>
                                        <span class="mochila-qtd">x<?= (int) $m['quantidade'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="area-pesquisa">
                            <h2 class="titulo-geracoes" style="font-size: 30px;">CARRINHO</h2>
                            <div id="total-carrinho" class="btn-buscar" style="align-self: center; font-size: 12px; font-family: Lexend, sans-serif;"></div>
                            <div id="lista-carrinho" style="width: 100%; margin-top: 20px; color: white;"></div>
                        </div>
                        <button type="button" onclick="finalizarCompra()" style="display: none;" id="comprar">Comprar</button>
                    </div>
            </div>
        </div>
        </main>
        <div id="modal-compra" class="modal-fundo" style="display: none;">
            
            <div class="modal-card">
                <span class="btn-fechar" onclick="fecharModal()">X</span>
                
                <img id="modal-img" src="" alt="Imagem do Item">
                <h3 id="modal-nome">Nome do Item</h3>
                <p id="modal-preco">R$ 0,00</p>
                <p id="modal-descricao" style="font-size: 14px; color: #ccc; margin: 10px 0;">Descrição do item</p>
                <div class="area-quantidade">
                    <button onclick="alterarQuantidade(-1)">-</button>
                    <span id="modal-qtd">1</span>
                    <button onclick="alterarQuantidade(1)">+</button>
                </div>
                
                <button class="btn-adicionar" onclick="adicionarAoCarrinho()">Adicionar ao Carrinho</button>
            </div>
        </div>
    <footer>
            <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
            <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
            <div class="opfoot" id="2">Entre na nossa comunidade do discord!
            <a href="https://discord.gg/6VaQrXhea" target="_blank">Clique aqui!</a>
            </div>
    </footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/time.js"></script>
<script src="../../../assets/script/loja.js"></script>

    <div id="modal-evolucao" class="modal-fundo" style="display: none;">
        <div class="modal-card" style="width: 380px; text-align: center;">
            <span class="btn-fechar" onclick="fecharModalEvolucao()">X</span>
            <h3>Evoluir Pokémon</h3>
            <p style="font-size: 14px; color: #ccc;">Escolha o Pokémon que vai evoluir com a Pedra da Evolução.</p>
            <div class="lista-evolucao">
                <?php if (empty($pokemonsUsuario)): ?>
                    <p style="color: #ccc;">Você ainda não tem Pokémon.</p>
                <?php endif; ?>
                <?php foreach ($pokemonsUsuario as $p): ?>
                    <button type="button" class="btn-evoluir-pokemon" data-id="<?= htmlspecialchars($p['id']) ?>">
                        <?= htmlspecialchars($p['apelido']) ?> (Lv <?= (int) $p['nivel'] ?>)<?= ((int) $p['ativo']) === 1 ? ' • no time' : '' ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div id="modal-avatar" class="modal-fundo" style="display: none;">
        <div class="modal-card" style="width: 360px; text-align: center;">
            <span class="btn-fechar" onclick="document.getElementById('modal-avatar').style.display='none'">X</span>
            <h3>Escolher Avatar</h3>
            <div class="grid-avatares">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-alola.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-capbackward.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-hoenn.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-johto.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-kalos.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-sinnoh.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash-unova.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/ash.png" onclick="trocarAvatar(this.src)">
                <img src="/MonsterPE/assets/imgs/Avatars/marcio.png" onclick="trocarAvatar(this.src)">
            </div>
        </div>
    </div>
</body>
</html>

