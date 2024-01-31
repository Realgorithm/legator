<?php
//connecting to the Database
$serverName ="localhost";
$userName = "root";
$password = "2508";

//create a connection
$conn = mysqli_connect($serverName, $userName, $password);
if (mysqli_connect_errno()) {  
    printf("There is an issue occured. sorry for your inconvience", mysqli_connect_error());
    exit(1);
}
// Create a new database
$databaseName = "legator";
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $databaseName";

if (mysqli_query($conn, $sqlCreateDatabase)) {
    
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

$connect_db = mysqli_connect($serverName,$userName,$password,$databaseName);
$userDetails = "userdetails";
$userInformation = "userinformation";
$sqlCreateTable ="CREATE TABLE IF NOT EXISTS `userdetails` (`id` INT NOT NULL AUTO_INCREMENT , `fullName` VARCHAR(30) NOT NULL , `email` VARCHAR(40) NOT NULL , `pass` VARCHAR(64) NOT NULL , `username` VARCHAR(20) NOT NULL , `accountno` VARCHAR(40) NOT NULL , `isaccountset` BOOLEAN NOT NULL DEFAULT FALSE , `registration_timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), UNIQUE (`username`)) ENGINE = InnoDB";
if (mysqli_query($connect_db, $sqlCreateTable)) {
}
else{
    echo"Error creating table: ". mysqli_error($conn);
}
$createTable ="CREATE TABLE IF NOT EXISTS `userinformation` (`total_balance` FLOAT NOT NULL , `username` VARCHAR(30) NOT NULL , `earning` FLOAT NOT NULL , `withdraw` FLOAT NOT NULL , `pending_withdraw` FLOAT NOT NULL , `deposit` FLOAT NOT NULL , `referal` INT NOT NULL , `rigs` FLOAT NOT NULL , `lastacess` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ) ENGINE = InnoDB";
if(!mysqli_query($connect_db,$createTable)){
    echo"Error creating table: ". mysqli_error($conn);
}
// Close the connection
mysqli_close($conn);
?>