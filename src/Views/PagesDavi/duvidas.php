<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de dúvidas</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
    <link rel="icon" type="image/png" href="/MonsterPE/assets/imgs/MasterballIcon.png">
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .forum, .contatos-box {
            background-color: rgba(0, 0, 0, 0.75);
            border-radius: 20px;
            width: 50vw;
            padding: 20px 40px 30px;
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }

        textarea {
            width: 100%;
            max-width: 100%;
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
            font-family: inherit;
            font-family: Lexend, sans-serif;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            background-color: #ffcb05;
            color: #3b4cca;
            border: 3px solid #3b4cca;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 0 #2a3b96;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .subtitulo-salvas {
            grid-column: 1 / -1;
            text-align: center;
            color: #ffcb05; 
            text-shadow: 2px 2px 0px #3b4cca, -1px -1px 0px #3b4cca, 1px -1px 0px #3b4cca, -1px 1px 0px #3b4cca, 1px 1px 0px #3b4cca; 
            font-size: 25px;
            font-family: Lexend, sans-serif;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        #lista-duvidas {
            text-align: left;
        }

        .duvida-salva {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 5px solid #3B4CCA;
            border-right: 5px solid #ffcb05;
            padding: 15px;
            padding-bottom: 30px;
            border-radius: 8px;
            margin-bottom: 15px;
            word-wrap: break-word;
            position: relative; 
            font-family: Lexend, sans-serif;
        }

        .data-hora {
            position: absolute;
            bottom: 8px;
            right: 12px;
            font-size: 12px;
            color: #aaaaaa;
            font-style: italic;
        }

        .btn-apagar {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            color: #ff4c4c;
            border: none;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s;
        }
        .contatos-grid {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .contato-item a {
            color: #FFDE00;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            font-family: Lexend, sans-serif;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logonav"><a href="/MonsterPE/src/Views/main/"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
            <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php" target="_blank">Dúvidas</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/guia.php" target="_blank">Guias</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php" target="_blank">Jogos de Pokémon</a>|
            <a href="/MonsterPE/src/Views/PagesDavi/animes.php" target="_blank">Anime</a>|
            <a href="https://discord.gg/uaCCbWHex" target="_blank">Discord</a>
        </div>
    </nav>
    <main>
        <div class="forum">
            <h2 class="titulo-geracoes" style="margin-top: 10px;">FÓRUM DE DÚVIDAS MONSTERPE</h2>
            
            <form id="formDuvida">
                <label for="mensagem" class="titulo-geracoes" style="font-size: 25px;">Digite sua dúvida aqui</label><br>
                <textarea id="mensagem" name="mensagem" rows="6" placeholder="Digite aqui seu texto..." required></textarea><br>
                <button type="submit">Enviar</button>
            </form>

            <h3 id="subtitulo-salvas" class="subtitulo-salvas">Suas dúvidas Salvas</h3>
            <div id="lista-duvidas"></div>
        </div>

        <div class="contatos-box">
            <h2 class="titulo-geracoes">Ainda com dúvidas? Fale conosco!</h2>
            <div class="contatos-grid">
                <div class="contato-item">
                    📧 <a href="mailto:2024301390@aluno.canoas.ifrs.edu.br">E-mail suporte 1</a>
                </div>
                <div class="contato-item">
                    📧 <a href="mailto:2024301335@aluno.canoas.ifrs.edu.br" target="_blank">E-mail suporte 2</a>
                </div>
                <div class="contato-item">
                    📧 <a href="mailto:2024311485@aluno.canoas.ifrs.edu.br " target="_blank">E-mail suporte 3</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex">Clique aqui!</a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formDuvida');
            const textarea = document.getElementById('mensagem');
            const listaDuvidas = document.getElementById('lista-duvidas');
            const subtitulo = document.getElementById('subtitulo-salvas');

            const verificarSubtitulo = (duvidas) => {
                subtitulo.style.display = duvidas.length > 0 ? 'block' : 'none';
            };

            const carregarDuvidas = () => {
                const duvidas = JSON.parse(localStorage.getItem('monsterpe_duvidas_v4')) || [];
                listaDuvidas.innerHTML = ''; 
                verificarSubtitulo(duvidas);
                duvidas.forEach(duvida => adicionarDuvidaNaTela(duvida));
            };

            const apagarDuvida = (id) => {
                let duvidas = JSON.parse(localStorage.getItem('monsterpe_duvidas_v4')) || [];
                duvidas = duvidas.filter(d => d.id !== id);
                localStorage.setItem('monsterpe_duvidas_v4', JSON.stringify(duvidas));
                const elemento = document.getElementById(`duvida-${id}`);
                if (elemento) elemento.remove();
                verificarSubtitulo(duvidas);
            };

            const adicionarDuvidaNaTela = (duvidaObj) => {
                const textoSeguro = duvidaObj.texto.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                const htmlDuvida = `
                    <div class="duvida-salva" id="duvida-${duvidaObj.id}">
                        <button class="btn-apagar" title="Apagar dúvida">X</button>
                        <div style="padding-right: 20px;">${textoSeguro}</div>
                        <div class="data-hora">${duvidaObj.data}</div>
                    </div>
                `;
                listaDuvidas.insertAdjacentHTML('afterbegin', htmlDuvida);
                const btnApagar = document.querySelector(`#duvida-${duvidaObj.id} .btn-apagar`);
                btnApagar.addEventListener('click', () => apagarDuvida(duvidaObj.id));
            };

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                
                const textoDuvida = textarea.value.trim();
                
                if (textoDuvida !== '') {
                    const agora = new Date();
                    const dataFormatada = agora.toLocaleDateString('pt-BR') + ' às ' + agora.toLocaleTimeString('pt-BR', {hour: '2-digit', minute:'2-digit'});

                    const novaDuvida = {
                        id: Date.now(), 
                        texto: textoDuvida,
                        data: dataFormatada
                    };

                    const duvidas = JSON.parse(localStorage.getItem('monsterpe_duvidas_v4')) || [];
                    duvidas.push(novaDuvida);
                    localStorage.setItem('monsterpe_duvidas_v4', JSON.stringify(duvidas));
                    
                    adicionarDuvidaNaTela(novaDuvida);
                    verificarSubtitulo(duvidas);
                    
                    textarea.value = '';
                }
            });

            carregarDuvidas();
        });
    </script>
</body>
</html>