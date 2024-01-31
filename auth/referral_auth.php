<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Assuming you have a database connection established
include 'conn.php';
$username = $_SESSION["username"];
$sql = "SELECT * FROM referrals WHERE referrername = ?";
$stmtgetrefer = $connect_db->prepare($sql);
$stmtgetrefer->bind_param("s", $username);
$stmtgetrefer->execute();
$result = $stmtgetrefer->get_result();
// echo "first column<br>";
if ($result->num_rows > 0) {
    // echo "second column<br>";
    while ($row = $result->fetch_assoc()) {
        // echo "third column<br>";
        $refereeName = $row["refereename"];
        // echo "Referee name ".$refereeName."<br>";
        $level = $row["level"];
        $updatesql = "UPDATE `referrals` SET `level` = 1 WHERE `referrername` =?";
        $stmtupdaterefer = $connect_db->prepare($updatesql);
        $stmtupdaterefer->bind_param("s", $username);
        $stmtupdaterefer->execute();
        $stmtupdaterefer->close();

        // echo "forth column<br>";

        $sqlupdate = "SELECT * FROM referrals WHERE referrername = ?";
        $stmtupdatelevel = $connect_db->prepare($sql);
        $stmtupdatelevel->bind_param("s", $refereeName);
        $stmtupdatelevel->execute();
        $results = $stmtupdatelevel->get_result();
        if ($results->num_rows > 0) {
            // echo "fifth column<br>";
            while ($row = $results->fetch_assoc()) {
                $referrerName = $row['referrername'];
                $updatesql = "INSERT INTO  `referrals` SET `level` = 2 AND `referrername` = ? WHERE `referrername` =?";
                $stmtupdaterefer = $connect_db->prepare($updatesql);
                $stmtupdaterefer->bind_param("ss", $username,$referrerName);
                $stmtupdaterefer->execute();
                $stmtupdaterefer->close();
            }
        }
        // echo "sixth column<br>";
        $sqlgetrefer = "SELECT * FROM deposits WHERE username = ? AND isdeposit = 1 AND processed = 1";
        $stmtgetrefer = $connect_db->prepare($sqlgetrefer);
        $stmtgetrefer->bind_param("s", $refereeName);
        $stmtgetrefer->execute();
        $referee = $stmtgetrefer->get_result();
        if ($referee->num_rows > 0) {
            // echo "seventh column<br>";
            while ($result2 = $referee->fetch_assoc()) {
                $amount = $result2["amount"];
                $plan = $result2["plan"];
                // echo "plan of referee".$plan."<br>";
                if ($level === 1) {
                    $referralbonus = calculateFirstLevelBonus($amount, $plan);

                } elseif ($level === 2) {
                    $referralbonus = calculateSecondLevelBonus($amount);
                }
                // echo "referral bonus :".$referralbonus."<br>";
                $sqlbonus = "UPDATE `referrals` SET `amount` = $referralbonus WHERE `referrername` = ?";
                $stmtupdatebonus = $connect_db->prepare($sqlbonus);
                $stmtupdatebonus->bind_param("s", $_SESSION["username"]);
                $stmtupdatebonus->execute();
                $stmtupdatebonus->close();
            }
        }

    }
}
// Function to calculate first-level referral bonus
function calculateFirstLevelBonus($purchaseAmount, $plan)
{
    switch ($plan) {
        case 1:
            return $purchaseAmount * 0.05; // 5% bonus for plan 1
        case 2:
            return $purchaseAmount * 0.07; // 7% bonus for plan 2
        case 3:
            return $purchaseAmount * 0.08; // 8% bonus for plan 3
        default:
            return 0;
    }
}

// Function to calculate second-level referral bonus
function calculateSecondLevelBonus($amount)
{
    return $amount * 0.02; // 2% bonus on each plan for second level
}
?>