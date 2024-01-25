    <?php include("auth/conn.php");
    include 'auth/user_details.php';
    // Function to check if the user is eligible for the option
    function isEligibleForOption($lastOptionReceived)
    {
        $timezone = new DateTimeZone('Asia/Kolkata'); // Replace 'Asia/Kolkata' with your actual time zone
        $currentDateTime = new DateTime('now', $timezone);
        $lastOptionDateTime = new DateTime($lastOptionReceived, $timezone);

        // Calculate the interval between the last option received and the current time
        $interval = $currentDateTime->diff($lastOptionDateTime);

        // Calculate the total hours since the last option
        $hoursSinceLastOption = $interval->days * 24 + $interval->h + $interval->i / 60;

        // echo 'last option: ' . $lastOptionDateTime->format('Y-m-d H:i:s') . '<br>';
        // echo 'current time: ' . $currentDateTime->format('Y-m-d H:i:s') . '<br>';
        // echo 'elapsed time: ' . $interval->format('%R%a days %H hours %I minutes') . '<br>';
        // echo 'hours since last option: ' . $hoursSinceLastOption . '<br>';
    
        // Allow option every 24 hours, and the user can use it within the next 12 hours
        return ($hoursSinceLastOption >= 24 && $hoursSinceLastOption < 36);
    }

    // Function to process the "Get Option" click
    function processGetOption($username, $getAmount)
    {
        global $connect_db;

        // Update the user's earnings and total amount
        $updateEarningsQuery = "UPDATE userinformation SET earning = earning + ?, total_balance = total_balance + ?, withdrawal_amount = withdrawal_amount + ? WHERE username = ?";
        $stmtUpdateEarnings = $connect_db->prepare($updateEarningsQuery);
        $stmtUpdateEarnings->bind_param("dddi", $getAmount, $getAmount, $getAmount, $username);

        if ($stmtUpdateEarnings->execute()) {
            echo "Earnings updated successfully!";
        } else {
            echo "Error updating earnings: " . $stmtUpdateEarnings->error;
        }

        $stmtUpdateEarnings->close();
    }
    ?>

                                <div class="card">
                                    <h5 class="card-header bg-primary text-white">Deposit List</h5>
                                    <div class="card-body">
                                        <br />
                                        <b>Total: $
                                            <?php echo $totalAmount ?>
                                        </b><br><br>
                                        <?php $no = 1; ?>
                                        <?php while ($no <= 3): ?>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan=3 align=center>
                                                            <div class="alert alert-success" role="alert">
                                                                <?php switch ($no) {
                                                                    case 1:
                                                                        echo 'FIRST';
                                                                        break;
                                                                    case 2:
                                                                        echo 'SECOND';
                                                                        break;
                                                                    case 3:
                                                                        echo 'THIRD';
                                                                        break;
                                                                } ?> <b>PLAN
                                                                </b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class=item>
                                                            <table class="table">
                                                                <tr>
                                                                    <th class=inheader>Sno</th>
                                                                    <th class=inheader>Amount Spent ($)</th>
                                                                    <th class=inheader>
                                                                        <nobr>Total Profit</nobr>
                                                                    </th>
                                                                    <th>Get Money</th>
                                                                </tr>
                                                                <?php
                                                                $getDepositQuery = "SELECT * FROM deposits WHERE username = ?";
                                                                $stmtGetDeposit = $connect_db->prepare($getDepositQuery);
                                                                $stmtGetDeposit->bind_param("s", $_SESSION['username']);
                                                                $stmtGetDeposit->execute();
                                                                $result = $stmtGetDeposit->get_result();
                                                                if ($result->num_rows > 0) {
                                                                    $sno = 1;
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        $deposit_id = $row['deposit_id'];
                                                                        $plan = $row['plan'];
                                                                        $amount = $row['amount'];
                                                                        $claimed = $row['claimed'];
                                                                        $option = $row['last_option_received'];
                                                                        switch ($plan) {
                                                                            case '1':
                                                                                $recievedAmount = $amount * 1.4;
                                                                                $getAmount = $recievedAmount / 30;
                                                                                $claimed = $claimed + $getAmount;
                                                                                break;
                                                                            case '2':
                                                                                $recievedAmount = $amount * 1.8;
                                                                                $getAmount = $recievedAmount / 30;
                                                                                $claimed = $claimed + $getAmount;
                                                                                break;
                                                                            case '3':
                                                                                $recievedAmount = $amount * 2;
                                                                                $getAmount = $recievedAmount / 30;
                                                                                $claimed = $claimed + $getAmount;
                                                                                break;
                                                                        }
                                                                        if ($plan === $no): ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?php echo $sno ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $amount ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php echo $recievedAmount ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php // Check if the user is eligible for the option
                                                                                    
                                                                                                    if ($recievedAmount !== ($claimed - $getAmount)) {
                                                                                                        if (isEligibleForOption($option)) {
                                                                                                            $ifclicked = 0;
                                                                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                                                                if ((isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token'])) {

                                                                                                                    // User is eligible, update the last option received timestamp
                                                                                                                    $updateOptionQuery = "UPDATE deposits SET last_option_received = CURRENT_TIMESTAMP, claimed = $claimed WHERE deposit_id = ?";
                                                                                                                    $stmtUpdateOption = $connect_db->prepare($updateOptionQuery);
                                                                                                                    $stmtUpdateOption->bind_param("i", $deposit_id);
                                                                                                                    if ($stmtUpdateOption->execute()) {
                                                                                                                        // Process the "Get Option" click
                                                                                                                        processGetOption($username, $getAmount);
                                                                                                                        $ifclicked = 1;
                                                                                    
                                                                                                                    } else {
                                                                                    
                                                                                                                        echo "Error updating option timestamp: " . $stmtUpdateOption->error;
                                                                                                                    }
                                                                                                                    $stmtUpdateOption->close();
                                                                                                                    // Clear the form token after processing to prevent resubmission
                                                                                                                    unset($_SESSION['csrf_token']);
                                                                                                                } else {
                                                                                                                    // Token is not valid, handle accordingly (e.g., display an error)
                                                                                                                    echo ''. $stmtUpdateOption->error;
                                                                                                                }
                                                                                                            }
                                                                                                            // Generate a unique token for the form
                                                                                                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                                                                                        } else {
                                                                                                            echo "You are not eligible for the option at this time.";
                                                                                                            $ifclicked = 1;
                                                                                                        }
                                                                                                    } else {
                                                                                                        $ifclicked = 1;
                                                                                                        echo "Already claimed all rewards";
                                                                                                    }
                                                                                                    ?>

<!-- <?php if ($ifclicked === 0): ?> -->
                                                                                    <form action="indexcc36.php" method="post">
                                                                                        <!-- Add the CSRF token as a hidden input field -->
                                                                                        <input type="hidden" name="csrf_token"
                                                                                            value="<?php echo $_SESSION['csrf_token']; ?>">
                                                                                        <button type="submit" name="getreward"
                                                                                            value="getreward"
                                                                                            class="btn btn-warning m-t-xs">Get
                                                                                            Reward</button>
                                                                                    </form>

<!-- <?php endif; ?> -->
                                                                                </td>
                                                                            </tr>

                                                                            <?php $sno++ ?>
                                                                        <?php else:
                                                                            $sno = 1 ?>
                                                                        <?php endif; ?>
                                                                    <?php }
                                                                } else { ?>
                                                                    <tr>
                                                                        <td colspan=4>
                                                                            <div class="alert alert-warning m-b-lg"
                                                                                role="alert">
                                                                                <b>No deposits for this plan</b>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <?php $no++ ?>
                                        <?php endwhile; ?>
                                        <br>
                                    </div>
                                </div>
