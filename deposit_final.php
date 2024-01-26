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

    function validateId(action) {
        var enteredTransId = document.getElementById('depositid').value;
        var validTransactionId = isValidTransactionId(enteredTransId);
        var fileInput = document.getElementById('image');
        var selectedFile = fileInput.files[0];
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

    function submitImage() {
        // Get the selected file
        var fileInput = document.getElementById('image');
        var selectedFile = fileInput.files[0];
        document.getElementById('hiddenInput').value = 'upload';
        document.getElementById('spendform').action = 'index2.php?page=deposit_final'

        // Check if a file is selected
        if (selectedFile) {
            // Perform the file upload or submission logic here
            document.getElementById('spendform').submit();
            return true;
        } else {
            // Display an error message
            showErrorMessage('Please select an image before uploading.', 'warning')
            return false;
        }
    }

    function submitForm(action) {
        // Clear previous error messages
        // document.getElementById('errorMessage').innerHTML = "processing";
        // Set the value of a hidden input field in the form
        document.getElementById('hiddenInput').value = 'save';

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
        setTimeout(function () {
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // if (($_POST['hiddenInput']) === 'upload') {
            // Database connection
            include 'auth/conn.php';
            // Handle file upload
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $errorMessage = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                $errorMessage .= "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size (adjust the size according to your requirements)
            if ($_FILES["image"]["size"] > 500000) {
                $errorMessage .= "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                $errorMessage .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errorMessage .= "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    // File uploaded successfully, now insert into database
                    $imagePath = $targetFile;  // store this path in the database
        
                    // Insert image path into the database (customize your SQL query)
                    $sql = "INSERT INTO images (image_path) VALUES (?)";
                    $stmt = $connect_db->prepare($sql);
                    $stmt->bind_param("s", $imagePath);
                    if ($stmt->execute()) {
                        $successMessage .= "Image uploaded and stored in the database.";
                    } else {
                        echo "Error: " . $sql . "<br>" . $stmt->error;
                    }
                } else {
                    $errorMessage .= "Sorry, there was an error uploading your file.";

                }
            }

            // Close the database connection
            $connect_db->close();
        }
        // }
        ?>
        <form id="spendform" name=spend method=post enctype=multipart/form-data>
            <table class="table">
                <tr>
                    <th>Transaction Id:</th>
                    <td>
                        <input type="text" name=amount value=<?php echo $depositAmount ?> hidden>
                        <input type="text" name=plan value=<?php echo $planNo ?> hidden>
                        <input type="hidden" id="hiddenInput" name="hiddenInput">
                        <input type=text id=depositid name=depositid value='' class="form-control" size=15
                            placeholder="Enter the transaction id">
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
                        <br><input type="button" value="Upload Image" onclick="submitImage()"
                            class="btn btn-primary ml-auto">
                    </td>
                </tr>
            </table>

            <br><input type=button value="Save" onclick="validateId('auth/deposit_auth.php')"
                class="btn btn-primary ml-auto">
            &nbsp;
            <input type=button class="btn btn-primary ml-auto" value="Cancel"
                onclick="document.location='index2.php?page=deposit'">

        </form>
        <?php if ($successMessage != "") { ?>
            <script> showErrorMessage('<?php echo $successMessage ?>', 'success')</script>
        <?php } elseif ($errorMessage != "") { ?>
            <script> showErrorMessage('<?php echo $errorMessage ?>', 'warning')</script>
        <?php } ?>
        <!-- Hidden input field to store the button value -->
    </div>
</div>