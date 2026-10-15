<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Geração</th>
                <th>Speed</th>
                <th>Attack</th>
                <th>Defense</th>
                <th>Sp. Attack</th>
                <th>Sp. Defense</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pokemons as $pokemon): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pokemon->getNome()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getDescricao()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getGeracao()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getSpeed()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getAttack()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getDefense()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getSpAttack()); ?></td>
                    <td><?php echo htmlspecialchars($pokemon->getSpDefense()); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>