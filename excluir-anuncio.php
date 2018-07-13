<?php
    require 'config.php';    //Já contem session_start()
    require 'classes/anuncios.class.php';
    
  
    $a = new Anuncios();

    if(empty($_SESSION['cLogin'])){
            header("Location: login.php");
            exit;
    }

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $a->excluirAnuncio($_GET['id']);
    }

    header("Location: meus-anuncios.php");