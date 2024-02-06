<?php 
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);
include 'auth/user_details.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Store form data and error in session
    $_SESSION['deposit_data'] = $_POST;
    header("Location: index2.php?page=deposit_final");
    exit();
}

?>

<script language="javascript">
    showGetMessage('success', '1', 'The deposit has been saved. It will become active when the administrator checks statistics.', 'success');
    showGetMessage('error', '1', ' Your deposit is not complete for some reason. Please contact the support.', 'warning');
    function updateCompound() {
        var id = 0;
        var tt = document.spendform.h_id.type;
        if (tt && tt.toLowerCase() == 'hidden') {
            id = document.spendform.h_id.value;
        } else {
            for (i = 0; i < document.spendform.h_id.length; i++) {
                if (document.spendform.h_id[i].checked) {
                    id = document.spendform.h_id[i].value;
                }
            }
        }

        var cpObj = document.getElementById('compound_percents');
        if (cpObj) {
            while (cpObj.options.length != 0) {
                cpObj.options[0] = null;
            }
        }

        if (cps[id] && cps[id].length > 0) {
            document.getElementById('coumpond_block').style.display = '';

            for (i in cps[id]) {
                cpObj.options[cpObj.options.length] = new Option(cps[id][i]);
            }
        } else {
            document.getElementById('coumpond_block').style.display = 'none';
        }
    }
    var cps = {};

    function validateAmount() {
        var enteredAmount = parseFloat(document.getElementById('amount').value);
        var errorMessage = document.getElementById('errorMessage');
        var minimum = document.getElementById('amount').value;

        // Check if the entered amount is a valid number
        if (isNaN(enteredAmount) || enteredAmount <= 0) {
            // errorMessage.innerHTML = "Please enter a valid amount.";
            showErrorMessage('Please enter a valid amount.', 'danger')

        } else {
            var selectedPlan = document.spendform.h_id.value;
            var successMsg = showErrorMessage('Your deposit is under process please wait....', 'success')

            // Validate amount based on the selected plan
            switch (selectedPlan) {
                case '1':
                    if (enteredAmount > 7999 || enteredAmount < 100) {
                        // errorMessage.innerHTML = "Invalid amount or choose a different plan.";
                        showErrorMessage('Invalid amount or choose a different plan1.', 'danger')
                    } else {
                        submitForm();
                    }
                    break;

                case '2':
                    if (enteredAmount > 15000 || enteredAmount < 8000) {
                        // errorMessage.innerHTML = "Invalid amount or choose a different plan.";
                        showErrorMessage('Invalid amount or choose a different plan2.', 'danger')
                    } else {
                        submitForm();
                    }
                    break;

                case '3':
                    if (enteredAmount < 15000) {
                        // errorMessage.innerHTML = "Invalid amount or choose a different plan.";
                        showErrorMessage('Invalid amount or choose a different plan.', 'danger')
                    } else {
                        submitForm();
                    }
                    break;

                default:
                    errorMessage.innerHTML = "Invalid plan selected.";
            }
        }
    }

    function submitForm() {
        // Clear previous error messages
        document.getElementById('errorMessage').innerHTML = "";
        // Submit the form
        document.getElementById('depositForm').submit();
    }
</script>

<br>

<div class="card">
    <h5 class="card-header bg-primary text-white">Deposit</h5>
    <div class="card-body">
        <form id="depositForm" method=post action="deposit.php" name="spendform">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan=3>
                            <input type=radio name=h_id value='1' checked onclick="updateCompound()">
                            <!--	<input type=radio name=h_id value='1'  checked  onclick="document.spendform.compound.disabled=false;"> -->

                            <b>FIRST PLAN</b>
                        </td>
                    </tr>
                    <tr>
                        <td class=inheader>Plan</td>
                        <td class=inheader width=200>Spent Amount ($)</td>
                        <td class=inheader width=100 nowrap>
                            <nobr>Total Profit (%)</nobr>
                        </td>
                    </tr>
                    <tr>
                        <td class=item>Plan 1</td>
                        <td class=item align=left>$100.00 - $7000.00</td>
                        <td class=item align=right>140</td>
                    </tr>

                </table><br><br>
                <script>
                    cps[1] = [0];
                </script>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan=3>
                            <input type=radio name=h_id value='2' onclick="updateCompound()">
                            <!--	<input type=radio name=h_id value='2'  onclick="document.spendform.compound.disabled=false;"> -->

                            <b>SECOND PLAN</b>
                        </td>
                    </tr>
                    <tr>
                        <td class=inheader>Plan</td>
                        <td class=inheader width=200>Spent Amount ($)</td>
                        <td class=inheader width=100 nowrap>
                            <nobr>Total Profit (%)</nobr>
                        </td>
                    </tr>
                    <tr>
                        <td class=item>Plan 2</td>
                        <td class=item align=right>$7999.00 - $15000.00</td>
                        <td class=item align=right>180</td>
                    </tr>
                </table><br><br>
                <script>
                    cps[2] = [0];
                </script>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan=3>
                            <input type=radio name=h_id value='3' onclick="updateCompound()">
                            <!--	<input type=radio name=h_id value='3'  onclick="document.spendform.compound.disabled=false;"> -->

                            <b>THIRD PLAN</b>
                        </td>
                    </tr>
                    <tr>
                        <td class=inheader>Plan</td>
                        <td class=inheader width=200>Spent Amount ($)</td>
                        <td class=inheader width=100 nowrap>
                            <nobr>Total Profit (%)</nobr>
                        </td>
                    </tr>
                    <tr>
                        <td class=item>Plan 3</td>
                        <td class=item align=right>$15999.00 - &infin;</td>
                        <td class=item align=right>200</td>
                    </tr>
                </table><br><br>
                <script>
                    cps[3] = [0];
                </script>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Your account balance ($):</td>
                        <td align=right>$<?php echo $totalAmount ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align=right>
                            <small>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td>Amount to Spend ($):</td>
                        <td><input type=text id=amount name=amount
                                value="<?php echo isset($depositData['amount']) ? $depositData['amount'] : ''; ?>"
                                class="form-control" placeholder="Enter the amount here"size=15></td>
                    </tr>
                    <tr id="coumpond_block" style="display:none">
                        <td>Compounding(%):</td>
                        <td a>
                            <select name="compound" class=inpts id="compound_percents"></select>
                        </td>
                    </tr>

                    <tr>
                        <td colspan=2><input type=radio name=type value="deposit" checked="checked">Spend funds
                            from USDT ERC20</td>

                    </tr>
                    <tr>
                        <td colspan=2><input type="button" value="Deposit" class="btn btn-primary ml-auto"
                                onclick="validateAmount()">
                        </td>
                    </tr>
                </table>
                <!-- Display an error message -->
                <div id="errorMessage" style="color: red;"></div>
            </div>
        </form>

        <script language=javascript>
            for (i = 0; i < document.spendform.type.length; i++) {
                if ((document.spendform.type[i].value.match(/^deposit/))) {
                    document.spendform.type[i].checked = true;
                    break;
                }
            }
            updateCompound();
        </script>


    </div>
</div>