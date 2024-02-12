<!-- index.php -->

<?php
session_start();
// Check if the user is authenticated
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle unauthenticated access
    header("Location: index.phph?home&error=login");
    exit();
}
// Get the requested page from the query parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Set the corresponding page content
switch ($page) {
    case 'dashboard':
        $pageContent = 'dashboard.php';
        break;
    case 'deposit':
        $pageContent = 'deposit.php';
        break;
    case 'mining_list':
        $pageContent = 'mining_list.php';
        break;
    case 'withdraw':
        $pageContent = 'withdraw.php';
        break;
    case 'history':
        $pageContent = 'history.php';
        break;
    case 'account':
        $pageContent = 'account.php';
        break;
    case 'referral':
        $pageContent = 'referral.php';
        break;
    case 'promotion':
        $pageContent = 'promotion.php';
        break;
    case 'security':
        $pageContent = 'security.php';
        break;
    case 'support':
        $pageContent = 'contact.php';
        break;
    case 'deposit_final':
        $pageContent = 'deposit_final.php';
        break;

        // default:
        //     $pageContent = '404.php'; // or handle as needed
        //     break;
}

// Include the template with the selected page content
include 'template.php';
?>