<?php
include 'user_details.php';
include 'get_user_details.php';
include 'conn.php';
// Example usage:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user credentials from the form
    $amount = $_POST['amount'];

    if ($withdrawal_amount >= $amount and $amount <= 4000) {
        // Deduct the withdrawal amount from the user's total balance
        $newBalance = $totalAmount - $amount;
        $pendingWithdraw = $pending_withdraw + $amount;
        $withdrawal_amount = $withdrawal_amount - $amount;
        $updateQuery = "UPDATE `userinformation` SET `total_balance` = '$newBalance', `pending_withdraw` = '$pendingWithdraw', `withdrawal_amount` = '$withdrawal_amount'  WHERE `username` = ?";
        $stmt = $connect_db->prepare($updateQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if( $stmt->affected_rows > 0) {
            $query = "INSERT INTO `withdrawals` ( `accountno`, `username`, `amount`, `withdrawalinitiated`, `processed`) VALUES (?, ?, ?, 0, 0)";
            $stmt = $connect_db->prepare($query);
            $stmt->bind_param("sss", $accountNo, $username ,$amount);
            $stmt->execute();
            $stmt->close();
            header("Location: ../index2.php?page=withdraw&w=success");
            exit();
        // return true; // Withdrawal initiated successfully
        } else {
        }
    } else {
        header("Location: ../index2.php?page=withdraw&w=error");
        exit();
        // return false; // Insufficient balance
    }
}
?>
