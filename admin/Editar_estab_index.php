<?php
// Painel de administração
session_start();

require_once('classes/Estabelecimento.class.php');
$estabelecimento = new Estabelecimento();
$estabelecimento->id = $_GET['id'];
$tabela_estab = $estabelecimento->Listar_view_especifico();

// Verificar se a sessão NÃO existe:
if ($_SESSION['usuario']['ID'] != $tabela_estab[0]['id_usuario']) {
    // Verificar se é admin
    if ($_SESSION['usuario']['id_nivel'] != 1) {
        // Devolver para tela de login:
        header('Location: ../usuario.php?err=3');
    }
}

require_once('classes/Categoria.estab.class.php');
$catego_event = new Categoria_Estabelecimento();
$tabela_categoria_evento = $catego_event->ListarTudo();

require_once('classes/Redes_sociais.php');
$rede = new rede_social();
$rede->id_estabelecimento = $_GET['id'];
$tabela_rede_social = $rede->ListarTudo();

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
    <title>Gerenciamento de Estabelecimentos</title>
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
                <p>Seja bem-vindo,<?= $_SESSION['usuario']['nome']; ?>.</p>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-secondary mx-1 text-white" href="../usuario.php"> Voltar</a>
                <a class="btn btn-danger mx-1 text-white" href="sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>

        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Estabelecimento:</h1>

        <form id="formEdita" action="actions/editar_estab.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label d-flex justify-content-start">Nome:</label>
                <input type="text" class="form-control shadow" name="nome" value="<?= $tabela_estab[0]['nome'] ?>">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label d-flex justify-content-start">Email:</label>
                <input type="text" class="form-control shadow" name="email" value="<?= $tabela_estab[0]['email'] ?>">
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label d-flex justify-content-start">Foto principal do Estabelecimento</label>
                <input class="form-control" type="file" name="foto_estab_p">
                <img class="mt-3 align-start" src="../img/estabelecimentos/<?= $tabela_estab[0]['img'] ?>" width="180px" alt="<?= $tabela_estab[0]['img'] ?>">
                <input type="hidden" value="<?= $tabela_estab[0]['img'] ?>" name='foto_antiga'>
            </div>

            <div>
                <div class="form-group">
                    <label for="categoriaProduto" class="d-flex justify-content-start">Cidades:</label>
                    <select class="form-control" id="categoriaProduto" name="id_cidade">
                        <?php foreach ($tabela_cidade as $cidade) {
                            if ($tabela_estab[0]['cidade'] == $cidade['nome']) { ?>
                                <option value="<?= $cidade['id']; ?>" selected><?= $cidade['nome']; ?></option>
                            <?php } else { ?>
                                <option value="<?= $cidade['id']; ?>"><?= $cidade['nome']; ?></option>
                            <?php }  ?>
                        <?php } ?>
                    </select> <br>
                </div>
            </div>
            <input type="hidden" name="id_usuario_veri" value="<?= $tabela_estab[0]['id_usuario'] ?>">
            <div>
                <div class="form-group">
                    <label for="addTag" class="d-flex justify-content-start">Categoria do Estabelecimento:</label>
                    <select class="form-control" id="addTag" name="categoria_estab">
                        <?php foreach ($tabela_categoria_evento as $evento_cate) { ?>
                            <option value="<?= $evento_cate['id']; ?>"><?= $evento_cate['nome']; ?></option>
                        <?php } ?>
                    </select> <br>
                </div>
                <!-- Input invisível com id do usuario -->
                <input type="hidden" value="<?= $tabela_estab[0]['id_usuario'] ?>" name="id_usuario">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-flex justify-content-start">Instagram:</label>
                <?php if (isset($tabela_rede_social[0]['link_rede'])) { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="<?= $tabela_rede_social[0]['link_rede']; ?>">
                <?php } else { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="">
                <?php } ?>
                <input type="hidden" class="form-control shadow" name="rede_id[]" value="
                <?php
                echo $tabela_rede_social[0]['id'];
                ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-flex justify-content-start">Twitter:</label>
                <?php if (isset($tabela_rede_social[1]['link_rede'])) { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="<?= $tabela_rede_social[1]['link_rede']; ?>">
                <?php } else { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="">
                <?php } ?>
                <input type="hidden" class="form-control shadow" name="rede_id[]" value="
                <?php
                echo $tabela_rede_social[1]['id'];
                ?>">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label d-flex justify-content-start">Facebook:</label>
                <?php if (isset($tabela_rede_social[2]['link_rede'])) { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="<?= $tabela_rede_social[2]['link_rede']; ?>">
                <?php } else { ?>
                    <input type="text" class="form-control shadow" name="rede[]" value="">
                <?php } ?>
                <input type="hidden" class="form-control shadow" name="rede_id[]" value="
                <?php
                echo $tabela_rede_social[2]['id'];
                ?>">
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