<?php

    require_once __DIR__ . "/../../../config/autoload.php";


    $pdo = getConnection();

    $count = 0;
    foreach ($timeJSON as $pokemon){
        $sql = "INSERT INTO pokemon (usuario_id, pokemon, hp, speed, attack, spAttack, defense, spDefense, posicao) VALUES (:user_id, :p, :hp, :s, :a, :sa, :d, :sd, :i);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => 1,
            ':p' => $pokemon['id'],
            ':hp' => $pokemon['stats'][0]['base_stat'],
            ':s' => $pokemon['stats'][5]['base_stat'],
            ':a' => $pokemon['stats'][1]['base_stat'],
            ':sa' => $pokemon['stats'][3]['base_stat'],
            ':d' => $pokemon['stats'][2]['base_stat'],
            ':sd' => $pokemon['stats'][4]['base_stat'],
            ':i' => $count
        ]);
        $count++;
    }

    
?>