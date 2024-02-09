<?php
// Assuming you have a database connection established
include 'auth/conn.php';
include 'auth/user_details.php';
include 'auth/get_user_details.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$amount = null;
$date = null;
$type = null;
// Convert the date string to a Unix timestamp
$timestamp = strtotime($registrationTimestamp);

// Format the timestamp to display only the day, month, and year (d-m-Y format)
$userRegistrationDate = date('Y-m-d', $timestamp); ?>
<div class="card">
    <h5 class="card-header bg-primary text-white">Earnings</h5>
    <div class="card-body">

        <script language=javascript>
            function go(p) {
                document.opts.type.value = p;
                document.opts.submit();
            }
        </script>

        <div class="row">
            <div class="col-md-12">
                <form method=post name=opts action="index2.php?page=history">
                    <input type=hidden name=a value=earnings>
                    <input type=hidden name=page value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6"><br>
                                    <select name="type" class="form-control">
                                        <option value="" <?php if (empty($_POST['type']))
                                                                echo 'selected'; ?>>
                                            All transactions</option>
                                        <option value="deposit" <?php if (!isset($_POST['type']) || $_POST['type'] === 'deposit')
                                                                    echo 'selected'; ?>>Deposit</option>
                                        <option value="withdrawal" <?php if (!isset($_POST['type']) || $_POST['type'] === 'withdrawal')
                                                                        echo 'selected'; ?>>Withdrawal</option>
                                        <option value="earning" <?php if (!isset($_POST['type']) || $_POST['type'] === 'earning')
                                                                    echo 'selected'; ?>>Earning</option>
                                        <option value="referral" <?php if (!isset($_POST['type']) || $_POST['type'] === 'referral')
                                                                        echo 'selected'; ?>>Referral commission
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6"><br>
                                    <select name=ec class="form-control">
                                        <option value=1008 selected>USDT ERC20</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>From:</label>
                
                                    <!-- Add min attribute to set the minimum start date -->
                                    <input type="date" name="date_from" class="form-control" value="<?php echo $userRegistrationDate; ?>" min="<?php echo $userRegistrationDate; ?>" max="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label style="text-align:center">To:</label>
                                
                                    <!-- Add max attribute to set the maximum end date -->
                                    <input type="date" name="date_to" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp; <input type=submit value=" search " class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br><br>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th><b>Type</b></th>
                        <th><b>Amount</b></th>
                        <th><b>Date</b></th>
                    </tr>
                </thead>
                <?php
                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $selectedType = $_POST["type"];
                    $startDate = $_POST["date_from"];
                    $endDate = $_POST["date_to"];

                    $username = $_SESSION['username'];

                    // Example query (modify based on your database schema)
                    $query = "SELECT `selectedtype`, `amount`, `dates` FROM transactions WHERE username = ? AND dates BETWEEN ? AND ?";

                    // Check if the user has selected a specific transaction type
                    if ($selectedType !== '') {
                        // Append the condition to the query if a specific type is selected
                        $query .= " AND selectedtype = ?";
                        $stmt = $connect_db->prepare($query);
                        $stmt->bind_param("ssss", $username, $startDate, $endDate, $selectedType);
                    } else {
                        // Otherwise, fetch all transaction types
                        $stmt = $connect_db->prepare($query);
                        $stmt->bind_param("sss", $username, $startDate, $endDate);
                    }

                    // Execute the query
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Fetch and display results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Output the data in your desired format (e.g., HTML table rows)
                            $amount = $row['amount'];
                            $date = $row['dates'];
                            $type = $row['selectedtype'];
                            echo "<tr>
                                    <td>$type</td>
                                    <td>$amount</td>
                                    <td>$date</td>
                                </tr>";
                        }
                    } else {
                        echo "
                            <script>
                                showErrorMessage('no $selectedType found' , 'warning')
                            </script>";
                    }
                    // Close statement and connection
                    $stmt->close();
                }
                ?>



                <tr>
                    <td colspan=2>Total:</td>
                    <td><b>$
                            <?php echo $totalAmount ?>
                        </b></td>
                </tr>
            </table>
        </div>

    </div>
</div>