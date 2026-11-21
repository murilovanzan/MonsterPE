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
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do usuário</title>
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
                onclick="toggleDropdown(event)"> Usuário</a> |
            <a href="../usuario/?acao=logout">Logout</a>
    </nav>
    <main class="maindash">
        <div id="tela-equipe" class="menugens" style="display:flex;">
            <button class="btn-voltar-pequeno" onclick="voltarParaJogar()">⬅ Voltar</button>
            <div class="layout-loja">
                <div class="area-loja">
                    <h2 class="titulo-loja" style="font-size: 50px; margin-top: -5px;">PokéMart</h2>
                    <div class="grid-time" id="grid-time">
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/antidote.png" alt="Antidote" class="item-imagem">
                            <span class="item-nome">Antidote</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon do estado de Envenenamento.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/awakening.jpeg" alt="Awakening" class="item-imagem">
                            <span class="item-nome">Awakening</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon do estado de Sono.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/burnheal.png" alt="Burn Heal" class="item-imagem">
                            <span class="item-nome">Burn Heal</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon do estado de Queimadura.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/full heal.png" alt="Full Heal" class="item-imagem">
                            <span class="item-nome">Full Heal</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon de status de Envenenamento, Sono, Congelamento, Paralisia e Queimadura, sem recuperar HP.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/fullrestore.png" alt="Full Restore" class="item-imagem">
                            <span class="item-nome">Full Restore</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura 100% do HP e todos status.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/hyperpotion.jpeg" alt="Hyper Potion" class="item-imagem">
                            <span class="item-nome">Hyper Potion</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um 200HP de um pokémon que não esteja desmaiado.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/iceheal.png" alt="Ice Heal" class="item-imagem">
                            <span class="item-nome">Ice Heal</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon do estado de Congelamento.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/maxpotion.jpeg" alt="Max Potion" class="item-imagem">
                            <span class="item-nome">Max Potion</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura 100% do HP de um pokémon que não esteja desmaiado.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/paralyzeheal.jpeg" alt="Paralyze Heal" class="item-imagem">
                            <span class="item-nome">Paralyze Heal</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura um Pokémon do estado de Paralisia.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/Potion.jpeg" alt="Potion" class="item-imagem">
                            <span class="item-nome">Potion</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura 20HP de um pokémon que não esteja desmaiado.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/rarecandy.jpeg" alt="Rare Candy" class="item-imagem">
                            <span class="item-nome">Rare Candy</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Aumenta um nível de um pokémon.</span>
                        </div>
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/rarecandy.jpeg" alt="Rare Candy" class="item-imagem">
                            <span class="item-nome"> 10 X Rare Candy</span>
                            <span class="item-preco">R$ 100,00</span>
                            <span class="item-desc" style="display: none;">Aumenta um nível de um pokémon.</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/revive.png" alt="Revive" class="item-imagem">
                            <span class="item-nome">Revive</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Tira o pokémon do estado de desmaiado e cura 50% de seu HP</span>
                        </div>

                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/superpotion.png" alt="Super Potion" class="item-imagem">
                            <span class="item-nome">Super Potion</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Cura 50HP de um pokémon que não esteja desmaiado.</span>
                        </div>
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/honey.png" alt="Honey" class="item-imagem">
                            <span class="item-nome">Sweet honey</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Serve para atrair pokémons e deixá-los confusos.</span>
                        </div>
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/redorb.png" alt="Ruby" class="item-imagem">
                            <span class="item-nome">Precious Ruby</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">Pode te salvar de grandes fumaceiros.</span>
                        </div>
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/egg.jpeg" alt="Lucky Egg" class="item-imagem">
                            <span class="item-nome">Lucky Egg</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">O PascualOVO da sorte serve para aumentar a amizade com seu pokémon.</span>
                        </div>
                        <div class="slot-item" onclick="MostrarItem(this)">
                            <img src="/MonsterPE/assets/imgs/Loja/evolutionstone.png" alt="Pedra da evolução" class="item-imagem">
                            <span class="item-nome">Evolution Stone</span>
                            <span class="item-preco">R$ 10,00</span>
                            <span class="item-desc" style="display: none;">A pedra que concede ao pokémon evolução imediata.</span>
                        </div>
                    </div>
                    <span>
                    
                    </span>
                    </div>
                    <div class="areacompras">
                        <div class="area-pesquisa">
                            <h2 class="titulo-geracoes" style="font-size: 30px;">CARTEIRA</h2>
                            <div class="btn-buscar" style="align-self: center;"> R$ XX,XX</div>
                        </div>
                        <div class="area-pesquisa">
                            <h2 class="titulo-geracoes" style="font-size: 30px;">CARRINHO</h2>
                            <div id="total-carrinho" class="btn-buscar" style="align-self: center; font-size: 12px; font-family: Lexend, sans-serif;"></div>
                            <div id="lista-carrinho" style="width: 100%; margin-top: 20px; color: white;"></div>
                        </div>
                        
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
            <a href="https://discord.gg/uaCCbWHex" target="_blank">Clique aqui!</a>
            </div>
    </footer>
<script src="../../Models/Pokeapi.js"></script>
<script src="../../../assets/script/time.js"></script>
<script src="../../../assets/script/loja.js"></script>

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
