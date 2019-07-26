



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_GET['delete_user'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id =  filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    $conn->exec("DELETE FROM users WHERE id = '$id'");

    die (json_encode(array (
        "success" => true,
        "msg" => "user deleted successfully"
    )));

} elseif (isset($_GET['get_all_users'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $rows = isset($_GET['rows']) ? $_GET['rows'] : 10;
    $page =  isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $rows;

    $search = FILTER_INPUT(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

    $where = "";
    if (!empty($search)) {
        $where .= " AND `user_name` LIKE '%$search%' ";
    }

    $stmt = $conn->query("SELECT id, user_name FROM users WHERE 1=1 $where LIMIT $offset, $rows  ");


    $data = array();
    // loap through each user and assign permissions
    while ($row = $stmt->fetchObject()) {


        $stmt2 = $conn->query("SELECT 
            IFNULL(GROUP_CONCAT(user_permissions.perm_id), '') AS user_permission_ids, 
            IFNULL(GROUP_CONCAT(`permissions`.`name`), '') AS user_permission_names
            FROM user_permissions 
            LEFT JOIN `permissions` ON `permissions`.id = user_permissions.perm_id
            WHERE `user_id` = '{$row->id}'");

        

        $user_perm_data = $stmt2->fetchObject();


        $row->user_permission_ids = $user_perm_data->user_permission_ids;
        $row->user_permission_names = $user_perm_data->user_permission_names;

        array_push($data, $row);


    }




    echo json_encode ($data);





} elseif (isset($_GET['save_user_permissions'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $permissions = filter_input(INPUT_POST, 'permissions');


    if (!$user_name) {
        die(json_encode(array(
            "success" => false,
            "message" => "Please provide a valid user name: ($user_name)"
        )));
    }

    if (!$user_id && !$password) {
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




    if ($user_id > 0) { // means its a user edit

        if ($password) { // check if user requested for apassword update
            $stmt = $conn->prepare("UPDATE users SET `user_name` = :user_name , `password` = AES_ENCRYPT(:password, 'kamssa') WHERE id = :id");
            $stmt->execute([
                ':user_name' => $user_name,
                ":password" => $password,
                ":id" => $user_id
            ]);
        } else { // user is not uipdating the password
            $stmt = $conn->prepare("UPDATE users SET `user_name` = :user_name WHERE id = :id");
            $stmt->execute([
                ':user_name' => $user_name,
                ":id" => $user_id
            ]);
        }

        


    } else { // means it a new user
        $stmt = $conn->prepare("INSERT INTO users (`user_name`, `password`) 
        VALUES ( :user_name, AES_ENCRYPT(:password, 'kamssa'))");
        $stmt->execute([
            ':user_name' => $user_name,
            ":password" => $password
        ]);

        $user_id = $conn->lastInsertId();
    }
    

    // assign permissions to user
    $permissions = explode(",", $permissions);

    // make permissions unique
    $permissions = array_unique($permissions);

    // delete existing permissions for the user
    $conn->exec("DELETE FROM user_permissions WHERE `user_id` = $user_id");

    foreach ($permissions as $key => $perm_id) {
        $conn->exec("INSERT INTO `user_permissions`(`user_id`, `perm_id`) 
            VALUES ('$user_id','$perm_id')");

    }


    die(json_encode(array(
        "success" => true,
        "message" => "User Created Successfully"
    )));




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