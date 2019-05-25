<?php


if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    //invalid access
    header('Location: ../index.php');
}



?>