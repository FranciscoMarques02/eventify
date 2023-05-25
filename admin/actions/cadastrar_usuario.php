<?php 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../classes/Usuario.class.php');
    $usuario = new Usuario();
    if(!empty($_POST['nome'])){
    $usuario->nome = $_POST['nome'];
    }
    else{
        header('Location: ../login.php?err=11');
        exit;
    }
    if(!empty($_POST['email'])){
        $usuario->email = $_POST['email'];
        }
        else{
            header('Location: ../login.php?err=12');
            exit;
        }
    $usuario->descricao = $_POST['descricao'];
    $usuario->id_nivel = 2;
    $usuario->foto = 'login.png';
   

    if($_POST['senha'] == $_POST['confirmacao_senha']){
        $usuario->senha = $_POST['senha'];
    }else{
        header('Location: ../login.php?err=6');
        exit;
    }

    try{
        $usuario->Cadastrar();
        header('Location: ../login.php?msg=0');
        exit;
     
    }catch(PDOException $e){
        header('Location: ../login.php?err=1');
        exit;
    }
}
?>