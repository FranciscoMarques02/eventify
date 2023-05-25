<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["tel"];
    $mensagem = $_POST["msg"];
    
    // Configurar o destinatário e o assunto do e-mail
    $destinatario = "comunicacaoeventfy@gmail.com";
    $assunto = "Formulário de Contato";
    
    // Montar o corpo do e-mail
    $corpo = "Nome: " . $nome . "\n";
    $corpo .= "Email: " . $email . "\n";
    $corpo .= "Telefone: " . $telefone . "\n";
    $corpo .= "Mensagem: " . $mensagem;
    
    // Enviar o e-mail
    if (mail($destinatario, $assunto, $corpo)) {
        echo "O e-mail foi enviado com sucesso.";
    } else {
        echo "Ocorreu um erro ao enviar o e-mail.";
    }
}
?>
