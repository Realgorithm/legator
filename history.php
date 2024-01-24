<?php
// Assuming you have a database connection established
include 'auth/conn.php';
include 'auth/user_details.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$amount = null;
$date = null;
$type = null;
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedType = $_POST["type"];
    $startDate = $_POST["year_from"] . '-' . $_POST["month_from"] . '-' . $_POST["day_from"];
    $endDate = $_POST["year_to"] . '-' . $_POST["month_to"] . '-' . $_POST["day_to"];

    $username = $_SESSION['username'];

    // Example query (modify based on your database schema)
    $query = "SELECT `selectedtype`, `amount`, `date` FROM transactions WHERE username = ? AND selectedtype = ? AND date BETWEEN ? AND ?";

    $stmt = $connect_db->prepare($query);
    $stmt->bind_param("ssss", $username, $selectedType, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and display results
    while ($row = $result->fetch_assoc()) {
        // Output the data in your desired format (e.g., HTML table rows)
        $amount = $row['amount'];
        $date = $row['date'];
        $type = $row['selectedtype'];
        // $results[] = $row;
    }

    // Close statement and connection
    $stmt->close();

}
?>
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
                                <div class="col-md-4">
                                    <select name="type" class="form-control" onchange="document.opts.submit();">
                                        <option value="" <?php if (empty($_POST['type']))
                                            echo 'selected'; ?>>
                                            All transactions</option>
                                        <option value="deposit" <?php if (!isset($_POST['type']) || $_POST['type'] === 'deposit')
                                            echo 'selected'; ?>>Deposit</option>
                                        <option value="withdrawal" <?php if (!isset($_POST['type']) || $_POST['type'] === 'withdrawal')
                                            echo 'selected'; ?>>Withdrawal</option>
                                        <option value="earning" <?php if (!isset($_POST['type']) || $_POST['type'] === 'earning')
                                            echo 'selected'; ?>>Earning</option>
                                        <option value="commissions" <?php if (!isset($_POST['type']) || $_POST['type'] === 'commissions')
                                            echo 'selected'; ?>>Referral commission
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <label>From:</label>
                                </div>
                                <div class="col-md-2">
                                    <select name=month_from class="form-control">
                                        <option value=1>Jan
                                        <option value=2>Feb
                                        <option value=3>Mar
                                        <option value=4>Apr
                                        <option value=5>May
                                        <option value=6>Jun
                                        <option value=7>Jul
                                        <option value=8>Aug
                                        <option value=9>Sep
                                        <option value=10>Oct
                                        <option value=11>Nov
                                        <option value=12 selected>Dec
                                    </select> &nbsp;
                                </div>
                                <div class="col-md-2">
                                    <select name=day_from class="form-control">
                                        <option value=1>1
                                        <option value=2>2
                                        <option value=3>3
                                        <option value=4>4
                                        <option value=5>5
                                        <option value=6>6
                                        <option value=7>7
                                        <option value=8>8
                                        <option value=9>9
                                        <option value=10>10
                                        <option value=11>11
                                        <option value=12>12
                                        <option value=13>13
                                        <option value=14>14
                                        <option value=15>15
                                        <option value=16>16
                                        <option value=17>17
                                        <option value=18>18
                                        <option value=19>19
                                        <option value=20>20
                                        <option value=21>21
                                        <option value=22>22
                                        <option value=23>23
                                        <option value=24>24
                                        <option value=25>25
                                        <option value=26 selected>26
                                        <option value=27>27
                                        <option value=28>28
                                        <option value=29>29
                                        <option value=30>30
                                        <option value=31>31
                                    </select> &nbsp;
                                </div>
                                <div class="col-md-2">
                                    <select name=year_from class="form-control">
                                        <option value=2013>2013
                                        <option value=2014>2014
                                        <option value=2015>2015
                                        <option value=2016>2016
                                        <option value=2017>2017
                                        <option value=2018>2018
                                        <option value=2019>2019
                                        <option value=2020>2020
                                        <option value=2021>2021
                                        <option value=2022>2022
                                        <option value=2023 selected>2023
                                    </select><br><img src=images/q.gif width=1 height=4><br>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <img src=images/q.gif width=1 height=4><br>
                                    <select name=ec class="form-control">
                                        <option value=1008 selected>USDT TRC20</option>
                                    </select>
                                </div>

                                <div class="col-md-1">
                                    <label>To:</label>
                                </div>
                                <div class="col-md-2">
                                    <select name=month_to class="form-control">
                                        <option value=1>Jan
                                        <option value=2>Feb
                                        <option value=3>Mar
                                        <option value=4>Apr
                                        <option value=5>May
                                        <option value=6>Jun
                                        <option value=7>Jul
                                        <option value=8>Aug
                                        <option value=9>Sep
                                        <option value=10>Oct
                                        <option value=11>Nov
                                        <option value=12 selected>Dec
                                    </select> &nbsp;
                                </div>
                                <div class="col-md-2">
                                    <select name=day_to class="form-control">
                                        <option value=1>1
                                        <option value=2>2
                                        <option value=3>3
                                        <option value=4>4
                                        <option value=5>5
                                        <option value=6>6
                                        <option value=7>7
                                        <option value=8>8
                                        <option value=9>9
                                        <option value=10>10
                                        <option value=11>11
                                        <option value=12>12
                                        <option value=13>13
                                        <option value=14>14
                                        <option value=15>15
                                        <option value=16>16
                                        <option value=17>17
                                        <option value=18>18
                                        <option value=19>19
                                        <option value=20>20
                                        <option value=21>21
                                        <option value=22>22
                                        <option value=23>23
                                        <option value=24>24
                                        <option value=25>25
                                        <option value=26 selected>26
                                        <option value=27>27
                                        <option value=28>28
                                        <option value=29>29
                                        <option value=30>30
                                        <option value=31>31
                                    </select> &nbsp;
                                </div>
                                <div class="col-md-2">
                                    <select name=year_to class="form-control">
                                        <option value=2013>2013
                                        <option value=2014>2014
                                        <option value=2015>2015
                                        <option value=2016>2016
                                        <option value=2017>2017
                                        <option value=2018>2018
                                        <option value=2019>2019
                                        <option value=2020>2020
                                        <option value=2021>2021
                                        <option value=2022>2022
                                        <option value=2023 selected>2023
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-2">
                            &nbsp; <input type=submit value="Go" class="btn btn-primary">
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
                <tr>
                    <td>
                        <?php echo $type; ?>
                    </td>
                    <td>
                        <?php echo $amount; ?>
                    </td>
                    <td>
                        <?php echo $date; ?>
                    </td>
                </tr>
                <tr>
                    <?php if ($deposit > 100): ?>
                        <td colspan=3 align=center>
                            <div class="alert alert-warning m-b-lg" role="alert">
                                No transactions found
                            </div>
                        </td>
                    <?php endif; ?>
                </tr>


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