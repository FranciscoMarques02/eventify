<?php
session_start();

// Verificar se é o usuário admin:
if ($_SESSION['usuario']['id_nivel'] != 1) {
    // Devolver para tela de login:
    header('Location: login.php');
}
require_once('classes/Cidade.class.php');
$cidade = new Cidade();
$tabela_cidade = $cidade->ListarTudo();

require_once('classes/Categoria.estab.class.php');
$categoria = new Categoria_Estabelecimento();
$tabela_categoria = $categoria->ListarTudo();

require_once('classes/Usuario.class.php');
$usu = new Usuario();
$usu->id = $_SESSION['usuario']['ID'];
$tabela = $usu->ListarUnico();

require_once('classes/Tag.class.php');
$tag = new Tag();
$tag->id_usuario = $_SESSION['usuario']['ID'];

$tags = $tag->ListarTags();
$todastags = $tag->ListarTudoTag();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="style.css" rel="stylesheet">
    <title>Perfil</title>

</head>

<body>
    <div class="container">
    <?php require_once ("../navbar.php") ; ?>

        <div class="row">
            <div class="col-md-3">
                <div class="row mt-5 rounded">

                    <div class="col-12">
                        <h5 class="text-center m-3 text-black">Painel do Admin</h5>
                        <!-- Editar Perfil -->
                        <div class="d-grid gap-4 p-3">
                            <!-- Botões painel de gerenciamento -->
                            <a class="btn btn-outline-light" type="button" href="gerenciar_usuarios.php">Gerenciar Usuarios</a>
                            <a class="btn btn-outline-light" type="button" href="gerenciar_eventos.php">Gerenciar Eventos</a>    
                            <a class="btn btn-outline-light" type="button" href="gerenciar_estabelecimentos.php">Gerenciar Estabelecimento</a>
                            <button class="btn btn-outline-light" type="button" data-bs-toggle="modal" data-bs-target="#comunicacao">Comunicação do Site</button>
                            <!-- Modal comunicação site -->
                            <div class="modal fade" id="comunicacao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Comunicação do Site</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formEdita" action="actions/editar_usuario.php" method="POST">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Notificação</label>
                                                    <textarea class="form-control shadow" id="exampleFormControlTextarea1" rows="3" name="descricao"></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Notificar na pagina Principal</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Notificar todos Usuarios</button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                    <button type="submit" class="btn btn-primary shadow">Editar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <img src="../img/img2.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="../img/img.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="../img/img3.jpg" class="d-block w-100" alt="...">
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
                        <div class="row">
                            <div class="col-12 mt-3 text-center">
                                <button type="button" class="btn btn-outline-secondary">Compartilhar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Conteúdo Perfil -->
            <div class="col-md-9 text-center mt-5">
                <img class="img-fluid img150" src="../img/usuarios/admin.png">
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
                                    <span class="border"><?= $tag['nome']; ?></span>
                                <?php }  ?>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="Digite seu comentário" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <button type="button" class="btn btn-outline-secondary">Ler comentários</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Rodapé -->
    <?php require_once ("../rodape.htm") ; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <?php require_once('includes/notificacoes.incl.php'); ?>
</body>

</html>