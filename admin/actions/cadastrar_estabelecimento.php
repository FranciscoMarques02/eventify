<?php 
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])){
    require_once('../classes/Estabelecimento.class.php');
    $estabelecimento = new Estabelecimento();
    if(!empty($_POST['nome'])){
    $estabelecimento->nome = $_POST['nome'];
    }
    else{
        header('Location: ../../usuario.php?err=11');
        exit;
    }
    if(!empty($_POST['email'])){
        $estabelecimento->email = $_POST['email'];
    }
    else{
        header('Location: ../../usuario.php?err=12');
        exit;
    }
   
    $estabelecimento->id_catego_estab = $_POST['id_catego_estab'];
    $estabelecimento->id_cidade = $_POST['id_cidade'];
    $estabelecimento->id_usuario = $_SESSION['usuario']['ID'];
    require_once('../classes/Redes_sociais.php');


  // Verificar se uma foto foi upada:
    if (is_uploaded_file($_FILES['foto_estab_p']['tmp_name'])) {
        $extensao = pathinfo($_FILES['foto_estab_p']['name'], PATHINFO_EXTENSION);
        // Atribuir hash.extensão no nome da img:
        $novo_nome = hash_file('sha256', $_FILES['foto_estab_p']['tmp_name']);
        $novo_nome = $novo_nome.".".$extensao;
    
        // Se usuario não mandar foto, txt "semfoto.jpg" é cadastrado:
        if(move_uploaded_file($_FILES['foto_estab_p']['tmp_name'], "../../img/estabelecimentos/" . $novo_nome)){
            $estabelecimento->img = $novo_nome;
        }}else{
            $estabelecimento->img = "semfoto.jpg";
        }  


    if($estabelecimento->Cadastrar() == 1){
        header('Location: ../../usuario.php?msg=1');
        
    }else{
        header('Location: ../../usuario.php?err=1');
        
    }
    $resultado2 = $estabelecimento->Listar_especif();
  
    $contador = count($_POST['rede']);
    
    if(!empty($_POST['rede'])){
        for($i=0;$i<$contador;$i++){
            $rede = new rede_social();
            $rede->id_estabelecimento=$resultado2[0]['id'];
            print_r($_POST['rede']);
            $rede->link_rede=$_POST['rede'][$i];
            $rede->id_rede = $i;
            $rede->Cadastrar();
            }
    }
    if(count($resultado2) >=1){
        $_SESSION['estabelecimento'] = $resultado2[0];
        
    }
}
?>