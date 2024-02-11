<?php

include_once 'conn.php';
$getDepositQuery = "SELECT * FROM deposits WHERE username = ? and isdeposit = 1";
$stmtGetDeposit = $connect_db->prepare($getDepositQuery);
$stmtGetDeposit->bind_param("s", $_SESSION['username']);
$stmtGetDeposit->execute();
$result = $stmtGetDeposit->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $option = $row['last_option_received'];

        // $timezone = new DateTimeZone('Asia/Kolkata'); // Replace 'Asia/Kolkata' with your actual time zone
        $timezone = new DateTimeZone('America/Los_Angeles');

        $currentDateTime = new DateTime('now', $timezone);
        $dateTime = $currentDateTime->format('Y-m-d H:i:s');
        $lastOptionDateTime = new DateTime($option, $timezone);

        // Calculate the interval between the last option received and the current time
        $interval = $currentDateTime->diff($lastOptionDateTime);

        // Calculate the total hours since the last option
        $hoursSinceLastOption = $interval->days * 24 + $interval->h + $interval->i / 60;

        // Calculate the total hours since the last option
        $hoursSinceLastOption = $interval->days * 24 + $interval->h + $interval->i / 60;

        // Check if the user is eligible for the option
        if (($hoursSinceLastOption >= 24 && $hoursSinceLastOption < 36)) {
            $success = "🎉 Great news! Your reward is waiting for you in the Mining List tab. Go check it out now! 💰";
        }

        // If the user is not eligible, update the lastOptionReceived to the current time
        if ($hoursSinceLastOption > 36) {
            $error = "⏳ Oh no! You missed your last chance! Hurry over to the Mining List tab to seize the opportunity before it's gone! 💸";
        }
    }
}
