<?php
// Painel de administração
session_start();

// Verificar se é o admin:
if ($_SESSION['usuario']['id_nivel'] != 1) {
    // Devolver para tela de login:
    header('Location: login.php');
}

require_once('classes/Usuario.class.php');
$usuario = new Usuario();
$tabela = $usuario->ListarUsuarios();

$usuario_editado = $usuario->ListarUnico();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gerenciamento de Usuários</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gerenciamento Usuários</h1>
        <div class="row mb-3">
            <div class="col d-flex justify-content-start">
                <p>Seja bem-vindo, <?= $_SESSION['usuario']['nome']; ?>.</p>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-secondary mx-1 text-white" href="admin.php"> Voltar</a>
                <a class="btn btn-danger mx-1 text-white" href="sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Descrição</th>
                    <th>Id_Nivel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabela as $linha) { ?>
                    <tr>
                        <td><?= $linha['ID'] ?></td>
                        <td><img src="../img/usuarios/<?= $linha['foto']; ?>" alt="<?= $linha['nome'] ?>" width="150px" height="150px"></td>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['email'] ?></td>
                        <td><?= $linha['descricao'] ?></td>
                        <td><?= $linha['id_nivel'] ?></td>
                        <td><a href="form_editar_usuario.php?id=<?= $linha['ID'] ?>">Editar</a>
                            | <a href="#" onclick="confirmaApagar(<?= $linha['ID'] ?>)">Excluir</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>






    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <?php require_once('includes/notificacoes.incl.php'); ?>
</body>

</html>