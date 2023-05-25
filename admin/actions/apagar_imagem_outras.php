<?php
session_start();

if(isset($_SESSION['usuario'])){
require_once('../classes/Img.evento.class.php');
$imagem= new Imagens_evento();
$imagem->id_img=$_GET['id_img'];

try{
    $imagem->Apagar();
    header('Location:../Editar_eventos_index.php?msg=7&id='.$_GET['id_evento']);
}
catch(exception $e){
    echo $e->getMessage();
    header('Location:../../Editar_eventos_index.php?err=7&id='.$_GET['id_evento']);
}

}
?>