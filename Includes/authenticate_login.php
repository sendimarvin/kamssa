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


    $sql = " SELECT * FROM `users` WHERE `user_name` = :user_name AND `password` = AES_ENCRYPT(:password, 'kamssa') ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":user_name" => $user_name,
        ":password" => $password
    ]);

    

    $result = $stmt->fetchAll(PDO::FETCH_OBJ);


    $user_found = false;
    foreach ($result as $row) {
        $user_found = true;
        $_SESSION['username'] = $user_name;

        // set user permissions
        $stmt2 = $conn->query("SELECT *, 
        IF((SELECT COUNT(*) FROM user_permissions WHERE user_permissions.perm_id = `permissions`.id AND `user_id` = {$row->id} ) > 0 , 1, 0) AS access
        FROM `permissions` 
        WHERE 1");
        

        foreach ($stmt2->fetchAll(PDO::FETCH_OBJ) as $key => $value) {
            if ($value->access <> 1) {
                $_SESSION[$value->name] = false;
            } else {
                $_SESSION[$value->name] = true;
            }
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