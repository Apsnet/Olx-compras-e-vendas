<?php
    require 'config.php';    //Já contem session_start()
    require 'classes/anuncios.class.php';
    
  
    $a = new Anuncios();

    if(empty($_SESSION['cLogin'])){
            header("Location: login.php");
            exit;
    }

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id_anuncio = $a->excluirFoto($_GET['id']); //Exclui e retorna pro anuncio
    }

    if(isset($id_anuncio)){
        header("Location: editar-anuncio.php?id=".$id_anuncio);
    }else{
        
        header("Location: meus-anuncios.php");
    }
