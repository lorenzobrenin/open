<?php

// 1° connessione al SV
    require "config.php"; //riferimento a file configurazione DSN sv name user, password
    try {
        $c = new PDO($dsn, $user, $password); // $c == connession == nuovo obj PDO
        } catch(PDOException $e){
                echo "Exception found";
                echo $e -> getMessage();
            }