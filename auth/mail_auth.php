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
        $mail->Host = 'localhost'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username@example.com'; // SMTP username
        $mail->Password = 'your_password'; // SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 25; // TCP port to connect to

        // Recipients
        $mail->setFrom('Legatordigital@gmail.com', 'Legator');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "mail sent successfully";

    } catch (Exception $e) {
    }
}
?>
