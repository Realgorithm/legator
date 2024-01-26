<?php
include 'conn.php';

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
        $sql_user = "INSERT INTO userinformation (totalmining, total_balance, username, earning, withdraw, pending_withdraw, deposit, referal, rigs, lastaccess) VALUES (0, 10, ?, 0, 0, 0, 0, 0, 0, current_timestamp())";

        // Use prepared statements to prevent SQL injection
        $stmt_user = $connect_db->prepare($sql_user);
        $stmt = $connect_db->prepare($sql);
        $stmt_user->bind_param("s", $username);
        $stmt->bind_param("sssss", $fullname, $email, $hashedPassword, $username, $registrationTimestamp);

        // Execute the statement
        if ($stmt->execute() and $stmt_user->execute()) {
            
                $subject = 'Welcome to LEGATOR - Successful Signup!';
                $body = "<pre>Dear $fullname,

                Welcome to LEGATOR! We're thrilled to have you on board. Your signup was successful, and we're excited to provide you with a seamless trading experience.
                
                *<b>Account Information:</b>*
                - Username: $username
                - Password: $password
                
                Whether you're a seasoned trader or just getting started, LEGATOR is designed to meet your trading needs. Explore our platform, discover market opportunities, and stay updated on the latest trends.
                
                If you have any questions or need assistance, our support team is here to help. Feel free to reach out at [support@legator.com].
                
                Happy trading!
                
                Best regards,
                The LEGATOR Team</pre>";

                sendCustomEmail($subject,$body);
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