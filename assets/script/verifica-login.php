<?php

    session_start();
    if(!isset($_SESSION['login']) || !$_SESSION['login']){
        header("location: /MonsterPE/src/Views/main/?errorMessage=Você deve fazer login antes!");
    }

?>