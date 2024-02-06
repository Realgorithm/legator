<?php
include 'conn.php';
// include 'login_process.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user details based on the provided username
$getUserQuery = "SELECT * FROM userdetails WHERE username = ?";
$stmtGetUser = $connect_db->prepare($getUserQuery);
$stmtGetUser->bind_param("s", $_SESSION['username']);
$stmtGetUser->execute();
$result = $stmtGetUser->get_result();

// echo $result;

// Check if the user exists
if ($result->num_rows === 1) {
    $userDetails = $result->fetch_assoc();

    // Check if $userDetails is not null before accessing its properties
    if ($userDetails !== null) {
        // $userDetails now contains the details of the user
        $userId = $userDetails['id'];
        $fullname = $userDetails['fullName'];
        $email = $userDetails['email'];
        $password = $userDetails['pass'];
        $username = $userDetails['username'];
        $accountNo = $userDetails['accountno'];
        $isAccountSet = $userDetails['isaccountset'];
        $registrationTimestamp = $userDetails['registration_timestamp'];

        // Format the timestamp as needed
        $formattedTimestamp = date('F j, Y, g:i a', strtotime($registrationTimestamp));
        
        // echo $userId . ' ' . $fullname . ' ' . $email . ' ' . $password . '';
    } else {
        // Handle the case where $userDetails is null
        echo "User details not found.";
    }
} else {
    // Handle the case where the user doesn't exist
    header("Location: ../home");
}

// Close the statement and database connection
$stmtGetUser->close();
?>