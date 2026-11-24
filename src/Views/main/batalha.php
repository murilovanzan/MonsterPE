<?php



?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batalha</title>
    <script type="module">
        
        const timeUsuarioBruto = <?= json_encode($_SESSION['pokemonAtivo'])?>;

        const promissesTimeUsuario = timeUsuarioBruto.map(pokemon => formatarPokemon(pokemon, true));
        const timeUsuario = await Promise.all(promissesTimeUsuario);
        const timeOponente = await gerarTimeAutomatico();
        const spanPokemonUsuario = document.querySelector('#pokemonUsuario > img');
        const spanPokemonOponente = document.querySelector('#pokemonOponente > img');
        
        spanPokemonUsuario.src = timeUsuario[0].sprites.front_default;
        
        spanPokemonOponente.src = timeOponente[0].sprites.front_default;
    </script>
    <script src="../../Models/Pokeapi.js"></script>
    <script src="../../../assets/script/batalha.js"></script>
</head>
<body>
    <span id="pokemonUsuario"><img src="" alt=""></span>
    <span id="pokemonOponente"><img src="" alt=""></span>
    <button type="button">Atacar</button>
</body>
</html>