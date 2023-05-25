<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../classes/Categoria.estab.class.php');
    $categoriaEstab = new Categoria_Estabelecimento();
    $categoriaEstab->nome = ucwords(strtolower($_POST['categ_estab']));

    require_once('../classes/Categoria.evento.class.php');
    $categoriaEvento = new Categoria_Evento(); 
    $categoriaEvento->nome = ucwords(strtolower($_POST['categ_event']));
    
    try{
        if($_POST['categ_estab'] == ""){
            $categoriaEvento->Cadastrar();
        }else{
            $categoriaEstab->Cadastrar();
        }
        
        // Verificar se é o admin
        if($_SESSION['usuario']['id_nivel'] == 2){
            header('Location: ../../usuario.php?msg=0');
            exit;
        }else{
            header('Location: ../admin.php?msg=0');
        exit;
        }
    }catch(PDOException $e){
        // Verificar se é o admin
        if($_SESSION['usuario']['id_nivel'] == 2){
            header('Location: ../../usuario.php?err=1');
            exit;
        }else{
            header('Location: ../admin.php?err=1');
            exit;
        }
        
    }
}
?>