<?php

if($_GET['tipo'] == "estabelecimento")
{
    require_once('admin/classes/Estabelecimento.class.php');
    $estabelecimento = new Estabelecimento();
    $estabelecimento->nome = $_GET['q'];
    $tabela_estab = $estabelecimento->Pesquisar();
}

if($_GET['tipo'] == "evento")
{
    require_once('admin/classes/Evento.class.php');
    $evento = new Evento();
    $evento->nome_evento = $_GET['q'];
    $tabela_evento = $evento->Pesquisar();
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
    <title>Resultados da pesquisa</title>
</head>

<body>
    <div class="container">
        <?php require_once("navbar.php"); ?>

        <div class="row mt-4">
            <div class="col-md-4">
                <h4>Resultados da pesquisa...</h4>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-center">
                <form class="d-flex" role="search">
                    <input name="q" class="form-control me-2" type="search" placeholder="Digite a categoria..." aria-label="Search">
                    <input type="hidden" name="tipo" value="<?=$_GET['tipo']?>">
                    <button class="btn btn-dark" type="button" id="button-addon2">
                        Filtrar</button>
                </form>
            </div>
        </div>
        <?php if($_GET['tipo'] == "estabelecimento") { ?>
            <?php if(count($tabela_estab) >= 1)  { ?>
        <?php foreach ($tabela_estab as $estab) { ?>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img class="img-fluid" src="img/estabelecimentos/<?=$estab['img']?>" alt="img.do.estabelecimento">
                </div>
                <div class="col-5">
                    <h3><?php echo $estab['nome']?></h3>
                    <p><?php echo $estab['categoria']?></p>
                    <a href="sobre_estab.php?id=<?= $estab['id'] ?>" class="btn btn-dark">Sobre</a>
                </div>
            </div>
        <?php } ?>
        <?php } else {?>
        <h3>Nenhum resultado encontrado.</h3>
        <?php } ?>
        <?php } ?>

        <?php if($_GET['tipo'] == "evento") { ?>
            <?php if(count($tabela_evento) >= 1)  { ?>
        <?php foreach ($tabela_evento as $evento) { ?>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img class="img-fluid" src="img/eventos/<?=$evento['Imagem']?>" alt="img.do.estabelecimento">
                </div>
                <div class="col-5">
                    <h3><?php echo $evento['Nome']?></h3>
                    <p><?php echo $evento['Categoria']?></p>
                    <a href="sobre_evento.php?id=<?= $evento['id'] ?>" class="btn btn-dark">Sobre</a>
                </div>
            </div>
        <?php } ?>
        <?php } else {?>
        <h3>Nenhum resultado encontrado.</h3>
        <?php } ?>
        <?php } ?>
    </div>
    <?php require_once("rodape.htm"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>