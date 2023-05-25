<?php
// Painel de administração

session_start();

// Verificar se é o admin:
if ($_SESSION['usuario']['id_nivel'] != 1) {
    // Devolver para tela de login:
    header('Location: login.php');
}


// Obter a lista de imagens dos eventos:
require_once('classes/Estabelecimento.class.php');
$estabelecimento = new Estabelecimento();
$tabela_es = $estabelecimento->ListarTudo();

// Obter a lista de imagens dos eventos:
require_once('classes/Categoria.evento.class.php');
$categoria = new Categoria_Evento();
$tabela_c = $categoria->ListarTudo();

// Obter a lista de imagens dos eventos:
require_once('classes/Cidade.class.php');
$cidade = new Cidade();
$tabela_cdd = $cidade->ListarTudo();

// Instanciação:
require_once('classes/Evento.class.php');
$evento = new Evento();
$tabela_e = $evento->ListarTudo();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listagem de Eventos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .img150 {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gerenciamento de Eventos</h1>
        <div class="row mb-3">
            <div class="col-md d-flex justify-content-end">
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Cadastrar
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAddCidade">Cidade</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalAddCategoria">Categoria</a>
                        </div>
                    </div>
                </div>
                <a class="btn btn-secondary mx-1 text-white" href="admin.php"> Voltar</a>
                <a class="btn btn-danger mx-1 text-white" href="sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Link</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Estabelecimento</th>
                        <th>Cidade do evento</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tabela_e as $eventos) { ?>

                        <tr>
                            <td><?php echo $eventos["id"]; ?></td>
                            <td><img class="img150" alt="Imagem do evento" src="../img/eventos/<?php echo $eventos["Imagem"] ?>"></td>
                            <td><?php echo $eventos["Nome"]; ?></td>
                            <td><?php echo mb_strimwidth($eventos["link"], 0, 25, "...") ?></td>
                            <td><?php echo $eventos["data_evento"]; ?></td>
                            <td><?php echo mb_strimwidth($eventos["descricao_evento"], 0, 25, "..."); ?></td>
                            <td><?php echo $eventos["Categoria"]; ?></td>
                            <td><?php echo $eventos["Estabelecimento_Resp"]; ?></td>
                            <td><?php echo $eventos["Cidade"]; ?></td>

                            <td><a href="editar_eventos_index.php?id=<?= $eventos['id'] ?>">Editar</a> | <a href="#" onclick="confirmaApagarEvento(<?= $eventos['id'] ?>)">Excluir</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modalAddCategoria" tabindex="-1" role="dialog" aria-labelledby="modalAddCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCategoriaLabel">Adicionar Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="actions/cadastrar_categoria.php" method="POST">
                        <div class="form-group">
                            <label for="nomeCategoria">Nome da Categoria</label>
                            <input name="categ_event" type="text" class="form-control" id="nomeCategoria" placeholder="Digite o nome da categoria">
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
    <div class="modal fade" id="modalAddCidade" tabindex="-1" role="dialog" aria-labelledby="modalAddCidadeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCidadeLabel">Adicionar Cidade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="actions/cadastrar_cidade.php" method="POST">
                        <div class="form-group">
                            <label for="nomeCidade">Nome da Cidade</label>
                            <input name="nome" type="text" class="form-control" id="nomeCidade" placeholder="Digite o nome da cidade">
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

<?php require_once('includes/notificacoes.incl.php') ?>


</html>