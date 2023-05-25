<?php

session_start();

// Verificar se a página está sendo carregada por POST:
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario'])) {

    require_once('../classes/Evento.class.php');

    $evento = new Evento();
    $evento->nome_evento = $_POST['nome'];
    $evento->link = $_POST['link'];
    $evento->descricao_evento = $_POST['descricao'];
    $evento->data_evento = $_POST['data'];
    $evento->id_categoria = $_POST['categoria_evento'];
    $evento->id_estabelecimento = $_POST['id_estabelecimento'];
    $evento->id_cidade_evento = $_POST['id_cidade'];
    $evento->id = $_POST['id_evento'];
    $evento->id_img = $_POST['id_img'];

    if($_SESSION['usuario']['id_nivel'] == 2){
        $evento->id_usu_resp = $_SESSION['usuario']['ID'];
    }else{
        $evento->id_usu_resp = $_POST['id_usu'];
    }


    // Verificar se uma foto foi upada:
    if (is_uploaded_file($_FILES['foto_evento_p']['tmp_name'])) {
        $extensao = pathinfo($_FILES['foto_evento_p']['name'], PATHINFO_EXTENSION);
        // Atribuir hash.extensão no nome da img:
        $novo_nome = hash_file('sha256', $_FILES['foto_evento_p']['tmp_name']);
        $novo_nome = $novo_nome . "." . $extensao;

        // Se usuario não mandar foto, txt "semfoto.jpg" é cadastrado:
        if (move_uploaded_file($_FILES['foto_evento_p']['tmp_name'], "../../img/eventos/" . $novo_nome)) {
            $evento->foto = $novo_nome;
        }
    } else {
        $evento->foto = $_POST['foto_antiga'];
    }





    $contarArquivo = count($_FILES['fotos_outras']['name']);
    // print_r($_FILES['fotos_outras']['name']);
    if (!empty($_FILES['fotos_outras']['name'][0])) {
        for ($i = 0; $i < $contarArquivo; $i++) {
            $filename = $_FILES['fotos_outras']['name'][$i];

            ## Location
            $novonome = hash_file('sha256', $_FILES['fotos_outras']['tmp_name'][$i]);
            $location = "../../img/eventos/" . $novonome;
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $extension = strtolower($extension);

            ## File upload allowed extensions
            $valid_extensions = array("jpg", "jpeg", "png", "pdf", "docx");

            $response = 0;
            ## Check file extension
            if (in_array(strtolower($extension), $valid_extensions)) {
                ## Upload file

                $novonome = hash_file('sha256', $_FILES['fotos_outras']['tmp_name'][$i]) . '.' . $extension;
                $location = "../../img/eventos/" . $novonome;
                move_uploaded_file($_FILES['fotos_outras']['tmp_name'][$i], $location);
                $evento->id = $_POST['id_evento'];
                $evento->foto2 = $novonome;

                try {
                    $evento->Inserir_imagem_0();
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit;
                }
            }
        }
    }


    try {
        $evento->Editar();
        // Verificar se é o admin
        if ($_SESSION['usuario']['id_nivel'] == 2) {
            header('Location: ../../usuario.php?msg=8');
            exit;
        } else {
            header('Location: ../admin.php?msg=8');
            exit;
        }
    } catch (Exception $e) {
        if ($_SESSION['usuario']['id_nivel'] == 2) {
            header('Location: ../../usuario.php?err=8');
            exit;
        } else {
            header('Location: ../admin.php?err=8');
            exit;
        }
    }
}
