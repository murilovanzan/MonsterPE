<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    
    require_once __DIR__ . "/../../../config/autoload.php";
    
    session_start();

    $acao = $_GET['acao'] ?? 'salvar';
    
    $nomeClasse = ucfirst(basename(__DIR__));
    $nomeController = $nomeClasse . "Controller";

    $controller = new $nomeController();

    $controller->$acao();
?>