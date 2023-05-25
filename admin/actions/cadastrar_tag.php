<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])) {
    require_once('../classes/Tag.class.php');

    $tag = new Tag();
    $tag->id_usuario = $_SESSION['usuario']['ID'];
    $resultado = $tag->ListarTags();

    foreach ($resultado as $tags) {
        if ($tags['id_usuario'] == $_SESSION['usuario']['ID'] && $tags['id_tag'] == $_POST['id_tag']) {
            $jatem = true;
        }
    }
    if ($jatem == true) {
        header('Location: ../../usuario.php?err=5');
        exit;
    } else {
        $tag->id_tag = $_POST['id_tag'];
        if ($tag->Cadastrar() == 1) {
            header('Location: ../../usuario.php?msg=6');
            exit;
        } else {
            header('Location: ../../usuario.php?err=3');
            exit;
        }
    }
}
