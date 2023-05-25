<?php
require_once('admin/classes/Estabelecimento.class.php');
$estab = new Estabelecimento();
$tabelaa = $estab->ListarTudo();

$estab->id = $_GET['id'];
$estab_espec = $estab->Listar_view_especifico();

$imgCarousel = $estab->ListarTudo();


$j = 0;
$k = 0;
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
    <title>Estabelecimentos</title>
</head>

<body>
    <div class="container">
        <?php require_once("navbar.php"); ?>
            <div class="row bg-secondary-subtle">
                <div class="col-md">
                    <div class="row">
                        <div class="col-3 p-5 mx-auto">
                            <h6 class="mx-5">Estabelecimentos sugeridos:</h6>
                            <div id="carouselExample" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php foreach ($imgCarousel as $estabe) {  ?>
                                        <?php if ($j == 0) {    ?>
                                            <div class="carousel-item active" data-bs-interval="200">
                                            <?php
                                        } else { ?>
                                                <div class="carousel-item" data-bs-interval="200">
                                                <?php
                                            } ?>
                                                <?php $j = 1; ?>
                                                <a href="sobre_estab.php?id=<?php echo $estabe['id'] ?>"><img src="img/estabelecimentos/<?php echo $estabe['img'] ?>" class="d-block w-100" alt="..."></a>
                                                </div>
                                            <?php } ?>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <img class="img-fluid rounded mx-auto d-block mt-3" src="img/estabelecimentos/<?= $estab_espec[0]['img'] ?>" width="500px" alt="img_evento">
                            </div>
                            <div class="col-3">
                                        </div>
                        </div>
                        <div class="row">
                            <div class="col text-center mt-3">
                                <h3><?= $estab_espec[0]['nome'] ?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <p><?= $estab_espec[0]['cidade'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mx-auto mt-3 text-center pb-5">
                            <p><b><?= $estab_espec[0]['categoria'] ?><b>    </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once("rodape.htm"); ?>
    </div>

    <!-- Modal para exibir a imagem em tela cheia -->
    <div class="modal fade" id="modalimg" tabindex="-1" role="dialog" aria-labelledby="modalImagem1Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <?php foreach ($imagens as $img) { ?>
                        <a href="img/estabelecimentos/<?php echo $estab_espec[0]['img'] ?>" data-lightbox="roadtrip"><img src="<?php echo $estab_espec[0]['img'] ?>" class="example-image" alt="<?php echo $img['img'] ?>"></a>
                    <?php   } ?>


                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script>
            const modalimg = document.getElementById('modalimg')
            if (modalimg) {
                modalimg.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const recipient = button.getAttribute('data-bs-imagem')
                    // If necessary, you could initiate an Ajax request here
                    // and then do the updating in a callback.

                    const imagemmodal = modalimg.querySelector("#imgmodal");
                    imgmodal.src = recipient;
                })
            }
        </script>
</body>


</html>