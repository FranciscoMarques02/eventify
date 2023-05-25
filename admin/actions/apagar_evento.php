<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['usuario'])) {
    require_once('../classes/Evento.class.php');
    $event = new Evento();
    $event->id = $_GET['id'];

    $tabela = $event->Listar_especif3();
    
    
    if ($tabela[0]['id_usu_resp'] == $_SESSION['usuario']['ID']) {
        $qtd_linhas_apagadas = $event->Apagar();
        echo $_POST['id'];
        if ($qtd_linhas_apagadas == 1) {
            // Verificar se é o admin
            if ($_SESSION['usuario']['id_nivel'] == 2) {
                header('Location: ../../usuario.php?msg=7');
                exit;
            } else {
                header('Location: ../admin.php?msg=7');
                exit;
            }
        } else {
            if ($_SESSION['usuario']['ID'] == 2) {
                header('Location: ../../usuario.php?err=7');
                exit;
            } else {
                header('Location: ../admin.php?err=7');
                exit;
            }
        }
    } else if ($_SESSION['usuario']['id_nivel'] == 1){
            $qtd_linhas_apagadas = $event->Apagar();

            if ($qtd_linhas_apagadas == 1) {
                // Verificar se é o admin
                if ($_SESSION['usuario']['id_nivel'] == 2) {
                    header('Location: ../../usuario.php?msg=7');
                    exit;
                } else {
                    header('Location: ../admin.php?msg=7');
                    exit;
                }
            } else {
                if ($_SESSION['usuario']['id'] == 2) {
                    header('Location: ../../usuario.php?err=7');
                    exit;
                } else {
                    header('Location: ../admin.php?err=7');
                    exit;
                }
            }
           }
           else{
            header('Location: ../../usuario.php?err=7');
            exit;
           }
        }
        else{
            header('Location: ../../usuario.php?err=7');
        }
        

