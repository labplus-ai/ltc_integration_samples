<?php
session_start();
$username = 'labplus';
$password = 'veryStrongPassword';

$enteredUsername = isset($_POST['username']) ? $_POST['username'] : '';
$enteredPassword = isset($_POST['password']) ? $_POST['password'] : '';

if ($enteredUsername === $username && $enteredPassword === $password) {
    $_SESSION['loggedIn'] = true;
    header('Location: orders');
    exit();
}

include "template.php"
?>
