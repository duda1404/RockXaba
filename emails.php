<?php

header('Content-Type: text/html; charset=utf-8');

//Biblioteca PHPMailer, que permite enviar emails de forma mais rebuscada que a função mail() do PHP
//Chamando os métodos do PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Chama o autoloader do Composer
require 'PHPMailer/vendor/autoload.php';

//Chama a classe mail, colocando-a como igual à variável $mail
$mail = new PHPMailer(true);

try {

    //CONFIGURAÇÕES DO SERVIDOR

    /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;    Permite o DEBUG do envio do email */ 
    $mail->isSMTP(); //Chama a função isSMTP
    $mail->Host       = 'smtp.gmail.com';                     //Define o host (nesse caso, o gmail)
    $mail->SMTPAuth   = true;                                   //Define se requer, ou não, autenticação
    $mail->Username   = 'rockxaba@gmail.com';                     //Seu email
    $mail->Password   = 'wmkxrohhtbaascly';                         //Senha do seu email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Criptografia
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    

   

    if (isset($_SESSION['logado'])){


        /* EMAIL DE SUPORTE - só está disponível para usuários logados */
        //Remetentes e destinatários

        $mail->setFrom($dados['email_user'], $dados['nome_user']);          //Qual email está enviando, tem que ser o mesmo email de username
        $mail->addAddress('rockxaba@gmail.com', 'RockXaba');        //Quem vai receber esse email
        /*$mail->addAddress('ellen@example.com'); */               //Outro email que pode receber, nome é opcional
        $mail->addReplyTo($dados['email_user'], $dados['nome_user']);//Email de resposta

        //Corpo do email

        $body = "Mensagem enviada por usuário para fins de Suporte: <br>
        ID: ".$dados['id_user']."<br>
        Nome: ".$dados['nome_user']."<br>
        Email: ".$dados['email_user']."<br>
        Mensagem: ".$mensagem;

        $assunto = 'Suporte';
    }    

     

    else{

        if(isset($_SESSION['recuperando'])){

        /* EMAIL DE RECUPERAÇÃO DE SENHA - só está disponível para usuários que não logaram ainda */

        //Remetentes e destinatários

        $mail->setFrom('rockxaba@gmail.com', 'RockXaba');          //Qual email está enviando, tem que ser o mesmo email de username
        $mail->addAddress($_POST['email']);        //Quem vai receber esse email
        /*$mail->addAddress('ellen@example.com'); */               //Outro email que pode receber, nome é opcional
        $mail->addReplyTo('rockxaba@gmail.com', 'RockXaba');        //Email de resposta

        //Corpo do email
        /* Usuário clicará no link "Clique aqui" que o levará à página confirmar_email, onde o método utilizado é igual
        à variável $chave da página de Cadastro, consistindo em uma chave criptografada do email digitado pelo usuário e a data de cadastro */

        $body = "Este email diz respeito à <strong> requisição de uma nova senha, </strong> 
        no site RockXaba. Clique no link abaixo para realizá-la: <br>
        <a href='http://localhost/root/nova_senha.php?chave=$chave''> Clique aqui </a>";

        $assunto = 'Recuperando Senha';



        }
        else{

        /* EMAIL DE CONFIRMAÇÃO DE CADASTRO - só está disponível para usuários que não logaram ainda */

        //Remetentes e destinatários

        $mail->setFrom('rockxaba@gmail.com', 'RockXaba');          //Qual email está enviando, tem que ser o mesmo email de username
        $mail->addAddress($_POST['email'], $_POST['nome']);        //Quem vai receber esse email
        /*$mail->addAddress('ellen@example.com'); */               //Outro email que pode receber, nome é opcional
        $mail->addReplyTo('rockxaba@gmail.com', 'RockXaba');        //Email de resposta

        //Corpo do email
        /* Usuário clicará no link "Clique aqui" que o levará à página confirmar_email, onde o método utilizado é igual
        à variável $chave da página de Cadastro, consistindo em uma chave criptografada do email digitado pelo usuário e a data de cadastro */

        $body = "<strong>Este email foi utilizado para a realização do cadastro no site RockXaba, </strong> 
        utilizando as seguintes informações: <br>
        Nome: ".$_POST['nome']."<br>
        Email: ".$_POST['email']."<br>
        Para confirmar seu cadastro, clique no link abaixo: <br>
        <a href='http://localhost/root/confirmar_email.php?chave=$chave'> Clique aqui </a>";

        $assunto = 'Confirmando cadastro';

        }

    }

    /* Cópia de email ou cópia oculta (opcional)

    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    Adicionar anexos no email (opcional)

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name


    */

    
    $mail->isHTML(true);                                  //Define se vai ser em formato HTML
    $mail->Subject = $assunto;                           //Assunto
    $mail->Body    = $body;  //Mensagem do email
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; //Email em texto limpo, reduzindo a chance de cair em SPAM, não da pra colocar HTML

   

    $mail->send(); //Comando que efetivamente envia o email
    echo 'Email foi enviado';
} catch (Exception $e) {
    echo "Email não pode ser enviado. Mailer Error: {$mail->ErrorInfo}";
}