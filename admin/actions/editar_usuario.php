<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])){
    require_once('../classes/Usuario.class.php');
    $usu = new Usuario();
    $usu->nome = $_POST['nome'];
    $usu->email = $_POST['email'];
    $usu->descricao = $_POST['descricao']; 
    
    // Verificar se é admin
    if($_SESSION['usuario']['id_nivel'] == 1){
        $usu->id= $_POST['id'];
        $usu->id_nivel = $_POST['id_niv'];
    }
    else{
        $usu->id = $_SESSION['usuario']['ID'];
        $usu->id_nivel = 2;
    }

    
    // Verificar se uma foto foi upada:
    if (is_uploaded_file($_FILES['foto_perfil']['tmp_name'])) {
        $extensao = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        // Atribuir hash.extensão no nome da img:
        $novo_nome = hash_file('sha256', $_FILES['foto_perfil']['tmp_name']);
        $novo_nome = $novo_nome.".".$extensao;
    
        // Se usuario não mandar foto, txt "semfoto.jpg" é cadastrado:
        if(move_uploaded_file($_FILES['foto_perfil']['tmp_name'], "../../img/usuarios/" . $novo_nome)){
            $usu->foto = $novo_nome;
        }else{
            $usu->foto = "semfoto.jpg";
        }   
        }else{
            $usu->foto = $_POST['foto_antiga'];
    }


    // Verificar se o campo senha está vazio:
    if($_POST['senha'] != ''){
        // Confirmação de senha
        if($_POST['senha'] == $_POST['confirmacao_senha']){
            $usu->senha = $_POST['senha'];
            $usu->senha_vazio= false;
        }else{
            header('Location: ../../usuario.php?err=6');
            exit;
        }
    }else{
        $usu->senha = $_POST['senha_antiga'];
        $usu->senha_vazio= true;
    }
    
    if($usu->Editar() >= 1){
        // Verificar se quem está editando é admin e fazer o direcionamento:
        if($_SESSION['usuario']['id_nivel'] == 1){
            header('Location: ../admin.php?msg=2');
            exit;
        }else{
            header('Location: ../../usuario.php?msg=2');
            exit;
        }
        
    }else{
        if($_SESSION['usuario']['id_nivel'] == 1){
            header('Location: ../admin.php?err=3');
            exit;
        }else{
            header('Location: ../../usuario.php?err=3');
            exit;
        }
        
    }
}


?>