



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);






if (isset($_GET['save_user_permissions'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $user_name = filter_input(INPUT_POST, 'user_name'. FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password'. FILTER_SANITIZE_STRING);
    $permissions = filter_input(INPUT_POST, 'password');


    if (!$user_name) {
        die(json_encode(array(
            "success" => false,
            "message" => "Please provide a valid user name"
        )));
    }

    if (!$password) {
        die(json_encode(array(
            "success" => false,
            "message" => "Please provide a valid password"
        )));
    }

    if (!$permissions) {
        die(json_encode(array(
            "success" => false,
            "message" => "Please provide atlaest one permission"
        )));
    }


    // first inset the user and get the insert id



    $stmt = $conn->prepare("INSERT INTO users (`user_name`, `password`) VALUES ( :user_name, :password)");
    $stmt->execute([
        ':user_name' => $user_name,
        ":password" => "AES_ENCRPT('$password', 'kamssa')"
    ]);

    $user_id = $conn->lastInsertId();

    // assign permissions to user
    $permissions = explode(",", $permissions);

    // delete existing permissions for the user
    $conn->exec("DELETE FROM user_permissions WHERE user_id = $user_id");

    foreach ($permissions as $key => $perm_id) {
        
        # code...
    }




} elseif (isset($_GET['get_user_permissions'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $stmt = $conn->query("SELECT * FROM permissions WHERE 1=1");
    echo json_encode($stmt->fetchAll(PDO::FETCH_OBJ));



} else {

    echo "invalid access";
}




?>