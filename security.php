<?php
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header('Location: index.php?page=login');
    exit();
}

require_once 'auth/GoogleAuthenticator.php';
require_once 'auth/conn.php';

$username = $_SESSION['username'];

// Get the user's TFA information from the database
$query = "SELECT * FROM usertfa WHERE username = ?";
$stmtGetUser = $connect_db->prepare($query);
$stmtGetUser->bind_param("s", $username);
$stmtGetUser->execute();
$result = $stmtGetUser->get_result();
// Initialize variables for secret key and QR code URL
$secret = '';
$qrCodeUrl = '';
$isTFAEnabled = false; // Flag to track if TFA is enabled for the user

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $encryptedSecretKey = $row['secretkey'];
    $hexKey1 = getenv('ENCRYPTION_KEY');
    $encryptionKey1 = hex2bin($hexKey1);

    // Decrypt the secret key if it exists
    if ($encryptedSecretKey !== null) {
        $decryptedSecretKey = openssl_decrypt($encryptedSecretKey, 'aes-128-cbc', $encryptionKey1, 0, $encryptionKey1);
        $secret = $decryptedSecretKey;
        $qrCodeUrl = '';
        $isTFAEnabled = true; // TFA is enabled for the user
    }
}

// If the secret key doesn't exist or is empty, generate a new one
if (empty($secret)) {
    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('legator', $secret);
}
?>


<script>
    showGetMessage('error', '1', 'An error occurred. 😕 Please try again.', 'warning');
    showGetMessage('success', '1', 'Your two-factor authentication has been activated! 🛡️', 'success');
    showGetMessage('error', '2', 'Invalid TFA code. Please try again. 🚫🔒', 'danger');

    function sensitivityChanged() {
        var sensitivity = document.querySelector('input[name="ip"]:checked');
        console.log("Selected Sensitivity: " + sensitivity.value);
        // Here you can implement the logic to handle the selected sensitivity
        // For example, you can make an AJAX request to the server with the selected sensitivity
        switch (sensitivity.value) {
            case "disabled":
                showErrorMessage("IP change detection disabled", "danger");
                break;
            case "medium":
                showErrorMessage("Medium sensitivity selected", "warning");
                break;
            case "high":
                showErrorMessage("High sensitivity selected", "success");
                break;
            case "always":
                showErrorMessage("Paranoic sensitivity selected", "success");
                break;
            default:
                showErrorMessage("Unknown sensitivity level", "warning");
                break;
        }

        // Reset all radio buttons to unchecked
        document.querySelectorAll('input[name="ip"]').forEach(function(radio) {
            radio.checked = false;
        });

        // Set the selected radio button to checked
        sensitivity.checked = true;

    }
    // Disable the "Enable" button once clicked
    function isEnabled() {
        var div = document.getElementById("disable");
        div.style.display = "none";
    }

    function isdisabled() {
        var div = document.getElementById("enable");
        div.style.display = "none";
    }

    function browserChanged() {
        var browser = document.querySelector('input[name="browser"]:checked');
        switch (browser.value) {
            case "disabled":
                showErrorMessage("Browser Detection disabled", "danger");
                break;
            case "enabled":
                showErrorMessage("Browser Detection enabled", "success");
                break;
            default:
                showErrorMessage("please select any one", "warning");
                break;
        }
        // Reset all radio buttons to unchecked
        document.querySelectorAll('input[name="browser"]').forEach(function(radio) {
            radio.checked = false;
        });
        // Set the selected radio button to checked
        browser.checked = true;
    }
</script>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3 class="card-header bg-primary text-white">Advanced login security settings:</h3><br><br>

                <form method=post>
                    <input type=hidden name=a value="security">
                    <input type=hidden name=action value="save">
                    <h5>Detect IP Address Change Sensitivity</h5>
                    <input type=radio name=ip value=disabled>Disabled<br>
                    <input type=radio name=ip value=medium>Medium<br>
                    <input type=radio name=ip value=high>High<br>
                    <input type=radio name=ip value=always>Paranoic<br><br>
                    <input type=button onclick="sensitivityChanged()" value="&nbsp;&nbsp;  Save  &nbsp;&nbsp;" class="btn btn-primary"><br><br>

                    <h5>Detect Browser Change</h5>
                    <input type=radio name=browser value=disabled>Disabled<br>
                    <input type=radio name=browser value=enabled>Enabled<br><br>
                    <input type=button onclick="browserChanged()" value=" &nbsp;&nbsp; Save  &nbsp;&nbsp;" class="btn btn-primary">
                </form><br>

                <h3 class="card-header bg-primary text-white">Two Factor Authentication</h3><br><br>

                <form method=post action="auth/tfa.php" name=mainform>
                    <input type=hidden name=time>
                    1. Install <a href="http://m.google.com/authenticator" targe=_blank>Google
                        Authenticator</a> on your mobile
                    device.<br>
                    2. Your Secret Code is: <b><?php echo $secret ?></b> <input type=hidden name="tfa_secret" value="<?php echo $secret ?>"><br><br>
                    <img src="<?php echo $qrCodeUrl ?>"><br>

                    <div id="disable">
                        3. Please enter two factor token from Google Authenticator to verify correct
                        setup:<br><br>
                        <input type=text name="code" class=form-control> <br>

                        <input type=submit onclick="checkform()" value="Enable" class="btn btn-primary">
                    </div>

                    <div id="enable">
                        <input type=button value="Enabled" class="btn btn-primary" disabled>
                    </div>


                    <?php if ($isTFAEnabled) : ?>
                        <script>
                            isEnabled();
                        </script>
                    <?php else : ?>
                        <script>
                            isdisabled();
                        </script>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script language=javascript>
    document.mainform.time.value = (new Date()).getTime();

    function checkform() {
        if (!document.mainform.code.value.match(/^[0-9]{6}$/)) {
            alert("Please type code!");
            document.mainform.code.focus();
            return false;
        }
        return true;
    }
</script>