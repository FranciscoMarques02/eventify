<!DOCTYPE html>
<html lang="en">

<?php

require_once('admin/classes/Evento.class.php');
$evento = new Evento();
$tabela_eventos = $evento->ListarTudo();
$eventos_recentes = $evento->ListarEventos();
$eventos_anteriores = $evento->ListarEventosAnteriores();

$tabela = $evento->Listar_especif2();

$i = 0;

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="admin/style.css" rel="stylesheet">
    <title>Página Inicial</title>
</head>

<body>
    <div class="container">
        <?php require_once("navbar.php"); ?>
        <div class="row mt-4">
            <div class="col-12">
                <div id="carouselExampleIndicators" class="carousel slide">
                <div class="carousel-indicators">
                    <?php $c = count($tabela);
                    $e = 0;
                    $j=0;
                    
                    for ($i = 0; $i < $c; $i++) {     ?>
                       
                            <?php if ($e == 0) {     ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <?php } else { ?>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i; ?>"></button>
                            <?php }
                            $e = 1; ?>
                       
                    <?php  }  ?>
                            </div>
                    <div class="carousel-inner" style="    max-height: 430px;">
                        <?php foreach ($tabela as $evento) {  ?>
                            <?php if ($j == 0) {    ?>
                                <div class="carousel-item active">
                                <?php
                            } else { ?>
                                    <div class="carousel-item ">
                                    <?php
                                } ?>
                                    <?php $j = 1; ?>
                                    <a href="sobre_evento.php?id=<?php echo $evento['id'] ?>"><img src="img/eventos/<?php echo $evento['Imagem'] ?>" class="d-block w-100" alt="..."></a>
                                    </div>
                                    <?php } ?>
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
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="row me-3 bg-dark rounded">
                    <div class="col-12 text-white p-2 ">
                        Próximos eventos
                    </div>
                </div>
                <?php foreach ($eventos_recentes as $evento) { ?>
                    <div class="row mt-5">
                        <div class="col-3">
                        <a href="sobre_evento.php?id=<?= $evento['id'] ?>">
                             <img class="img-fluid" src="img/eventos/<?= $evento['Imagem'] ?>">
                        </a>
                        </div>
                        <div class="col-9 mt-3">
                            <h5><a href="sobre_evento.php?id=<?= $evento['id'] ?>"><?= $evento['Nome'] ?></a></h5>
                            <p><?= date("d/m/Y",strtotime($evento['data_evento'])) ?></p>
                            <p><?php echo mb_strimwidth($evento["descricao_evento"], 0, 50, "...") ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="row mt-5 mb-3">
                    <div class="col">
                        <div class="d-grid gap-2">
                            <a class="btn btn-dark" href="eventos.php">Mais eventos >></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row bg-dark rounded">
                    <div class="col-12 text-white p-2">
                        Eventos anteriores
                    </div>
                </div>
                <?php foreach ($eventos_anteriores as $evento) { ?>
                    <div class="row">
                        <div class="col-12 text-center mt-2">
                        <a href="sobre_evento.php?id=<?= $evento['id'] ?>">
                            <img class="img-fluid w-50" src="img/eventos/<?= $evento['Imagem'] ?>">
                </a>
                            <h5 class="mt-2"><?= $evento['Nome'] ?></h5>
                            <p><?= date("d/m/Y",strtotime($evento['data_evento'])) ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>


    </div>
    <?php require_once("rodape.htm"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // normalizar o tamanho do carousel:
       function normalizeSlideHeights() {
    $('.carousel').each(function(){
      var items = $('.carousel-item', this);
      // reset the height
      items.css('min-height', 0);
      // set the height
      var maxHeight = Math.max.apply(null, 
          items.map(function(){
              return $(this).outerHeight()}).get() );
      items.css('min-height', maxHeight + 'px');
    })
}

$(window).on(
    'load resize orientationchange', 
    normalizeSlideHeights);
    </script>
</body>

</html>