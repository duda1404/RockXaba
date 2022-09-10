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
    $mail->Username   = 'rockxaba027@gmail.com';                     //Seu email
    $mail->Password   = 'szkwqpqjhndlhjgz';                         //Senha do seu email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Criptografia
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Remetentes e destinatários

        $mail->setFrom($emailEnvia, $apelidoEnvia);          //Qual email está enviando, tem que ser o mesmo email de username
        $mail->addAddress($emailRecebe, $apelidoRecebe);        //Quem vai receber esse email
        /*$mail->addAddress('ellen@example.com'); */               //Outro email que pode receber, nome é opcional
        $mail->addReplyTo($emailEnvia, $apelidoEnvia);//Email de resposta
   

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