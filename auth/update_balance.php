<?php
// Assume you have a database connection ($conn)
include 'conn.php';
include 'referral.php';
// Function to update user balance
function updateDeposit($username, $depositAmount)
{
    global $connect_db;
    $query = "UPDATE `userinformation` SET `total_balance` = `total_balance` + ? , `deposit` = `deposit` + ? , `rigs` = `rigs` + ? WHERE `username` = ?";
    $stmt = $connect_db->prepare($query);
    $stmt->bind_param("ssss", $depositAmount, $depositAmount, $depositAmount, $username);
    $stmt->execute();
    $stmt->close();
}
function updateWithdrawal($username, $withdrawAmount)
{
    global $connect_db;
    $query = "UPDATE `userinformation` SET `pending_withdraw` = `pending_withdraw` - ?, `withdraw` = ?  WHERE `username` = ?";
    $stmt = $connect_db->prepare($query);
    $stmt->bind_param("sss", $withdrawAmount, $withdrawAmount, $username);
    $stmt->execute();
    $stmt->close();
}
function updateReferralBonus($username, $bonusAmount)
{
    global $connect_db;
    $query = "UPDATE `userinformation` SET `total_balance` = `total_balance`  + ?, `earning` = `earning` + ?  WHERE `username` = ?";
    $stmt = $connect_db->prepare($query);
    $stmt->bind_param("sss", $bonusAmount, $bonusAmount, $username);
    $stmt->execute();
    $stmt->close();
}

// Check for changes in isdeposited column
$query = "SELECT deposit_id, username, amount FROM deposits WHERE isdeposit = 1 AND processed = 0";
$result = $connect_db->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $depositId = $row['deposit_id'];
        $username = $row['username'];
        $depositAmount = $row['amount'];

        // Update user's balance
        updatedeposit($username, $depositAmount);

        // Mark the deposit as processed
        $updateQuery = "UPDATE deposits SET processed = 1 WHERE deposit_id = '$depositId'";
        $connect_db->query($updateQuery);

        if($username === $_SESSION['username']){
        $updateMessage = "<p>Your deposit has been processed successfully.</p>";
        }
    }
} else {
    // $updateMessage = "No deposits to process.<br>";
}

$query1 = "SELECT withdraw_id, username, amount FROM withdrawals WHERE withdrawalinitiated = 1 AND processed = 0";
$result1 = $connect_db->query($query1);

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $withdrawId = $row['withdraw_id'];
        $username = $row['username'];
        $withdrawalAmount = $row['amount'];

        // Update user's balance
        updateWithdrawal($username, $withdrawalAmount);

        // Mark the deposit as processed
        $updateQuery = "UPDATE withdrawals SET processed = 1 WHERE withdraw_id = '$withdrawId'";
        $connect_db->query($updateQuery);

        if($username === $_SESSION['username']){
        $updateMessage = "<p>withdraw of withdraw id:" . $withdrawId . " amount:" . $withdrawalAmount . "processed successfully<p>";
        }
    }
} else {
    // $updateMessage = "No deposits to process.<br>";
}

$query2 = "SELECT * FROM referrals WHERE debited = 0";
$result2 = $connect_db->query($query2);

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $referrerName = $row['referrername'];
        $depositAmount = $row['amount'];
        $refereeName = $row['refereename'];

        // Update user's balance
        updateReferralBonus($referrerName, $depositAmount);

        // Mark the deposit as processed
        $updateQuery1 = "UPDATE `referrals` SET `debited` = 1 WHERE `referrername` = '$referrerName'";
        $connect_db->query($updateQuery1);

        if($referrerName === $_SESSION["username"]){
        $updateMessage = "<p>Referee Name $refereeName referral amount processed successfully.</p>";
        }
    }
} else {
    // $updateMessage = "No deposits to process.<br>";
}
?>