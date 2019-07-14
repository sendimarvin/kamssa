<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['submit'])) { //means form data


    require 'Class/db_connect.php';


    $user_name = filter_input(INPUT_POST, "user_name", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    

    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = " SELECT * FROM `users` WHERE 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);


    $user_found = false;
    foreach ($result as $row) {
        if ( ($row->user_name == $user_name) && ($row->password == $password) ) { //user fund

            $user_found = true;
            //set session data
            $_SESSION['username'] = $user_name;

        } else {
            //continue searching
            continue;
        }
    }



    if ($user_found) { //take to home page
        header("Location: ../Student/");
    } else { //go back to index page with error
        $_SESSION['Errors'] = "User not found";
        header("Location: ../index.php");
    }








} else {
    echo "Ivalid Access! Please Use Login Page";
}

?>