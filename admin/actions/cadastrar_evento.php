<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../classes/Evento.class.php');
    $evento = new Evento();
    if(!empty($_POST['nome'])){
    $evento->nome_evento = $_POST['nome'];
    }
    else{
        header('Location: ../../usuario.php?err=11');
        exit;
    }
    if(!empty($_POST['link'])){
    $evento->link = $_POST['link'];
    }
    else{
        header('Location: ../../usuario.php?err=13');
        exit;
    }
    $data_atual = new DateTime();
    if(!empty($_POST['data'])){
        if($_POST['data']<$data_atual){
            $evento->data_evento = $_POST['data'];
          
        }
        else{
            header('Location: ../../usuario.php?err=17');
            exit;
        }
    }
    else{
        header('Location: ../../usuario.php?err=14');
        exit;
    }
  
   
    if(!empty($_POST['categoria_evento'])){
        $evento->id_categoria=$_POST['categoria_evento'];
    }
    else{
        header('Location: ../../usuario.php?err=15');
        exit;
    }
   
    $evento->id_estabelecimento=$_POST['id_estabelecimento'];
    $evento->id_cidade_evento = $_POST['id_cidade'];
    $evento->id_usu_resp = $_SESSION['usuario']['ID'];
    $evento->descricao_evento = $_POST['descricao'];

    // Verificar se uma foto foi upada:
        if (is_uploaded_file($_FILES['foto_evento_p']['tmp_name'])) {
            $extensao = pathinfo($_FILES['foto_evento_p']['name'], PATHINFO_EXTENSION);
            // Atribuir hash.extensão no nome da img:
            $novo_nome = hash_file('sha256', $_FILES['foto_evento_p']['tmp_name']);
            $novo_nome = $novo_nome.".".$extensao;
        
            // Se usuario não mandar foto, txt "semfoto.jpg" é cadastrado:
            if(move_uploaded_file($_FILES['foto_evento_p']['tmp_name'], "../../img/eventos/" . $novo_nome)){
                $evento->foto = $novo_nome;
            }}else{
                $evento->foto = "semfoto.jpg";
            }  
     
    
    }
    try{
        $evento->Cadastrar();
        header('Location: ../../usuario.php?msg=0');
        exit;
     
    }catch(PDOException $e){
        header('Location: ../../usuario.php?err=1');
        echo $e->getMessage();
        exit;
    }

?>