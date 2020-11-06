<?php  
$dsn = 'mysql:host=localhost;dbname=SACM';
$username1 = 'root';
$password1 = '';

try{
    $db = new PDO($dsn, $username1, $password1);
    $connect_message = '<p id="db_error"> You are connected to the database!</p>';
}catch (PDOException $e) {
    $error_message = $e->getMessage();
    $connect_message =  '<p id="db_error"> Connection error! : $error_message </p>';
}
?>