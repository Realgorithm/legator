<style>
    /* Style for the pop-up notification */
    #copyNotification {
        display: none;
        padding: 5px;
        background-color: #4CAF50;
        color: #fff;
        border-radius: 5px;
    }
</style>
<script>
    showGetMessage('use', '1', ' you already use this transaction id or wrong transaction id', 'danger');
    showGetMessage('use', '1', ' you already use this image or change the name and upload', 'warninhg');

    function validateId(action) {
        var enteredTransId = document.getElementById('depositid').value;
        var validTransactionId = isValidTransactionId(enteredTransId);
        var fileInput = document.getElementById('image');
        var selectedFile = fileInput.files[0];
        document.getElementById('upload').value = 'upload';
        // Check if the entered amount is a valid number
        if (!validTransactionId) {
            // errorMessage.innerHTML = "Please enter a valid amount."
            showErrorMessage('Please enter a Correct transaction id.', 'danger')
        } else if (!selectedFile) {
            // Display an error message
            showErrorMessage('Please select an image before uploading.', 'warning')
        } else {
            showErrorMessage('your transaction is under processing....', 'success')
            submitForm(action)

        }
    }

    function submitForm(action) {
        // Clear previous error messages
        // document.getElementById('errorMessage').innerHTML = "processing";
        // Set the value of a hidden input field in the form
        document.getElementById('save').value = 'save';

        document.getElementById('spendform').action = action;
        // Submit the form
        document.getElementById('spendform').submit();
    }

    function isValidTransactionId(transactionId) {
        // Step 1: Check length
        if (transactionId.length !== 64) {
            return false;
        }

        // Step 2: Check if it is a valid hexadecimal string
        const isValidHex = /^[0-9a-fA-F]+$/.test(transactionId);

        return isValidHex;
    }
</script>
<script>
    function copyTextToClipboard() {
        // Get the text content
        const textToCopy = document.getElementById('copyText').innerText;

        // Create a temporary textarea element
        const textarea = document.createElement('textarea');
        textarea.value = textToCopy;

        // Append the textarea to the document
        document.body.appendChild(textarea);

        // Select the text in the textarea
        textarea.select();
        textarea.setSelectionRange(0, 99999); // For mobile devices

        // Execute the copy command
        document.execCommand('copy');

        // Remove the temporary textarea
        document.body.removeChild(textarea);

        // // Provide visual feedback to the user (optional)
        // alert('Text copied to clipboard: ' + textToCopy);

        // Display the pop-up notification
        const copyNotification = document.getElementById('copyNotification');
        copyNotification.style.display = 'inline';

        // Hide the pop-up after 1 second (1000 milliseconds)
        setTimeout(function() {
            copyNotification.style.display = 'none';
        }, 1000);
    }
</script>

<div class="card">
    <h5 class="card-header bg-primary text-white">Please confirm your deposit</h5>
    <div class="card-body">
        <br><br>
        Hello Kindly click and copy the TRC20 address below and make deposit then save deposit to start
        earning<br><br>
        <div>
            <span id="copyText" onclick="copyTextToClipboard()">TRCaFDAoRMmKvQPSDsJ1JdqhoQgioRhSXF</span>
            <!-- Pop-up notification div -->
            <span id="copyNotification">Copied!</span>
        </div><br>

        <!-- process_1008.php -->
        <?php
        // Retrieve form data and error from session
        $depositData = isset($_SESSION['deposit_data']) ? $_SESSION['deposit_data'] : [];
        // Clear session data to prevent displaying old data
        // unset($_SESSION['deposit_data']);
        // Get the selected plan from the form data
        $selectedPlan = $depositData['h_id'];
        $depositAmount = $depositData['amount'];
        $errorMessage = '';
        $successMessage = '';

        // Render data based on the selected plan
        switch ($selectedPlan) {
            case '1':
                // Render data for Plan 1
                $plan = "FIRST ";
                $profit = "140% in 30 days";
                $planNo = 1;
                break;

            case '2':
                // Render data for Plan 2
                $plan = "SECOND ";
                $profit = "180% in 30 days";
                $planNo = 2;
                break;

            case '3':
                // Render data for Plan 3
                $plan = "THIRD ";
                $profit = "200% in 30 days";
                $planNo = 3;
                break;

            default:
                // Handle other cases or show an error
                $data = "Invalid plan selected";
        }

        echo '<div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th>Plan:</th>
                                                    <td>' . $plan . 'PLAN</td>
                                                </tr>
                                                <tr>
                                                    <th>Profit:</th>
                                                    <td>' . $profit . '</td>
                                                </tr>
                                                <tr>
                                                    <th>Withdrawal fee:</th>
                                                    <td>
                                                        Available with
                                                        5% withdrawal fee </td>
                                                </tr>
                                                <tr>
                                                    <th>Compound:</th>
                                                    <td>0%</td>
                                                </tr>

                                                <tr>
                                                    <th>Amount:</th>
                                                    <td>' . $depositAmount . '</td>
                                                </tr>
                                                
                                            </table>
                                        </div>';


        ini_set('display_errors', true);
        error_reporting(E_ALL ^ E_NOTICE);
        include 'auth/upload.php'
        ?>
        <form id="spendform" name=spend method=post enctype=multipart/form-data>
            <table class="table">
                <tr>
                    <th>Transaction Id:</th>
                    <td>
                        <input type="text" name=amount value=<?php echo $depositAmount ?> hidden>
                        <input type="text" name=plan value=<?php echo $planNo ?> hidden>
                        <input type="hidden" id="upload" name="upload">
                        <input type="hidden" id="save" name="save">
                        <input type=text id=depositid name=depositid value='' class="form-control" size=15 placeholder="Enter the transaction id">
                    </td>
                </tr>
            </table>
            <table class="table">
                <tr>
                    <label for="image">
                        <th>Select Image:</th>
                    </label>
                    <td>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control">
                        <!-- <br><input type="button" value="Upload Image" onclick="submitImage()" class="btn btn-primary ml-auto"> -->
                    </td>
                </tr>
            </table>

            <br><input type=button value="Save" onclick="validateId('auth/deposit_auth.php')" class="btn btn-primary ml-auto">
            &nbsp;
            <input type=button class="btn btn-primary ml-auto" value="Cancel" onclick="document.location='index2.php?page=deposit'">

        </form>
        <?php if ($successMessage != "") { ?>
            <script>
                showErrorMessage('<?php echo $successMessage ?>', 'success')
            </script>
        <?php } elseif ($errorMessage != "") { ?>
            <script>
                showErrorMessage('<?php echo $errorMessage ?>', 'warning')
            </script>
        <?php } ?>
        <!-- Hidden input field to store the button value -->
    </div>
</div>