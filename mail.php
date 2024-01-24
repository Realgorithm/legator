<?php
$to = "hussaintabish0788@gmail.com";
$subject = "Test Email";
$message = "This is a test email.";
$headers = "legatordigital@gmail.com";

mail($to, $subject, $message, $headers);
echo "Email sent!";
?>