<?php

    function getConnection() {

            $host = "localhost";
            $dbname = "beta_MonsterPE";
            $user = "root";
            $pass = "";


            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
            
        return $pdo;
    }
?>