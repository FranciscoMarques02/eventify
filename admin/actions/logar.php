<?php 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../classes/Usuario.class.php');
    $usuario = new Usuario();
    $usuario->email = $_POST['email'];
    $usuario->senha = $_POST['senha'];

    $resultado = $usuario->Logar();

    if(count($resultado) == 1){
        session_start();
        $_SESSION['usuario'] = $resultado[0];
        require_once('../classes/Estabelecimento.class.php');
        $estabelecimento = new Estabelecimento();
        $estabelecimento->id_usuario = $_SESSION['usuario']['ID'];
        $resultado2 = $estabelecimento->Listar_especif();
        if(count($resultado) == 1 || $_SESSION['usuario']['id_nivel'] = 1){
            $_SESSION['estabelecimento'] = $resultado2[0];
            
        // Verificar se o usuario é admin ou padrão:
        if($_SESSION['usuario']['id_nivel'] == 2){
            header('Location: ../../usuario.php');
        }else{
            header('Location: ../admin.php');
        }
        
        
        
       
        }
    }else{
        header('Location: ../login.php?err=1');
        exit;
    }
}

?>