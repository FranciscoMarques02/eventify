<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../classes/Cidade.class.php');
    $Cidade = new Cidade();    
    $Cidade->nome = ucwords(strtolower($_POST['nome'])); // Primeira letra maiúscula
    
    try{
        $Cidade->Cadastrar();
        // Verificar se é admin
        if($_SESSION['usuario']['id_nivel'] == 2){
            header('Location: ../../usuario.php?msg=0');
            exit;
        }else{
            header('Location: ../admin.php?msg=0');
            exit;
        }
        
     
    }catch(PDOException $e){
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