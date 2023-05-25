<?php
// Arrays com msgs de sucesso ou erro:
$msg = [
        'Cadastro realizado com sucesso!',
        'Estabelecimento cadastrado!',
        'Usuário modificado!',
        'Estabelecimento excluído!',
        'Categoria cadastrada!',
        'Tag Excluida com sucesso',
        'Tag Adicionada com sucesso',
        'Evento excluído',
        'Evento editado',
        'Usuário excluído',
        'Estabelecimento editado',
        'Estabelecimento removido'
];

$err = [
        'Email e/ou senha incorretos!',
        'Verifique as informações digitadas.',
        'Este e-mail já está cadastrado.',
        'Falha ao editar.',
        'Falha ao excluir a tag',
        'Voce ja tem esse id',
        'As senhas não conferem!',
        'Erro ao remover o evento!',
        'Erro ao editar o evento!',
        'Erro ao remover o usuário',
        'Falha ao adicionar a tag',
        'O nome não pode esta vazio!',
        'O email não pode estar vazio',
        'O link não pode estar vazio!',
        'A data não pode estar vazia!',
        'A categoria não pode estar vazia',
        'Essa tag já existe!',
        'A data não pode ser anterior ao dia de hoje!',
        'Erro ao remover o estabelecimento'
];
?>

<!-- Sweet Alerts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
        // Mensagens de sucesso:
        <?php if (isset($_GET['msg'])) { ?>
                swal("Sucesso!", "<?= $msg[$_GET['msg']]; ?>", "success");
                // Remover os parâmetros da URL:
                window.history.replaceState(null, null, window.location.pathname);
        <?php } ?>

        // Mensagens de erro:
        <?php if (isset($_GET['err'])) { ?>
                swal("Erro!", "<?= $err[$_GET['err']]; ?>", "error");
                // Remover os parâmetros da URL:
                window.history.replaceState(null, null, window.location.pathname);
        <?php } ?>


        // Função para confirmar exclusão:
        function confirmaApagar(id) {
                swal({
                                title: "Atenção",
                                text: "Tem certeza que deseja apagar o usuário " + id + "?",
                                icon: "warning",
                                buttons: ["Não", "Sim"],
                                dangerMode: true,
                        })
                        .then((willDelete) => {
                                if (willDelete) {
                                        window.location.href = "actions/apagar_usuario.php?id=" + id;
                                } else {
                                        swal("O usuário não foi apagado!");
                                }
                        });
        }

        // Função para confirmar exclusão do estabelecimento:
        function confirmaApagarEstab(id) {
                swal({
                                title: "Atenção",
                                text: "Tem certeza que deseja apagar o estabelecimento " + id + "?",
                                icon: "warning",
                                buttons: ["Não", "Sim"],
                                dangerMode: true,
                        })
                        .then((willDelete) => {
                                if (willDelete) {
                                        window.location.href = "actions/apagar_estabelecimento.php?id=" + id;
                                } else {
                                        swal("O estabelecimento não foi apagado!");
                                }
                        });
        }

        // Função para confirmar exclusão:
        function confirmaApagarEvento(id) {
                swal({
                                title: "Atenção",
                                text: "Tem certeza que deseja apagar o evento " + id + "?",
                                icon: "warning",
                                buttons: ["Não", "Sim"],
                                dangerMode: true,
                        })
                        .then((willDelete) => {
                                if (willDelete) {
                                        window.location.href = "actions/apagar_evento.php?id=" + id;
                                } else {
                                        swal("O evento não foi apagado!");
                                }
                        });
        }
</script>