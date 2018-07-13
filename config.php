<?php

session_start();

global $pdo;
try{
    $pdo = NEW PDO("mysql:dbname=classificados;host=localhost","root","nit_uesc"); //wolf
}catch(PDOException $e){
    echo "Erro ao se contectar".$e->getMessage();
    exit;
}
