<?php
include 'conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-6.9.1/src/Exception.php';
require '../PHPMailer-6.9.1/src/PHPMailer.php';
require '../PHPMailer-6.9.1/src/SMTP.php';
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email1 = $_POST['email1'];


    // Capture current date and time
    $registrationTimestamp = date('Y-m-d H:i:s');

    // Validate the data (you may want to add more validation)
    if (empty($fullname) || empty($username) || empty($password) || empty($password2) || empty($email) || empty($email1)) {
        // Handle validation errors
        echo "All fields are required.";
    } elseif ($password !== $password2) {
        // Handle password mismatch
        echo "Passwords do not match.";
    } else {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $checkUsernameQuery = "SELECT * FROM userdetails WHERE username = ?";
        $stmtUsername = $connect_db->prepare($checkUsernameQuery);
        $stmtUsername->bind_param("s", $username);
        $stmtUsername->execute();

        if ($stmtUsername->fetch()) {
            // Redirect to the register.html page with an error parameter
            header("Location: ../index.php?page=signup&error=username_exists");
            $stmtUsername->close();
            $connect_db->close();
            exit();
        }

        $stmtUsername->close();

        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM userdetails WHERE email = ?";
        $stmtEmail = $connect_db->prepare($checkEmailQuery);
        $stmtEmail->bind_param("s", $email);
        $stmtEmail->execute();

        if ($stmtEmail->fetch()) {
            // Redirect to the register.html page with an error parameter
            header("Location: ../index.php?page=signup&error=email_exists");
            $stmtEmail->close();
            $connect_db->close();
            exit();
        }

        $stmtEmail->close();

        // Store relevant user information in the session
        $_SESSION['username'] = $userDetails['username'];

        // Insert data into the database (replace 'your_table' with your actual table name)
        // Assume you have columns: fullname, username, password, email
        if (isset($_GET['ref'])) {
            $referrerName = $_GET['ref']; // Extract referrer ID from the URL
            $refereeName = $username; // Get the newly registered user's ID
            if ($referrerName !== null) {
                $stmtrefer = "INSERT INTO referrals (referrername, refereename) VALUES (?, ?)";
                $stmtrefer = $connect_db->prepare($stmtrefer);
                $stmtrefer->bind_param("ss", $referrerName, $refereeName);
                $stmtrefer->execute();
                $stmtrefer->close();
            }
        }
        $sql = "INSERT INTO userdetails (fullname, email, pass, username,registration_timestamp) VALUES (?, ?, ?, ?, ?)";
        $sql_user = "INSERT INTO userinformation (total_balance, username, earning, withdraw, pending_withdraw, deposit, referal, rigs, lastaccess) VALUES (0, ?, 0, 0, 0, 0, 0, 0, current_timestamp())";

        // Use prepared statements to prevent SQL injection
        $stmt_user = $connect_db->prepare($sql_user);
        $stmt = $connect_db->prepare($sql);
        $stmt_user->bind_param("s", $username);
        $stmt->bind_param("sssss", $fullname, $email, $hashedPassword, $username, $registrationTimestamp);

        // Execute the statement
        if ($stmt->execute() and $stmt_user->execute()) {
            echo"final output";
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
                $mail->Subject = 'Welcome to Legator';
                $mail->Body = 'Dear User,<br><br>Thank you for registering on Legator. We appreciate your membership.<br><br>Best regards,<br>Legator Team';

                $mail->send();
                echo 'Registration successful. Welcome email sent!';

            } catch (Exception $e) {
                echo "Registration successful, but there was an error sending the welcome email. Error: {$mail->ErrorInfo}";
            }
            // Redirect to the dashboard.html page with an error parameter
            header("Location: ../index2.php");
            // exit;
            echo"exit successfully";

        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and database connection
        $stmt->close();
        $stmt_user->close();
        $connect_db->close();
    }
}
?>