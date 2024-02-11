<?php
include 'conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    
    // Validate input fields
    if ($password != $confirmPassword) {
        echo "Passwords do not match";
        exit();
    }
    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if token is valid and not expired
    $getTokenQuery = "SELECT * FROM tokens WHERE token = ? ";
    $stmtGetToken = $connect_db->prepare($getTokenQuery);
    $stmtGetToken->bind_param("s", $token);
    $stmtGetToken->execute();
    $result = $stmtGetToken->get_result();
    if ($result->num_rows == 1) {
        // Retrieve user email from database based on token
        $row = $result->fetch_assoc();
        $email = $row['email'];
        // Update user's password in database
        // Example SQL query: UPDATE users SET password = ? WHERE email = ?
        $sqlquery = "UPDATE userdetails SET pass = ? WHERE email = ?";
        $stmtUpdatePass = $connect_db->prepare($sqlquery);
        $stmtUpdatePass->bind_param("ss", $hashedPassword,$email);
        $stmtUpdatePass->execute();
        $stmtUpdatePass->close();
        // Redirect user to a confirmation page
        header("Location: ../index.php?page=reset_success");
        exit();
    }


}
