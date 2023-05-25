<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link href="admin/style.css" rel="stylesheet">
    <title>Sobre nós</title>
</head>

<body>
    <div class="container">
        <?php require_once ("navbar.php") ; ?>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <img src="img/qs.png" class="img-fluid mt-5" alt="Eventfy.QuemSomos" width="1000px">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1>
                    Sobre Eventfy
                </h1>
                <p>
                    O Eventfy foi criado por uma equipe do técnico em informática - T6.
                    Criamos um site que seja uma fonte confiável e completa de informações sobre todos os eventos que acontecem na cidade. 
                    Percebemos que muitas vezes as informações sobre eventos em Pindamonhagaba são dispersas em diferentes plataformas e 
                    não são facilmente acessíveis. Então decidimos criar um site que reunisse todas essas informações em um só lugar.
</p>
            </div>
        </div>
        <div class="container">
            <div class="row ">
                <div class="col-md">
                    <h1>Integrantes</h1>
                    <div class="row mt-5 d-flex justify-content-beteween">
                        <div class="col-2">
                            <div class="card">
                                <a href="#"><img class="img-thumbnail" src="img/conta.png" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Andressa Gomes</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <a href="#"><img class="img-thumbnail" src="img/conta.png" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Brunno Leal</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <a href="https://github.com/FranciscoMarques02" target="_blank"><img class="img-thumbnail" src="img/membros/fotofrancisco.png" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Francisco Lima</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <a href="#"><img class="img-thumbnail" src="img/membros/fotogabriel.png" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Gabriel Silva</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <a href="#"><img class="img-thumbnail" src="img/membros/fotobryan.jpg" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Bryan Silva</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="card">
                                <a href="#"><img class="img-thumbnail" src="img/membros/nicolas-cage.jpg" alt="Imagem"></a>
                                <div class="card-body">
                                    <h4 class="card-title">Ryan Dantas</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php require_once ("rodape.htm") ; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>