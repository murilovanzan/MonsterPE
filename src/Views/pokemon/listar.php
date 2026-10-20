<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border=1>
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
            <?php foreach($dados as $pokemon): ?>
                <tr>
                    <td><?= $pokemon['nome']?></td>
                    <td><?= $pokemon['descricao']?></td>
                    <td><?= $pokemon['geracao']?></td>
                    <td><?= $pokemon['hp']?></td>
                    <td><?= $pokemon['speed']?></td>
                    <td><?= $pokemon['attack']?></td>
                    <td><?= $pokemon['spAttack']?></td>
                    <td><?= $pokemon['defense']?></td>
                    <td><?= $pokemon['spDefense']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>