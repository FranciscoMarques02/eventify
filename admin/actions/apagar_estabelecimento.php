<?php
session_start();
if (isset($_GET['id']) && isset($_SESSION['usuario'])) {
    require_once('../classes/Estabelecimento.class.php');
    $event = new Estabelecimento();
    $event->id = $_GET['id'];
    $estab = $event->Listar_view_especifico();

    // Verificar se o usuário é dono do estab ou admin
    if(($estab[0]['id_usuario'] == $_SESSION['usuario']['ID']) or $_SESSION['usuario']['id_nivel'] == 1){
        $qtd_linhas_apagadas = $event->Apagar();
        if ($qtd_linhas_apagadas == 1) {
            if ($_SESSION['usuario']['id_nivel'] == 2) {
                header('Location: ../../usuario.php?msg=11');
                exit();
            } else {
                header('Location: ../admin.php?msg=3');
                exit();
            }
        }
    }else{
        header('Location: ../../usuario.php?err=18');
        exit();
    }
}
// http://10.141.48.12/Francisco/eventify/admin/actions/apagar_estabelecimento.php?id=75

// if (isset($_GET['id']) && isset($_SESSION['usuario'])) {
//     require_once('../classes/Estabelecimento.class.php');
//     $event = new Estabelecimento();
//     $event->id = $_GET['id'];
//     if ($_GET['id_usuario_veri'] == $_SESSION['usuario']['id']) {
//         header('Location: ../../usuario.php?err=18');

//         if ($_SESSION['usuario']['id_nivel'] == 1) {
//             $qtd_linhas_apagadas = $event->Apagar();

//             if ($qtd_linhas_apagadas == 1) {
//                 // Verificar se é o admin
//                 if ($_SESSION['usuario']['id_nivel'] == 2) {
//                     header('Location: ../../usuario.php?msg=11');
//                     exit;
//                 } else {
//                     header('Location: ../admin.php?msg=18');
//                     exit;
//                 }
//             } else {
//                 if ($_SESSION['usuario']['id_nivel'] == 2) {
//                     header('Location: ../../usuario.php?err=18');
//                     exit;
//                 } else {
//                     header('Location: ../admin.php?err=18');
//                     exit;
//                 }
//             }
//         }
//     }
    
// }
?>