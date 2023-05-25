<?php
session_start();

// Verificar se a sessão NÃO existe:
if (!isset($_SESSION['usuario'])) {
    // Devolver para tela de login:
    header('Location: admin/login.php');
} else if ($_SESSION['usuario']['id_nivel'] == 1) {
    header('location: admin/admin.php');
}

require_once('admin/classes/Cidade.class.php');
$cidade = new Cidade();
$tabela_cidade = $cidade->ListarTudo();

require_once('admin/classes/Categoria.estab.class.php');
$categoria_estab = new Categoria_Estabelecimento();
$tabela_categoria_estab = $categoria_estab->ListarTudo();

require_once('admin/classes/Usuario.class.php');
$usu = new Usuario();
$usu->id = $_SESSION['usuario']['ID'];
$tabela = $usu->ListarUnico();

require_once('admin/classes/Tag.class.php');
$tag = new Tag();
$tag->id_usuario = $_SESSION['usuario']['ID'];

$tags = $tag->ListarTags();
$todastags = $tag->ListarTudoTag();

require_once('admin/classes/Categoria.evento.class.php');
$categoria_evento = new Categoria_Evento();
$tabela_categoria_evento = $categoria_evento->ListarTudo();

require_once('admin/classes/Estabelecimento.class.php');
$estabelecimento = new Estabelecimento();
$estabelecimento->id_usuario = $_SESSION['usuario']['ID'];
$tabela_estab = $estabelecimento->Listar_especif();

require_once('admin/classes/Evento.class.php');

$evento = new Evento();

