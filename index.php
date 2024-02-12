<!-- index.php -->

<?php
// Get the requested page from the query parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Set the corresponding page content
switch ($page) {
    case 'home':
        $pageContent = 'home.html';
        break;
    case 'about':
        $pageContent = 'about.html';
        break;
    case 'faq':
        $pageContent = 'faq.html';
        break;
    case 'pricing':
        $pageContent = 'pricing.html';
        break;
    case 'support':
        $pageContent = 'contact.php';
        break;
    case 'signup':
        $pageContent = 'register.html';
        break;
    case 'login':
        $pageContent = 'login.html';
        break;
    case 'contact':
        $pageContent = 'contact.html';
        break;
    case 'rules':
        $pageContent = 'rules.html';
        break;
    case 'privacy':
        $pageContent = 'privacy.html';
        break;
    case 'forgot_password':
        $pageContent = 'forget.html';
        break;
    case 'reset_password':
        $pageContent = 'reset_password.php';
        break;
    case 'reset_success':
        $pageContent = 'password_reset_success.php';
        break;
        // default:
        //     $pageContent = '404.html'; // or handle as needed
        //     break;
}

// Include the template with the selected page content
include 'template_home.php';
?>