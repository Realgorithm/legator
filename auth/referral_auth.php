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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $referrerName=$row['referrername'];
        $firstRefereeName = $row["refereename"];
        $level = $row["level"];
        // echo "level: " . $level . ",  referrer: ".$referrerName. ",  referee: " . $firstRefereeName . "<br>";
        updateReferralAmount($firstRefereeName,$referrerName, $level);
        if ($level != 2) {
            if ($level === 0) {
                $updatesql = "UPDATE `referrals` SET `level` = 1 WHERE `referrername` = ?";
                $stmtupdaterefer = $connect_db->prepare($updatesql);
                $stmtupdaterefer->bind_param("s", $username);
                $stmtupdaterefer->execute();
                $stmtupdaterefer->close();
            }
            $sqlupdate = "SELECT * FROM referrals WHERE referrername = ? AND debited = 1";
            $stmtupdatelevel = $connect_db->prepare($sqlupdate);
            $stmtupdatelevel->bind_param("s", $firstRefereeName);
            $stmtupdatelevel->execute();
            $results = $stmtupdatelevel->get_result();

            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    $referrerName = $row['referrername'];
                    $refereeName = $row['refereename'];
                    // $level = $row['level'];
                    // echo "2nd referral: " . $referrerName . "<br>";
                    // echo "2nd referee: " . $refereeName . "<br>";
                    // echo "2nd level: " . $level . "<br>";

                    // updateReferralAmount($referrerName,$level);

                    // Check if the referral already exists before inserting
                    $checkSql = "SELECT * FROM referrals WHERE referrername = ? AND refereename = ?";
                    $checkStmt = $connect_db->prepare($checkSql);
                    $checkStmt->bind_param("ss", $username, $refereeName);
                    $checkStmt->execute();
                    $checkResult = $checkStmt->get_result();

                    if ($checkResult->num_rows == 0) {
                        $insertSql = "INSERT INTO referrals (`level`, `referrername`, `refereename`) VALUES (2, ?, ?)";
                        $insertStmt = $connect_db->prepare($insertSql);
                        $insertStmt->bind_param("ss", $username, $refereeName);
                        $insertStmt->execute();
                    }
                }
            }
        }
    }
}
function updateReferralAmount($user,$username, $level)
{
    global $connect_db;
    $sqlgetrefer = "SELECT * FROM deposits WHERE username = ? AND isdeposit = 1 AND processed = 1";
    $stmtgetrefer = $connect_db->prepare($sqlgetrefer);
    $stmtgetrefer->bind_param("s", $user);
    $stmtgetrefer->execute();
    $referee = $stmtgetrefer->get_result();

    if ($referee->num_rows > 0) {
        while ($result2 = $referee->fetch_assoc()) {
            $amount = $result2["amount"];
            $plan = $result2["plan"];
            
            
            if ($level === 1) {
                $referralbonus = calculateFirstLevelBonus($amount, $plan);
            } elseif ($level === 2) {
                $referralbonus = calculateSecondLevelBonus($amount);
            }
            // $referralbonus = ($level === 1) ? calculateFirstLevelBonus($amount, $plan) : calculateSecondLevelBonus($amount);
            // echo "plan: " . $plan .", amount: " . $amount .", bonus: " . $referralbonus . "<br>";
            $sqlbonus = "UPDATE `referrals` SET `amount` = ? WHERE `referrername` = ? AND `refereename` = ?";
            $stmtupdatebonus = $connect_db->prepare($sqlbonus);
            $stmtupdatebonus->bind_param("dss", $referralbonus, $username, $user);
            $stmtupdatebonus->execute();
            $stmtupdatebonus->close();
        }
    }
}

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

function calculateSecondLevelBonus($amount)
{
    return $amount * 0.02; // 2% bonus on each plan for second level
}
?>
