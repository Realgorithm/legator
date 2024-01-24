<?php
include 'conn.php';
include 'get_user_details.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$newfullname = $fullname;
$newaccountNo = $accountNo;
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $newfullname = $_POST['fullname'];
    $newpassword = $_POST['password'];
    $password2 = $_POST['password2'];
    $newaccountNo = $_POST['account'];

    if ($newpassword !== $password2) {
        // Handle password mismatch
        echo "Passwords do not match.";
    } else {
        $hashedPassword = $password;
        $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $username = $_SESSION['username'];
        $isAccountSet = 1;
        echo "fullname" . $newfullname . "password" . $hashedPassword . "account" . $newaccountNo . "Username" . $username . "Accountset" . $isAccountSet;
        $sql = "UPDATE `userdetails` SET `fullName` = '$newfullname', `pass` = '$hashedPassword', `isaccountset` = '$isAccountSet', `accountno` = '$newaccountNo' WHERE `username` = ?";
        $stmtUpdateUser = $connect_db->prepare($sql);
        $stmtUpdateUser->bind_param("s", $username);
        $stmtUpdateUser->execute();

        echo "Updated Successfully";
        header("Location: ../index2.php?page=account");
        exit();
    }
}
?>