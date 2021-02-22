<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    const EMAIL_FROM = "yasmine.bouslimani@gmail.com";

    public function notifyEmployee($subject, $identifier, $message) {

        $mail = new PHPMailer(true);

        //Server settings
        //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = self::EMAIL_FROM;                       //SMTP username
        $mail->Password   = '1o2tnhxM';                             //SMTP password
        $mail->SMTPSecure = 'tls';                                  //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $mail->addAddress('ybouslimani@self-and-innov.fr', 'Joe User');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = 'Vous avez reçu un message de ' . $identifier;
        $mail->Body    = $message;


        $mail->send();

}

}