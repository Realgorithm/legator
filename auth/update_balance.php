<?php
// Assume you have a database connection ($conn)
include 'conn.php';
include 'referral_auth.php';
require 'mail_auth.php';
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
function insertTransaction($amount,$date, $username, $selectedType)
{
    global $connect_db;
    $query = "INSERT INTO transactions (amount, dates, username, selectedtype) VALUES (?, ?, ?, ?)";
    $stmt = $connect_db->prepare($query);
    $stmt->bind_param("ssss", $amount,$date, $username, $selectedType);
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

        $depositDate = date('Y-m-d');
        insertTransaction($depositAmount,$depositDate,$username,'deposit');
        if ($username === $_SESSION['username']) {
            
            $updateMessage = "<p>Your deposit has been processed successfully.</p>";
            $subject = "LEGATOR - Deposit Payment Confirmation";
            $body = "<pre>Dear $username,

    Thank you for choosing LEGATOR for your trading endeavors. We are pleased to confirm the successful processing of your deposit payment.
        
    <b>*Deposit Details:*</b>
    - Amount: $$depositAmount
    - Date: $depositDate

    <b>*Transaction ID: $depositId*</b>

    Your funds are now available in your LEGATOR account, and you can begin exploring the exciting world of trading.
    If you have any questions or require further assistance, please don't hesitate to contact our support team at [support@legator.com].
    Happy trading!
        
    Best regards,
    The LEGATOR Team</pre>";
            sendCustomEmail($subject, $body);
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

        $withdrawDate = date('Y-m-d');
        insertTransaction($withdrawalAmount,$withdrawDate,$username,'withdrawal');
        if ($username === $_SESSION['username']) {
            $updateMessage = "<p>withdraw of withdraw id:" . $withdrawId . " amount:" . $withdrawalAmount . "processed successfully<p>";
            $subject = " LEGATOR - Withdrawal Request Confirmation";
            $body = "<pre>Dear $username,

    Thank you for choosing LEGATOR for your trading needs. We have received your withdrawal request, and we want to confirm that it is being processed.
        
    <b>*Withdrawal Details:*</b>
    - Amount: $$withdrawalAmount
    - Date: $withdrawDate
        
    <b>*Transaction ID: $withdrawId*</b>
        
    Please note that withdrawals may take 1-2 business days to reflect in your account. You can track the status of your withdrawal by logging into your LEGATOR account.
    If you did not initiate this withdrawal or have any concerns, please contact our support team immediately.
    Thank you for trusting LEGATOR with your trading activities.
        
    Best regards,
    The LEGATOR Team</pre>";
            sendCustomEmail($subject, $body);
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
        $referralAmount = $row['amount'];
        $refereeName = $row['refereename'];
        if($referralAmount!=0){
            // Update user's balance
            updateReferralBonus($referrerName, $referralAmount);
            // Mark the deposit as processed
            $updateQuery1 = "UPDATE `referrals` SET `debited` = 1 WHERE `referrername` = '$referrerName'";
            $connect_db->query($updateQuery1);
            $date=date('Y-m-d');
            if ($referrerName === $_SESSION["username"]) {
                insertTransaction($referralAmount,$date,$referrerName,'referral');
                $updateMessage = "<p>Referee Name $refereeName referral amount processed successfully.</p>";
            }
        }
    }
} else {
    // $updateMessage = "No deposits to process.<br>";
}
?>