<?php
// Painel de administração
session_start();

// Somente o admin pode acessar essa pág:
if (($_SESSION['usuario']['id_nivel']) != 1) {
    // Devolver para tela de login:
    header('Location: login.php');
} else if (isset($_GET['id'])) {
    require_once('classes/Usuario.class.php');
    $usuario = new Usuario();
    $usuario->id = $_GET['id'];
    $tabela = $usuario->ListarUnico();

    $listar_tudo = $usuario->NivelUsuario();
}


?>


<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $tabela[0]['nome'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center p-5">
        <div class="col-6">
            <h1>Editar <?= $tabela[0]['nome'] ?></h1>
            <form id="formEdita" action="actions/editar_usuario.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control shadow" name="nome" value="<?= $tabela[0]['nome'] ?>">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Foto de Perfil</label>
                    <input class="form-control" type="file" name="foto_perfil">
                    <img src="../img/usuarios/<?= $tabela[0]['foto'] ?>" width="180px" alt="<?= $tabela[0]['nome'] ?>">
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
                <label for="addTag">Nível de Acesso</label>
                <select class="form-control" id="idNivel" name="id_niv">
                    <?php foreach ($listar_tudo as $nivel) { ?>
                        <option value="<?= $nivel['ID']; ?>"><?= $nivel['nome'] ?></option>
                    <?php } ?>
                </select>
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
                <input type="hidden" value="<?= $tabela[0]['ID'] ?>" name="id">
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="admin.php">Fechar</a>
                    <button type="submit" class="btn btn-primary shadow">Editar</button>
                </div>
            </form>
        </div>

    </div>



    <?php require_once('includes/notificacoes.incl.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>