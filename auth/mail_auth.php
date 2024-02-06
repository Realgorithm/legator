<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-6.9.1/src/Exception.php';
require 'PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/src/SMTP.php';
// Function to send customized emails
function sendCustomEmail( $subject, $message) {
    
    include 'get_user_details.php';
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtpout.secureserver.net'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'support@legator.pro'; // SMTP username
        $mail->Password = 'MF3egAWTU'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption
        $mail->Port = 465; // TCP port to connect to

        // Recipients
        $mail->setFrom('support@legator.pro', 'Legator');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body ="<p style='font-size: 16px;'>". $message."</p>";

        $mail->send();
        // echo "mail sent successfully";

    } catch (Exception $e) {
    }
}
?>