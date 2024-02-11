<?php
include 'conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "hello";
    $email = $_POST['email'];
    // Validate email address
    if (empty($email)) {
    } else {

        // Check if email exists in database
        $checkEmailQuery = "SELECT * FROM userdetails WHERE email = ?";
        $stmtEmail = $connect_db->prepare($checkEmailQuery);
        $stmtEmail->bind_param("s", $email);
        $stmtEmail->execute();

        if ($stmtEmail->fetch()) {
            echo "hello2";
            // Generate unique token and store in database along with email and timestamp
            $token = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal token

            // Get the email from the form submission (replace this with your actual method of getting the email)
            $email = $_POST['email'];

            // Get the current timestamp
            $timestamp = date('Y-m-d H:i:s');
            
            $stmtEmail->close();
            // Prepare SQL statement to insert the token, email, and timestamp into the database
            $sqltoken = "INSERT INTO tokens (token, email) VALUES (?, ?)";
            $stmtGetToken = $connect_db->prepare($sqltoken);
            $stmtGetToken->bind_param("ss", $token, $email);

            // Execute the prepared statement
            if ($stmtGetToken->execute()) {
                echo "Token generated and stored successfully!";
                // Send email with password reset link including the token
                // Example: https://example.com/reset_password.php?token=TOKEN_HERE
                // You can use PHP's mail() function or a library like PHPMailer to send the email

                $to = "hussaintabish0788@gmail.com";
                $subject = "password";
                $message = "localhost/legator-final/index.php?page=reset_password&token=$token";
                $headers = "legatordigital@gmail.com";

                mail($to, $subject, $message, $headers);

                // Redirect user to a confirmation page
                header("Location: ../index.php?page=forgot_password&success=1");
                exit();
            } else {
                echo "Error storing token: " . $conn->error;
            }
        } else {
            
            header("Location: ../index.php?page=forgot_password&error=1");
            exit();
        }
        // Close the database connection
        $connect_db->close();
        exit();
    }
}
