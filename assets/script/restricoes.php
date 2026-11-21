<?php
    session_start();
    
    function verificaLogin(){
        if(!isset($_SESSION['login']) || !$_SESSION['login']){
            header("location: /MonsterPE/src/Views/main/?errorMessage=Você deve fazer login antes!");
        }
    }

    function isAdmin(){
        if(!isset($_SESSION['admin']) || !$_SESSION['admin']){
            header("location: /MonsterPE/src/Views/main/?errorMessage=Você não tem permissão para acessar essa página!");
        }
    }
    
?>