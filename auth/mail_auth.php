<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-6.9.1/src/Exception.php';
require 'PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/src/SMTP.php';
// Function to send customized emails
function sendCustomEmail($subject, $message)
{

    include 'get_user_details.php';
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = $smtpHost; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser; // SMTP username
        $mail->Password = $smtpPass; // SMTP password
        // $mail->SMTPSecure = $smtpEncryption; // Enable TLS encryption
        $mail->Port = $smtpPort; // TCP port to connect to

        // Recipients
        $mail->setFrom('support@legator.pro', 'Legator');
        $mail->setFrom('support@legator.pro', 'Legator');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<p style='font-size: 22px; color: green;'>" . $message . "</p>";

        $mail->send();
        // echo "mail sent successfully";

    } catch (Exception $e) {
    }
}
