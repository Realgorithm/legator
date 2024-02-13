<?php
session_start();
require_once 'GoogleAuthenticator.php';
require_once 'conn.php';
$username = $_SESSION['username'];
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle login form submission
    $tfaCode = $_POST['code'];
    $secretKey = $_POST['tfa_secret']; // TFA code entered by the use

    $ga = new PHPGangsta_GoogleAuthenticator();
    // Verify the TFA code entered by the user
    $isVerified = $ga->verifyCode($secretKey, $tfaCode, 2);

    if ($isVerified) {
        // TFA verification successful
        // Encrypt the secret key
        // $encryptionKey = openssl_random_pseudo_bytes(16); // Generate a 128-bit (16-byte) encryption key
        // $hexKey = bin2hex($encryptionKey);
        $hexKey = getenv('ENCRYPTION_KEY');
        $encryptionKey = hex2bin($hexKey);
        // echo $hexKey;
        $encryptedSecretKey = openssl_encrypt($secretKey, 'aes-128-cbc', $encryptionKey, 0, $encryptionKey);

        $sql = "INSERT INTO usertfa (username,secretkey) VALUES (?, ?)";

        // Use prepared statements to prevent SQL injection

        $stmt = $connect_db->prepare($sql);
        $stmt->bind_param("ss", $username, $encryptedSecretKey);
        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../index2.php?page=security&success=1");
            $stmt->close();
            exit();
        } else {
            header("Location: ../index2.php?page=security&error=1");
            exit();
        }
    } else {
        // TFA verification failed
        $error = "Invalid TFA code. Please try again.";
        header("Location: ../index2.php?page=security&error=2");
    }
}
