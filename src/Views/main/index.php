<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MonsterPE</title>
    <link rel="stylesheet" href="/MonsterPE/assets/css/index.css?v=2">
</head>
<body>
    <nav>
        <div class="logonav"><a href="index.php"><img src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo"></a></div>
        <div class="opnav">
        <a href="/MonsterPE/src/Views/PagesDavi/duvidas.php">Dúvidas</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/guia.php">Guias</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/jogospoke.php">Jogos de Pokémon</a>|
        <a href="/MonsterPE/src/Views/PagesDavi/animes.php">Anime</a>|
        <a href="https://discord.gg/uaCCbWHex">Discord</a></div>
    </nav>
    <main>
        <div class="form">
            <h2><div class="titleform">FAÇA SEU LOGIN</div></h2>
            <div class="campos">
                <a class="opformlog" href="/MonsterPE/src/Views/usuario/?acao=login">LOGIN</a>
                <a class="opformlog" href="/MonsterPE/src/Views/usuario/?acao=cadastro">CADASTRE-SE</a>
            </div>
        </div>

    <div class="player-audio-container">
        <audio id="meuAudio" src="/MonsterPE/assets/songs/PokemonTema.mp3" loop></audio>
        <button id="btnPlay" class="player-audio-btn" onclick="alternarAudio()">    
            <span id="iconePlay">▶️</span>
            <span id="textoPlay">Tocar</span>
        </button>
        <label for="sliderVol" class="player-audio-label">🔊</label>
        <input type="range" id="sliderVol" class="player-audio-slider" min="0" max="1" step="0.05" value="0.5" oninput="mudarVolumeSuave(this.value)">
    </div>
</main>
<footer>
        <img class="logofoot" src="/MonsterPE/assets/imgs/MonsterPE.png" alt="MonsterPE logo">
        <div class="opfoot">© 2026 MonsterPE | Todos direitos reservados</div>
        <div class="opfoot" id="2">Entre na nossa comunidade do discord!
          <a href="https://discord.gg/uaCCbWHex">Clique aqui!</a>
        </div>
</footer>
</body>
</html>
<script>
  const audio = document.getElementById('meuAudio');
  const icone = document.getElementById('iconePlay');
  const texto = document.getElementById('textoPlay');
  let fadeInterval = null;

  audio.volume = 0.5;

  function alternarAudio() {
    if (audio.paused) {
      audio.play();
      icone.textContent = '⏸️';
      texto.textContent = 'Pausar';
    } else {
      audio.pause();
      icone.textContent = '▶️';
      texto.textContent = 'Tocar';
    }
  }

  function mudarVolumeSuave(alvo) {
    const volumeAlvo = parseFloat(alvo);
    clearInterval(fadeInterval);

    fadeInterval = setInterval(() => {
      const passo = 0.02;
      const diferenca = volumeAlvo - audio.volume;

      if (Math.abs(diferenca) <= passo) {
        audio.volume = volumeAlvo;
        clearInterval(fadeInterval);
      } else {
        audio.volume += diferenca > 0 ? passo : -passo;
      }
    }, 20);
  }

  window.addEventListener('DOMContentLoaded', () => {
    audio.play().then(() => {
      icone.textContent = '⏸️';
      texto.textContent = 'Pausar';
    }).catch(() => {
      const desbloquear = () => {
        audio.play();
        icone.textContent = '⏸️';
        texto.textContent = 'Pausar';
        window.removeEventListener('click', desbloquear);
      };
      window.addEventListener('click', desbloquear, { once: true });
    });
  });
</script>