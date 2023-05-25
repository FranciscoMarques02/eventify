<?php
$caminho = explode("/", dirname($_SERVER['PHP_SELF']));
$caminho = $caminho[count($caminho)-1];

$caminho = $caminho == "admin" ? "../" : "";

?>
<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<div class="row mt-4 d-flex justify-content-between">
            <div class="col-sm-2 text-center">
                <a href="<?=$caminho ?>index.php"><img class=" w-md-100 img-fluid" src="<?=$caminho ?>img/logo.png"></a>
            </div>
            <div class="col-sm-2 d-flex justify-content-center mt-5 align-items-center text-center">
                <a href="<?=$caminho ?>usuario.php"><img class="img50" src="<?=$caminho ?>img/login.png"></a>
                <?php if (isset( $_SESSION['usuario'])){ ?>
                <a class="btn btn-danger mx-1 text-white" href="<?=$caminho ?>admin/sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
                <?php   } ?>
            </div>
        </div>

<div class="row bg-dark mt-3">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar" data-bs-theme="dark">
            <div class="container-fluid">                      
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" href="<?=$caminho ?>index.php">Inicio</a>
                    <a class="nav-link" href="<?=$caminho ?>estabelecimentos.php">Estabelecimentos</a>
                    <a class="nav-link" href="<?=$caminho ?>eventos.php">Eventos</a>
                    <a class="nav-link" href="<?=$caminho ?>sobrenos.php">Sobre nós</a>
                    <a class="nav-link" href="<?=$caminho ?>contato.php">Contato</a>                                       
                </ul>                
              </div>
            </div>
          </nav>
    </div>
</div>