<?php
include 'conn.php';
include 'update_balance.php';
// include 'login_process.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch user details based on the provided username
$getUserQuery = "SELECT * FROM userinformation WHERE username = ?";
$stmtGetUser = $connect_db->prepare($getUserQuery);
$stmtGetUser->bind_param("s", $_SESSION['username']);
$stmtGetUser->execute();
$result = $stmtGetUser->get_result();

// Check if the user exists
if ($result->num_rows === 1) {
    $userDetails = $result->fetch_assoc();

    // Check if $userDetails is not null before accessing its properties
    if ($userDetails !== null) {
        // $userDetails now contains the details of the user
        $totalMining = $userDetails['totalmining'];
        $totalAmount = $userDetails['total_balance'];
        $username = $userDetails['username'];
        $earning = $userDetails['earning'];
        $withdraw = $userDetails['withdraw'];
        $pending_withdraw = $userDetails['pending_withdraw'];
        $withdrawal_amount = $userDetails['withdrawal_amount'];
        $deposit = $userDetails['deposit'];
        $referal = $userDetails['referal'];
        $rigs = $userDetails['rigs'];
        $lastAccessTime = $userDetails['lastaccess'];
    } else {
        // Handle the case where $userDetails is null
        echo "User details not found.";
    }
} else {
    // Handle the case where the user doesn't exist

}

// Close the statement and database connection
$stmtGetUser->close();
