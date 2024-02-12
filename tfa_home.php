<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFA Code Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #25016c;
        }

        input[type="text"] {
            width: 200px;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #verify-btn {
            padding: 7px 14px;
            background-color: #a7cd78;
            color: #25016c;
            border: none;
            border-radius: 4px;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #verify-btn:hover {
            background-color: #25016c;
            color: #ffd10f;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php
        session_start();
        require_once 'auth/GoogleAuthenticator.php';
        $secretKey=$_SESSION['data'];
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle login form submission
            $tfaCode = $_POST['code'];
             // TFA code entered by the use

            $ga = new PHPGangsta_GoogleAuthenticator();
            // Verify the TFA code entered by the user
            $isVerified = $ga->verifyCode($secretKey, $tfaCode, 2);

            if ($isVerified) {
                $_SESSION['authenticated']=true;
                header("Location: index2.php?page=dashboard");
                exit();
            } else {
                echo "<h2 style='color: red;'>Invalid TFA code. Please try again. 🚫🔒</h2>";
            }
        }
        ?>
        <h1>Verify Two-Factor Authentication Code</h1>
        <img src="images/logo.png" alt="logo">
        <h2>Legator</h2>
        <p>Enter the code from your authenticator app:</p>
        <form id="tfa-form" method="post" action="tfa_home.php" name="mainform">
            <input type="text" name="code" id="tfa-code" placeholder="Enter TFA Code" required>
            <button type="submit" onclick="checkform()" id="verify-btn">Verify Code</button>
        </form>
    </div>

    <script>

        function checkform() {
            if (!document.mainform.code.value.match(/^[0-9]{6}$/)) {
                alert("Please type code!");
                document.mainform.code.focus();
                return false;
            }
            return true;
        }
    </script>


</body>

</html>