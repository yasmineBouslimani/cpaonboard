<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    const EMAIL_FROM = "cpaonboardcesi@gmail.com";

    public function notifyStoreKeeperForNewRequest($subject, $identifier, $message)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = self::EMAIL_FROM;
        $mail->Password = 'password(123)';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->addAddress('ybouslimani@self-and-innov.fr', 'CPA On Board');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = 'Vous avez reçu un message de ' . $identifier;
        $mail->Body = $message;

        $mail->send();
    }

    public function notifyAllOtherEmployeeForSaleStatusChanges($productName, $productId)
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = self::EMAIL_FROM;
        $mail->Password = 'password(123)';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->addAddress('ybouslimani@self-and-innov.fr', 'CPA On Board');

        $mail->isHTML(true);
        $mail->Subject = 'Bonne nouvelle ! Le statut d\'une vente a changé';
        $mail->Body = 'Il s\'agit de ce produit : ' . $productName;
        $mail->Body = 'Retrouvez le produit ici : http://localhost:8000/product/show/' . $productId;

        $mail->send();
    }
}