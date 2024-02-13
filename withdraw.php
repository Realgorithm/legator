<?php include 'auth/get_user_details.php'; ?>
<?php include 'auth/user_details.php'; ?>


<script language="javascript">
    function validateWithdrawal() {
        // Get the entered amount and available amount
        var enteredAmount = parseFloat(document.getElementById('withdrawAmount').value);
        var availableAmount = parseFloat("<?php echo $withdrawal_amount ?>"); // Use PHP to print the available amount
        // Check if the entered amount is less than or equal to the available amount
        if (isNaN(enteredAmount) || enteredAmount <= 0) {
            // document.getElementById('error-message').innerHTML = "Please enter a valid amount.";
            showErrorMessage("⚠️ Please enter a valid amount.");
        } else if (enteredAmount < 200 || enteredAmount > 4000) {
            // document.getElementById('errorMessage').innerHTML = "Insufficient funds. or enter a big value";
            showErrorMessage("Insufficient funds. 🙁 Please enter an amount that is within your available balance.");
        } else {
            // Submit the form if the validation passes
            document.getElementById('error-message').innerHTML = ""; // Clear previous error messages
            document.getElementById('withdrawForm').submit();
        }
    }
</script>

<form id="withdrawForm" method=post name=mainform action="auth/withdraw.php">

    <div class="col-sm-12">
        <div class="card">
            <h5 class="card-header bg-primary text-white">Withdraw</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Total Withdrawal:</td>
                            <td>$<b>
                                    <?php echo $withdraw ?>
                                </b></td>
                        </tr>
                        <tr>
                            <td>Pending Withdrawals: </td>
                            <td>$<b>
                                    <?php echo $pending_withdraw ?>
                                </b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th></th>
                            <th scope="col">Processing</th>
                            <th>Available</th>
                            <th scope="col">Pending</th>
                            <th scope="col">Account</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td><img src="images/1008.gif" width=44 height=17 align=absmiddle> USDT ERC20</td>
                            <td><b style="color:green">$
                                    <?php echo $withdrawal_amount ?>
                                </b></td>
                            <td><b style="color:red">$
                                    <?php echo $pending_withdraw ?>
                                </b></td>
                            <td>
                                <?php if ($isAccountSet) : ?>
                                    <span>Account:
                                        <?php echo $accountNo; ?>
                                    </span>
                                <?php else : ?>
                                    <a class="badge badge-danger" href="index2.php?page=account"><i>'Not set'🚫 Please update your account</i></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($isAccountSet and $withdrawal_amount >= 100) : ?>
                                    <input type=number name=amount id="withdrawAmount" class="form-control" value='' placeholder="Enter the Amount">
                            </td>

                            <td>
                                <button class="btn btn-success" type="button" onclick="validateWithdrawal()">Withdraw</button>
                            <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <!-- Display an error message -->
                    <div id="error-message" class="error-message alert alert-success">
                        <span id="error-text"></span>
                        <span class="close-btn" onclick="closeErrorMessage()">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <?php if ($withdrawal_amount < 100) : ?>
            <div class="alert alert-warning m-b-lg" role="alert">
                💸 You have no funds available for withdrawal.
            </div>
        <?php endif; ?>
</form>