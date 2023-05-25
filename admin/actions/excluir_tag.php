<?php
session_start();

if(isset($_GET['id']) && isset($_SESSION['usuario'])){
    require_once('../classes/Tag.class.php');

    $tag = new Tag();
    $tag->id_tag = $_GET['id'];
    $tag->id_usuario = $_SESSION['usuario']['ID'];
    $qtd_linhas_apagadas = $tag->Excluir();

    if($qtd_linhas_apagadas >= 1){
        header('Location: ../../usuario.php?msg=5');
        exit;
    }else{
        
        header('Location: ../../usuario.php?err=4');
        exit;
       
    }
}
?>