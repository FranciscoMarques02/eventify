<?php
require_once('admin/classes/Estabelecimento.class.php');
$estabelecimento = new Estabelecimento();
$tabela = $estabelecimento->ListarTudo();

// Páginação:
// Numero total de registros no banco de dados 
$totalRegistros = $estabelecimento->ObterQtdRegistro()[0]['qtd'];
// Numero de registros exibidos por pagina 
$registrosPorPagina = 7;
// Calcula o numero total de paginas 
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);
// Obtem o numero da pagina atual 
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
// Calcula o indice do primeiro registro da pagina atual 
$primeiroRegistro = ($paginaAtual - 1) * $registrosPorPagina;

$estabelecimento->inicio = $primeiroRegistro;
$estabelecimento->maximo = $registrosPorPagina;

$tabela = $estabelecimento->ListarPag();


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
        <div class="row mt-4">
            <div class="col-md-2">
                <h4>Filtrar </h4>
            </div>
            <div class="col-md-4 d-flex">
                <form class="d-flex" role="search" action="pesquisa.php" method="get">
                    <input name="q" class="form-control me-2" type="text" placeholder="Procurar" aria-label="Search">
                    <input type="hidden" name="tipo" value="estabelecimento">
                    <button class="btn btn-dark" type="submit" id="button-addon2">
                        <i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
        <?php foreach ($tabela as $estab) {   ?>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img class="img-fluid" src="img/estabelecimentos/<?php echo $estab['img']?>" alt="<?php echo $estab['img']?>">
                </div>
                <div class="col-5">
                    <h3><?php echo $estab['nome'];   ?></h3>
                    <p><?php echo $estab['categoria'] ?></p>
                    
                    <a href="sobre_estab.php?id=<?= $estab['id'] ?>" class="btn btn-dark">Sobre</a>
                </div>
            </div>
        <?php  }    ?>
        <!-- Paginação -->
        <div class="row mt-3 ">
             <div class="col ">
             <nav aria-label="navegação">
                <ul class="pagination justify-content-center">
               <?php if ($paginaAtual > 1) { ?>
                    <li class="page-item">
                    <a class="page-link" href="estabelecimentos.php?pagina=<?=$paginaAtual - 1;?>">Anterior</a>
                    </li>
                    <?php } ?>
                    <?php if ($paginaAtual == 1) { ?>
                    <li class="page-item disabled">
                    <a class="page-link" href="estabelecimentos.php?pagina=<?=$paginaAtual - 1;?>">Anterior</a>
                    </li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                    <li class="page-item <?=$paginaAtual == $i ? 'active' : 'abcde';  ?>"><a class="page-link" href="estabelecimentos.php?pagina=<?=$i;?>"><?=$i;?></a></li>
                    <?php } ?>
                    <!-- <li class="page-item active" aria-current="page"> -->
                   
                    <?php if ($paginaAtual < $totalPaginas) { ?>
                    <li class="page-item">
                    <a class="page-link" href="estabelecimentos.php?pagina=<?=$paginaAtual +1;?>">Próxima</a>
                    </li>
                    <?php } ?>
                    <?php if ($paginaAtual == $totalPaginas) { ?>
                    <li class="page-item disabled">
                    <a class="page-link" href="#>">Próxima</a>
                    </li>
                    <?php } ?>
                </ul>
                </nav>
            </div>
        </div>

    </div>
    <?php require_once("rodape.htm"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>