if (isset($_SESSION['estabelecimento']['id'])) {
    $evento->id_estabelecimento = $_SESSION['estabelecimento']['id'];
    $evento->id_usu_resp = $_SESSION['usuario']['ID'];
    $tabela_event = $evento->Listar_especif();
} else {
    // Caso o estabelecimento não exista, você pode lidar com essa situação de acordo com a lógica do seu código.
    // Por exemplo, exibir uma mensagem de erro ou redirecionar o usuário para uma página apropriada.
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="admin/style.css" rel="stylesheet">
    <title>Perfil</title>

</head>

<body>
    <div class="container">
        <?php require_once("navbar.php"); ?>
        <div class="row">
            <div class="col-md-3">
                <div class="row bg-dark mt-5 rounded">

                    <div class="col-12">
                        <h5 class="text-center m-3 text-white">Painel do Usuário</h5>
                        <div class="d-grid gap-4 p-3">

                            <!-- Botões dos modais -->
                            <!-- Editar Perfil -->
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#editaPerfil">Editar Perfil</button>
                            <?php if (count($tabela_estab) > 0) {       ?>
                                <!-- Meus eventos -->
                                <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#editaEvento">Meus eventos</button>
                            <?php } ?>
                            <!-- Tags -->
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#tags">Editar Tags</button>

                            <!-- Meus Estabelecimento -->
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#meusestab">Seus Estabelecimento</button>

                        </div>
                    </div>
                </div>

                <!-- Carousel -->
                <div class="row mt-3">
                    <div class="col">
                        <div id="carouselExampleIndicators" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="img/img2.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="img/img.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="img/img3.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteúdo Perfil -->
            <?php $c = count($tabela);
            if($c!=0) {   ?>
            <div class="col-md-9 text-center mt-5">
                <img class="img-fluid img150" src="img/usuarios/<?= $tabela[0]['foto'] ?>" style="border-radius: 50%;">
                <div class="row justify-content-center">

                    <div class="row">
                        <div class="col-12 mt-3">
                            <h4><?php echo $tabela[0]['nome']  ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <p><?php echo $tabela[0]['descricao'] ?></p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-12 p-2 mt-3">
                            <h5>
                                <?php foreach ($tags as $tag) {    ?>
                                    <span class="border">#<?= $tag['nome']; ?></span>
                                <?php }  ?>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 fs25 mt-3">
                            <i class="bi bi-facebook"></i>
                            <i class="bi bi-whatsapp"></i>
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-twitter"></i>
                        </div>
                    </div>
                </div>
            </div>
                                <?php }  ?>
        </div>

    </div>

    <!-- Rodapé -->
    <?php require_once("rodape.htm"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <?php require_once('admin/includes/notificacoes.incl.php'); ?>




    <!-- Modal Editar Perfil -->
    <div class="modal fade" id="editaPerfil" tabindex="-1" aria-labelledby="editarperfil" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Perfil</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEdita" action="admin/actions/editar_usuario.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control shadow" name="nome" value="<?= $tabela[0]['nome'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Foto de Perfil</label>
                            <input class="form-control" type="file" name="foto_perfil">
                            <label>Foto atual:</label>
                            <img src="img/usuarios/<?= $tabela[0]['foto'] ?>" width="180px" height="180px" alt="<?= $tabela[0]['nome'] ?>">
                            <input type="hidden" value="<?= $tabela[0]['foto'] ?>" name='foto_antiga'>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control shadow" aria-describedby="emailHelp" name="email" value="<?= $tabela[0]['email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Descrição</label>
                            <textarea class="form-control shadow" id="exampleFormControlTextarea1" rows="3" name="descricao"><?= $tabela[0]['descricao'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control shadow" name="senha">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Repita a Senha</label>
                            <input type="password" class="form-control shadow" name="confirmacao_senha">
                        </div>
                        <input type="hidden" value="<?= $tabela[0]['senha'] ?>" name="senha_antiga">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary shadow">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Meus Eventos -->
    <div class="modal fade" id="editaEvento" tabindex="-1" aria-labelledby="meuseventos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eventos:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Botão para abrir o segundo modal -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#RegistrarEvento">Registrar Novo Evento</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Seus Eventos</label>

                        <?php foreach ($tabela_event as $estab) { ?>
                            <div class="row">
                                <div class="col-4">
                                    <img src="img/eventos/<?php echo $estab['Imagem'] ?>" widht="40px" height="40px" alt="teste">
                                </div>
                                <div class="col-4">
                                    <input type="text" readonly class="form-control shadow" value="<?= $estab['Nome'] ?>" name="nome">
                                </div>
                                <div class="col-2 mt-1">
                                    <td><a href="admin/Editar_eventos_index.php?id=<?= $estab['id'] ?>">Editar</a></td>
                                </div>
                                <div class="col-2 mt-1">
                                <td><a href="admin/actions/apagar_evento.php?id=<?= $estab['id'] ?>">Excluir</a></td>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal do Registrar Evento  -->
    <div class="modal fade" id="RegistrarEvento" tabindex="-1" aria-labelledby="registrarevento" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Evento:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCadastra" action="admin/actions/cadastrar_evento.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nome do evento:</label>
                            <input type="text" class="form-control shadow" name="nome">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Foto principal do evento</label>
                            <input class="form-control" type="file" name="foto_evento_p">
                            <input type="hidden" value="<?= $tabela[0]['foto'] ?>" name='foto_antiga'>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Link:</label>
                            <input type="text" class="form-control shadow" aria-describedby="emailHelp" name="link">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Data:</label>
                            <input type="date" class="form-control shadow" name="data">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Descrição:</label>
                            <input type="text" class="form-control shadow" name="descricao">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="addTag">Categoria:</label>
                                <select class="form-control" id="addTag" name="categoria_evento">
                                    <?php foreach ($tabela_categoria_evento as $evento_cate) { ?>
                                        <option value="<?= $evento_cate['ID']; ?>"><?= $evento_cate['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="addTag">Estabelecimento:</label>
                                <select class="form-control" id="addTag" name="id_estabelecimento">
                                    <?php foreach ($tabela_estab as $estab) { ?>
                                        <option value="<?= $estab['id']; ?>"><?= $estab['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="categoriaProduto">Cidade:</label>
                                <select class="form-control" id="categoriaProduto" name="id_cidade">
                                    <?php foreach ($tabela_cidade as $cidade) { ?>
                                        <option value="<?= $cidade['id']; ?>"><?= $cidade['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary shadow">Criar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Estabelecimento-->
    <div class="modal fade" id="regirtraEstabelecimento" tabindex="-1" aria-labelledby="registrarestabelecimento" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar_estabelecimento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEstabelecimento" action="admin/actions/cadastrar_estabelecimento.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nome</label>
                            <input type="text" class="form-control shadow" name="nome">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control shadow" aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Foto principal do evento</label>
                            <input class="form-control" type="file" name="foto_estab_p">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="categoriaProduto">Cidades:</label>
                                <select class="form-control" id="categoriaProduto" name="id_cidade">
                                    <?php foreach ($tabela_cidade as $cidade) { ?>
                                        <option value="<?= $cidade['id']; ?>"><?= $cidade['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="categoriaProduto">Categoria do Estabelecimento:</label>
                                <select class="form-control" id="categoriaProduto" name="id_catego_estab">
                                    <?php foreach ($tabela_categoria_estab as $estab_cate) { ?>
                                        <option value="<?= $estab_cate['id']; ?>"><?= $estab_cate['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary shadow">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Meus Estabelecimentos -->
    <div class="modal fade" id="meusestab" tabindex="-1" aria-labelledby="meusestabelecimentos" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Estabelecimentos:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Botão para abrir o segundo modal -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <a class="btn btn-primary" type="button" data-bs-toggle="modal" href="#regirtraEstabelecimento">Novo Estabelecimento</a>
                            <!-- <a class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#regirtraEstabelecimento" data-dismiss="modal">Novo Estabelecimento</a> -->
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Seus Estabelecimentos</label>
                        <?php foreach ($tabela_estab as $estabb) { ?>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" readonly class="form-control shadow" value="<?= $estabb['nome'] ?>" name="nome">
                                </div>

                                <div class="col-2 mt-1">
                                    <td><a href="admin/Editar_estab_index.php?id=<?= $estabb['id'] ?>">Editar</a></td>
                                </div>
                                <div class="col-2 mt-1">
                                    <td><a href="admin/actions/apagar_estabelecimento.php?id=<?= $estabb['id'] ?>">Excluir</a></td>
                                </div>
                            </div>
                        <?php }  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal Tags -->
    <div class="modal fade" id="tags" tabindex="-1" aria-labelledby="modaltags" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edite suas tags:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTags" action="admin/actions/cadastrar_tag.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Suas Tags</label>
                            <?php foreach ($tags as $tag) { ?>
                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" class="form-control shadow" value="<?= $tag['nome'] ?>" name="nome">
                                    </div>

                                    <div class="col-2 mt-1">
                                        <td><a href="admin/actions/excluir_tag.php?id=<?= $tag['id_tag'] ?>">Excluir</a></td>
                                    </div>
                                </div>
                            <?php }  ?>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <div class="mb-3">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#modalAddTAG">Criar Nova Tag</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="addTag">Adicionar Tag</label>
                                <select class="form-control" id="addTag" name="id_tag">
                                    <?php foreach ($todastags as $all_tags) { ?>
                                        <option value="<?= $all_tags['id']; ?>"><?= $all_tags['nome']; ?></option>
                                    <?php } ?>
                                </select> <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary shadow">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Adicionar Tags -->
    <div class="modal fade" id="modalAddTAG" tabindex="-1" role="dialog" aria-labelledby="modalAddCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCategoriaLabel">Adicionar Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="admin/actions/adicionar_tag(bd).php" method="POST">
                        <div class="form-group">
                            <label for="nomeCategoria">Nome da Tag</label>
                            <input name="nome" type="text" class="form-control" id="nomeTag" placeholder="Digite o nome da tag">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
                </form>
            </div>
        </div>
    </div>




</body>
<script>
    function closeSecondModal() {
        $('#modal').modal({
            backdrop: false

        })

    }
</script>

</html>