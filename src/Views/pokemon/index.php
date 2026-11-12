<?php
    require_once __DIR__ . "/../../../config/autoload.php";
    
    session_start();

    $acao = $_GET['acao'] ?? 'salvar';
    
    $nomeClasse = ucfirst(basename(__DIR__));
    $nomeController = $nomeClasse . "Controller";
    var_dump($nomeClasse);
    $controller = new $nomeController();

    $controller->$acao();
?>