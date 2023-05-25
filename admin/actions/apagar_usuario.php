<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['usuario'])) {
    require_once('../classes/Usuario.class.php');

    $usu = new Usuario();
    $usu->id = $_GET['id'];
    if ($_SESSION['usuario']['id'] != $_GET['id']) {
        header('Location: ../../usuario.php?err=9');
        if ($_SESSION['usuario']['id_nivel'] == 1) {
            $qtd_linhas_apagadas = $usu->Excluir();
            if ($qtd_linhas_apagadas = 1) {
                header('Location: ../admin.php?msg=9');
                exit;
            } else {
                header('Location: ../../usuario.php?err=9');
                exit;
            }
        }
        exit;
    } else {
        $qtd_linhas_apagadas = $usu->Excluir();

        if ($qtd_linhas_apagadas = 1) {
            header('Location: ../admin.php?msg=9');
            exit;
        } else {
            header('Location: ../../usuario.php?err=9');
            exit;
        }
    }
}
