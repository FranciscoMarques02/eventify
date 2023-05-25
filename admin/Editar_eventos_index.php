<?php
// Painel de administração
session_start();

require_once('classes/Evento.class.php');
$evento = new Evento();
$evento->id = $_GET['id'];
$tabela = $evento->Listar_especif3();

// Verificar usuário logado é o responsável do evento
if ($_SESSION['usuario']['ID'] != $tabela[0]['id_usu_resp']) {
    // Verificar se é admin
    if ($_SESSION['usuario']['id_nivel'] != 1) {
        // Devolver para tela de login:
        header('Location: ../usuario.php?err=3');
    }
}

$tabela_imagens = $evento->Listar_Imagens();


require_once('classes/Categoria.evento.class.php');
$catego_event = new Categoria_Evento();
$tabela_categoria_evento = $catego_event->ListarTudo();

require_once('classes/Estabelecimento.class.php');
$estabelecimento = new Estabelecimento();

if($_SESSION['usuario']['id_nivel'] == 2){
    $estabelecimento->id_usuario = $_SESSION['usuario']['ID'];
}else{
    $estabelecimento->id_usuario = $tabela[0]['id_usu_resp'];
}

$tabela_estab = $estabelecimento->Listar_especif();


require_once('classes/Cidade.class.php');
$cidades = new Cidade();
$tabela_cidade = $cidades->ListarTudo();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gerenciamento de Eventos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row mb-3">
            <div class="col d-flex justify-content-start">
                <p>Seja bem-vindo, <?= $_SESSION['usuario']['nome']; ?>.</p>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-secondary mx-1 text-white" href="../usuario.php"> Voltar</a>
                <a class="btn btn-danger mx-1 text-white" href="sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Evento:</h1>
        <form id="formEdita" action="actions/editar_evento.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label d-flex justify-content-start">Nome do evento:</label>
                <input type="text" class="form-control shadow" name="nome" value="<?= $tabela[0]['Nome'] ?>">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label d-flex justify-content-start">Foto principal do evento</label>
                <input class="form-control" type="file" name="foto_evento_p">
                <img class="mt-3 align-start" src="../img/eventos/<?= $tabela[0]['Imagem'] ?>" width="180px" alt="<?= $tabela[0]['Imagem'] ?>">
                <input type="hidden" value="<?= $tabela[0]['Imagem'] ?>" name='foto_antiga'>
            </div>
            <div class="mb-3">
                <label for="fotos_outras" class="form-label d-flex justify-content-start">Outras Fotos</label>
                <input class="form-control" type="file" multiple name="fotos_outras[]">

                <div class="mt-3 row">
                    <?php foreach ($tabela_imagens as $tabelaaa) { ?>
                        <div class="col">
                            <div class="container_img">
                                <img class=" img_evento" src="../img/eventos/<?= $tabelaaa['img'] ?>" width="80px" height="80px">
                                <div class="overlay">
                                    <div class="textinho"><a href="actions/apagar_imagem_outras.php?id_evento=<?php echo $tabela[0]['id'] ?>&id_img=<?php echo $tabelaaa['id'] ?>">Remover</a></div>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                </div>
                <input type='hidden' value="<?= $_GET['id'] ?>" name="id_evento">
            </div>

            <div class=" mb-3">
                <input class="form-control" type="hidden" value="<?php echo $tabela[0]['id'] ?>" name="id_evento">
            </div>
            <div class="mb-3">
                <input class="form-control" type="hidden" value="<?php echo $tabela[0]['id_img'] ?>" name="id_img">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label d-flex justify-content-start">Link:</label>
                <input type="text" class="form-control shadow" aria-describedby="emailHelp" value="<?php echo $tabela[0]['link'] ?>" name="link">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-flex justify-content-start">Data:</label>
                <input type="date" class="form-control shadow" name="data" value="<?php echo $tabela[0]['data_evento'] ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-flex justify-content-start">Descrição:</label>
                <input type="text" class="form-control shadow" name="descricao" value="<?php echo $tabela[0]['descricao_evento'] ?>">
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="addTag" class="d-flex justify-content-start">Categoria:</label>
                    <select class="form-control" id="addTag" name="categoria_evento">
                        <?php foreach ($tabela_categoria_evento as $evento_cate) { ?>
                            <option value="<?= $evento_cate['ID']; ?>"><?= $evento_cate['nome']; ?></option>
                        <?php } ?>
                    </select> <br>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-group">
                    <label for="addTag" class="d-flex justify-content-start">Estabelecimento:</label>
                    <select class="form-control" id="addTag" name="id_estabelecimento">
                        <?php foreach ($tabela_estab as $estab) {
                            if ($tabela[0]['id_estab'] == $estab['id']) { ?>
                                <option value="<?= $estab['id']; ?>" selected><?= $estab['nome']; ?></option>
                            <?php } else { ?>
                                <option value="<?= $estab['id']; ?>"><?= $estab['nome']; ?></option>
                        <?php }
                        } ?>
                    </select> <br>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-group">
                    <label for="categoriaProduto" class="d-flex justify-content-start">Cidades:</label>
                    <select class="form-control" id="categoriaProduto" name="id_cidade">
                        <?php foreach ($tabela_cidade as $cidade) {
                            if ($tabela[0]['Cidade'] == $cidade['nome']) { ?>
                                <option value="<?= $cidade['id']; ?>" selected><?= $cidade['nome']; ?></option>
                            <?php } else { ?>
                                <option value="<?= $cidade['id']; ?>"><?= $cidade['nome']; ?></option>
                            <?php }  ?>
                        <?php } ?>
                    </select> <br>
                    <!-- Input hidden com id do usuario -->
                    <input type="hidden" value="<?= $tabela[0]['id_usu_resp'] ?>" name="id_usu">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary shadow">Editar</button>
            </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <?php require_once('includes/notificacoes.incl.php'); ?>
</body>

</html>