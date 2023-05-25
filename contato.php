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
    <title>Contato</title> 
</head>

<body>
    <div class="container">
    <?php require_once ("navbar.php") ; ?>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <img src="img/cont.png" class="img-fluid mt-5" alt="Eventfy.Contato" width="1000px">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md">
                <h1> Fale Conosco </h1>
            </div>
            <div class="row mt-3">
                <div class="col-md-8"><div class="form-floating mb-3">
                    <input disabled type="name" class="form-control" id="floatingInputDisabled" placeholder="Digite seu nome...">
                    <label for="floatingInputDisabled">Nome</label>
                  </div>
                  <div class="form-floating mb-3">
                    <textarea disabled type="email" class="form-control" placeholder="Digite seu email... nome@exemplo.com" id="email"></textarea>
                    <label for="email">Email</label>
                  </div>
                  <div class="form-floating mb-3">
                    <textarea disabled type="telefone"class="form-control" placeholder="Digite seu telefone..." id="tel"></textarea>
                    <label for="tel">Telefone(Opcional)</label>
                  </div>
                  <div class="form-floating mb-3">
                    <textarea disabled class="form-control" placeholder="Digite alguma mensagem/recado..." id="msg" style="height: 100px"></textarea>
                    <label for="msg">Mensagem</label>
                  </div>
                  <div class="col-12">
                    <button disabled type="submit" id="enviar-btn" class="btn btn-primary">Enviar</button>
                  </div>
                </div>
                <div class="col-md-4">
                    <p><i class="bi bi-house-door"></i> Pindamonhangaba-SP</p>
                    <p><i class="bi bi-envelope-at"></i> comunicacaoeventfy@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    <?php require_once ("rodape.htm") ; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

        <script>
  document.getElementById("enviar-btn").addEventListener("click", function(event) {
    event.preventDefault(); // Evita que o formulário seja enviado normalmente

    // Obtenha os valores dos campos do formulário
    var nome = document.getElementById("floatingInputDisabled").value;
    var email = document.getElementById("email").value;
    var telefone = document.getElementById("tel").value;
    var mensagem = document.getElementById("msg").value;

    // Crie um objeto FormData com os dados do formulário
    var formData = new FormData();
    formData.append("nome", nome);
    formData.append("email", email);
    formData.append("tel", telefone);
    formData.append("msg", mensagem);

    // Envie os dados para o arquivo PHP usando uma solicitação AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "enviar_email.php", true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        alert("O e-mail foi enviado com sucesso.");
        // Limpe o formulário após o envio bem-sucedido, se desejar
        document.getElementById("floatingInputDisabled").value = "";
        document.getElementById("email").value = "";
        document.getElementById("tel").value = "";
        document.getElementById("msg").value = "";
      } else {
        alert("Ocorreu um erro ao enviar o e-mail.");
      }
    };
    xhr.send(formData);
  });
</script>

</body>

</html>