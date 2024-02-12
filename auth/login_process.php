<?php
ini_set('display_errors', true);
error_reporting(E_ALL ^ E_NOTICE);
// login_process.php
include 'conn.php';
require_once 'GoogleAuthenticator.php';
session_start();
echo "Started";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user credentials from the form
    $username = $_POST['username'];
    $password = $_POST['password']; // Note: You should hash and verify passwords in a real scenario
    $isValidCredentials = false;

    // For the sake of illustration, let's assume the credentials are valid
    // Validate the data (you may want to add more validation)
    if (empty($username) || empty($password)) {
        // Handle validation errors
        echo "Username and password are required.";
    } else {
        // Fetch user details based on the provided username
        $getUserQuery = "SELECT * FROM userdetails WHERE username = ?";
        $stmtGetUser = $connect_db->prepare($getUserQuery);
        $stmtGetUser->bind_param("s", $username);
        $stmtGetUser->execute();
        $result = $stmtGetUser->get_result();
        // Check if the user exists
        if ($result->num_rows === 1) {
            $userDetails = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $userDetails['pass'])) {
                echo "pass verified";
                // Password is correct, user is authenticated

                // Store relevant user information in the session
                $_SESSION['user_id'] = $userDetails['id'];
                $_SESSION['username'] = $userDetails['username'];
                $username = $userDetails['username'];

                // Update or retrieve last access time
                $lastAccessTime = isset($_SESSION['last_access_time']) ? $_SESSION['last_access_time'] : null;

                // Set the current time as the last access time
                $_SESSION['last_access_time'] = time();
                if (!isset($_SESSION['authenticated'])) {

                    $query = "SELECT * FROM usertfa WHERE username = ?";
                    $stmtGetUser = $connect_db->prepare($query);
                    $stmtGetUser->bind_param("s", $username);
                    $stmtGetUser->execute();
                    $result = $stmtGetUser->get_result();
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
                            $isTFAEnabled = true; // TFA is enabled for the user
                            $_SESSION['data']=$secret;
                            header("Location: ../tfa_home.php");
                            exit();
                        }
                    }
                }

                // You can redirect to a dashboard or perform any other actions here
                $isValidCredentials = true;


                // echo "Login successful! Welcome, " . $userDetails['fullName'];
            } else {
                // Password is incorrect
                echo "Incorrect password. 🔒 Please try again.";
                $isValidCredentials = false;
            }
        } else {
            // User not found
            $isValidCredentials = false;
        }

        // Close the statement and database connection
        $stmtGetUser->close();
        $connect_db->close();
    }


    if ($isValidCredentials) {
        // Redirect to the dashboard upon successful login
        header("Location: ../index2.php");
        exit();
    } else {
        // Credentials are not valid, show an error message or redirect to the login page with an error parameter
        header("Location: ../index.php?page=login&error=1");
        exit();
    }
}
