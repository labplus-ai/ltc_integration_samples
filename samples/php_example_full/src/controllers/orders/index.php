<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login');
    exit();
}

include "template.php";
?>
