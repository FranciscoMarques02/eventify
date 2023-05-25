<?php 
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])){
    require_once('../classes/Estabelecimento.class.php');
    $estabelecimento = new Estabelecimento();
    $estabelecimento->nome = $_POST['nome'];
    $estabelecimento->email = $_POST['email'];
    $estabelecimento->id_catego_estab = $_POST['categoria_estab'];
    $estabelecimento->id_cidade = $_POST['id_cidade'];

    // Verificar se uma foto foi upada:
        if (is_uploaded_file($_FILES['foto_estab_p']['tmp_name'])) {
            $extensao = pathinfo($_FILES['foto_estab_p']['name'], PATHINFO_EXTENSION);
            // Atribuir hash.extensão no nome da img:
            $novo_nome = hash_file('sha256', $_FILES['foto_estab_p']['tmp_name']);
            $novo_nome = $novo_nome . "." . $extensao;
    
            // Se usuario não mandar foto, txt "semfoto.jpg" é cadastrado:
            if (move_uploaded_file($_FILES['foto_estab_p']['tmp_name'], "../../img/estabelecimentos/" . $novo_nome)) {
                $estabelecimento->img = $novo_nome;
            }
        } else {
            $estabelecimento->img = $_POST['foto_antiga'];
        }



    if($_SESSION['usuario']['id_nivel'] != 1){
        $estabelecimento->id_usuario = $_SESSION['usuario']['ID'];
    }else{
        $estabelecimento->id_usuario = $_POST['id_usuario'];
    }

    require_once('../classes/Redes_sociais.php');
    $resultado2 = $estabelecimento->Listar_especif();
    
    $estabelecimento->id = $resultado2[0]['id'];
    $contador = count($_POST['rede']);
    
    $count = 0;
    if(!empty($_POST['rede'])){
        for($i=0;$i<$contador;$i++){
            $rede = new rede_social();
            $rede->id_estabelecimento=$resultado2[0]['id'];
            // print_r($_POST['rede_id']);
            $rede->id=$_POST['rede_id'][$i];
            $rede->link_rede=$_POST['rede'][$i];
            $rede->id_rede = $i;
            $count += $rede->Editar();
            echo $count;
        }
    }
   
    
    if($estabelecimento->Editar()==1 || $count>=1 ){
        // Verificar se quem está editando é admin e fazer o direcionamento:
        if($_SESSION['usuario']['id_nivel'] == 2){
            header('Location: ../../usuario.php?msg=10');
            exit;
        }else{
            header('Location: ../admin.php?msg=10');
        exit;
        }
        
    }else{
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