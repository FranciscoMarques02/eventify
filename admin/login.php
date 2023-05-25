<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <style>
        #formCadastro {
            display: none;
        }
    </style>
</head>

<body class="bg-dark text-black">

    <div class="container col-4 mt-5 bg-dark-subtle p-5 rounded">
        <div class="row mb-1">
            <div class="d-flex justify-content-center">
            <img class=" w-md-50 img-fluid" src="../img/logo.png">
            </div>
        </div>
        <form id="formLogin" action="actions/logar.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control shadow" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" class="form-control shadow" name="senha">
            </div>
            <button type="submit" class="btn btn-primary shadow">Entrar</button>
            <div class="mb-3 mt-3">
                <p class="text-center">Não possui conta no sistema? <a href="#" id="btnCadastroToggle">Cadastre-se</a></p>
            </div>
        </form>

        <!-- Formulário Cadastro -->
        <form id="formCadastro" action="actions/cadastrar_usuario.php" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nome</label>
                <input type="text" class="form-control shadow" name="nome">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control shadow" aria-describedby="emailHelp" name="email">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Descrição</label>
                <textarea class="form-control shadow" id="exampleFormControlTextarea1" rows="3" name="descricao"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" class="form-control shadow" name="senha">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirme a Senha</label>
                <input type="password" class="form-control shadow" name="confirmacao_senha">
            </div>
            <div class="d-flex justify-content-center">
    <button type="submit" class="btn btn-primary shadow">Cadastrar</button>
  </div>
            <div class="mb-3 mt-3">
                <p class="text-center">Já possui conta? <a href="#" id="btnLoginToggle">Entrar</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Alternar entre formulários login x cadastro:
        $("#btnCadastroToggle").click(function() {
            $("#formLogin").hide();
            $("#formCadastro").fadeIn();
            $("#titulo").text('Cadastro');
        });
        $("#btnLoginToggle").click(function() {
            $("#formCadastro").hide();
            $("#formLogin").fadeIn();
            $("#titulo").text('Login');
        });
    </script>
    <?php require_once('includes/notificacoes.incl.php'); ?>
</body>

</html>