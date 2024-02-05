<?php
error_reporting(E_ALL);
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();
session_unset();

// Ensure that pages are not cached
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Additional headers to prevent caching
header("Cache-Control: post-check=0, pre-check=0", false);
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

// Redirect to the login page with a random query parameter
$redirectUrl = "../index.php?page=home&nocache=" . uniqid();
header("Location: $redirectUrl");
exit();
?>
