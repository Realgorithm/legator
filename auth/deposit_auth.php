<?php
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);
include 'user_details.php';
include 'conn.php';
// Example usage:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "start";
    include 'upload.php';
    // Check if the flag is set
    if (isset($executeCardAuth) && $executeCardAuth) {
    if (($_POST['save'])==='save') {
        echo"start deposit";
    // Retrieve user credentials from the form
    $depositId = $_POST['depositid'];
    $depositamount =$_POST['amount'];
    $planNo= $_POST['plan'];
    $sql = "SELECT deposit_id FROM deposits WHERE deposit_id =?";
    $stmtcheck = $connect_db->prepare($sql);
    $stmtcheck->bind_param("s", $depositId);
    $stmtcheck->execute();
    $stmtcheck->store_result();

    // Check if any row is found
    if ($stmtcheck->num_rows > 0) {
        // echo "you already use this transaction id or wrong transaction id";
        header("Location: ../index2.php?page=deposit_final&use=1");
    } else {
        echo "Username does not exist. Proceed with registration or other logic.";
        echo "deposit id:". $depositId. "username:". $username. "Amount". $depositamount;
        $insertQuery = "INSERT INTO `deposits` (`deposit_id`, `username`, `plan`, `amount`, `isdeposit`, `processed`, `claimed`) VALUES (?, ?, ?, ?, 0, 0, 0)";
        $stmt = $connect_db->prepare($insertQuery);
        $stmt->bind_param("ssss", $depositId, $username,$planNo, $depositamount);
        if ($stmt->execute()) {
            header("Location: ../index2.php?page=deposit&success=1");
            exit();
        } else {
            // $error = $stmt->error;
            // echo "sorry for incovinience please re enter the transaction id and send" . $error . "";
            header("Location: ../index2.php?page=deposit&error=1");
            exit();
        }
        $stmt->close();
    }

    // Close the statement and connection
    $stmtcheck->close();
    $connect_db->close();
}
    }
    else{
        header("Location: ../index2.php?page=deposit_final&upload=1");
        exit();
    }
}
?>