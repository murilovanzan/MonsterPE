<?php
    require_once __DIR__ . "/../../../config/autoload.php";

    $acao = $_GET['acao'] ?? 'listar';
    
    $nomeClasse = ucfirst(basename(__DIR__));
    $nomeController = $nomeClasse . "Controller";

    $controller = new $nomeController();

    $controller->$acao();
?>