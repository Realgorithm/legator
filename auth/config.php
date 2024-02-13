<?php
// Define the path to the configuration file
$configFile = 'E:\Xampp\htdocs\legator-final\legator\auth\Config\config.ini';

// Check if the configuration file exists
if (file_exists($configFile)) {
    // Load the configuration
    $config = parse_ini_file($configFile, true);

    // Access database configuration
    $dbHost = $config['database']['host'];
    $dbUser = $config['database']['username'];
    $dbPass = $config['database']['password'];
    $dbName = $config['database']['database'];

    // Access SMTP configuration
    $smtpHost = $config['smtp']['host'];
    $smtpPort = $config['smtp']['port'];
    $smtpUser = $config['smtp']['username'];
    $smtpPass = $config['smtp']['password'];
    $smtpEncryption = $config['smtp']['encryption'];

    // Use the retrieved credentials for database and SMTP connections
} else {
    die('Configuration file not found.');
}
