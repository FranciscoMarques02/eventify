<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])) {
    require_once('../classes/Tag.class.php');

    $tag = new Tag();
    $result = $tag->ListarTudoTag();
   foreach($result as $tags){
    if($tags['nome']==$_POST['nome']){
        header('Location: ../../usuario.php?err=16');
        exit;
    }
   }
    $tag->nome = ucfirst(strtolower($_POST['nome']));
    

        try {
            $tag->Adicionar() == 1;
            header('Location: ../../usuario.php?msg=6');
            exit;
            
        }
        catch(Exception $e)  {
            header('Location: ../../usuario.php?err=3');
            exit;
        }
    }

