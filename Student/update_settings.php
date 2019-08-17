



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);





if (isset($_GET['add_A-level_subject'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_VALIDATE_INT);
    $subject_name = filter_input(INPUT_POST, 'subject_name', FILTER_SANITIZE_STRING);
    $subject_code = filter_input(INPUT_POST, 'subject_code', FILTER_SANITIZE_STRING);
    $no_of_papers_done = filter_input(INPUT_POST, 'no_of_papers_done', FILTER_VALIDATE_INT);
    $subject_is_core = isset($_POST['subject_is_core']) ? 1 : 0;

    $subject_id = $subject_id ? $subject_id : 0;

    if ($subject_name && $subject_code && $no_of_papers_done) {
        if ($subject_id > 0) { // means edit
            $conn->exec("UPDATE `A_level_subejcts` SET `name`='$subject_name',`subject_code`='$subject_code',`is_core`='$subject_is_core'
           WHERE `id`=$subject_id");
        } else { // means new
            $conn->exec("INSERT INTO `A_level_subejcts` SET `name`='$subject_name',`subject_code`='$subject_code',`is_core`='$subject_is_core'
            ");
            $subject_id = $conn->lastInsertId();
        }

        die (json_encode(
            array(
                'success' => true,
                'msg' => "Update Successfull",
                'id' => $subject_id
            )
        ));
    } else {
        die(json_encode(array('success'=>true,'msg'=>"Please supply all fields")));
    }
    

} elseif (isset($_GET['update_paper_A_level'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = (int) $_POST['id'];
    $subject_id = $_GET['subject'];
    $paper_code = $_POST['paper_code'];
    $is_default = (int) $_POST['is_default'];
    $paper_name = $_POST['paper_name'];
    $is_default = ($is_default) ? 1 : 0;

    if ($id && $subject_id && $paper_code && $paper_name) {
        $conn->exec("UPDATE `a_level_subejcts_papers` SET `subject_id`= '$subject_id',`paper_code`='$paper_code',`is_default`='$is_default',
            `paper_name`='$paper_name' WHERE `id`= '$id'");
        die(json_encode((array('succes'=>true, 'id'=> $id))));
    } else {
        die(json_encode((array('succes'=>false, 'msg'=> "Please supply all fields"))));
    }

} elseif (isset($_GET['save_new_paper_A_level'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject_id = $_GET['subject'];
    $paper_code = $_POST['paper_code'];
    $is_default = (int) $_POST['is_default'];
    $paper_name = $_POST['paper_name'];
    $is_default = ($is_default) ? 1 : 0;

    if ($subject_id && $paper_code && $paper_name) {
        $conn->exec("INSERT INTO `a_level_subejcts_papers`(`subject_id`, `paper_code`, `is_default`, `paper_name`) 
        VALUES ('$subject_id','$paper_code','$is_default','$paper_name')");
    }
} elseif(isset($_GET['get_A_level_papers'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject = filter_input(INPUT_GET, 'subject', FILTER_VALIDATE_INT);

    $stmt = $conn->query("SELECT * FROM a_level_subejcts_papers WHERE subject_id = $subject ");

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    
} elseif (isset($_GET['get_all_A_level_subjects'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $where = "";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " AND name LIKE '%$search%' ";
    }

    $stmt = $conn->query("SELECT * FROM a_level_subejcts WHERE 1=1 $where ");

    $results = array();

    foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $key => $row) {

        $row->subject_is_core = '';
        if ($row->is_core) {
            $row->subject_is_core = 'compulsory';
        }

        // get the papers in the subject
        $stmt2 = $conn->query("SELECT IFNULL(GROUP_CONCAT(paper_code SEPARATOR ', '), '') AS subject_papers FROM a_level_subejcts_papers WHERE subject_id = $row->id ");
        $row->subject_papers = $stmt2->fetchObject()->subject_papers;

        // get the default papers in the subject
        $stmt2 = $conn->query("SELECT IFNULL(GROUP_CONCAT(paper_code SEPARATOR ', '), '') AS subject_papers FROM a_level_subejcts_papers WHERE subject_id = $row->id AND is_default = '1'   ");
        $row->subject_default_papers = $stmt2->fetchObject()->subject_papers;



        array_push($results, $row);
    }

    echo json_encode($results);



} elseif (isset($_GET['update_paper'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = (int) $_POST['id'];
    $subject_id = $_GET['subject'];
    $paper_code = $_POST['paper_code'];
    $is_default = (int) $_POST['is_default'];
    $paper_name = $_POST['paper_name'];
    $is_default = ($is_default) ? 1 : 0;

    if ($id && $subject_id && $paper_code && $paper_name) {
        $conn->exec("UPDATE `o_level_subejcts_papers` SET `subject_id`= '$subject_id',`paper_code`='$paper_code',`is_default`='$is_default',
            `paper_name`='$paper_name' WHERE `id`= '$id'");
        die(json_encode((array('succes'=>true, 'id'=> $id))));
    } else {
        die(json_encode((array('succes'=>false, 'msg'=> "Please supply all fields"))));
    }


} elseif (isset($_GET['save_new_paper'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject_id = $_GET['subject'];
    $paper_code = $_POST['paper_code'];
    $is_default = (int) $_POST['is_default'];
    $paper_name = $_POST['paper_name'];
    $is_default = ($is_default) ? 1 : 0;

    if ($subject_id && $paper_code && $paper_name) {
        $conn->exec("INSERT INTO `o_level_subejcts_papers`(`subject_id`, `paper_code`, `is_default`, `paper_name`) 
        VALUES ('$subject_id','$paper_code','$is_default','$paper_name')");
    }


} elseif(isset($_GET['get_o_level_papers'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject = filter_input(INPUT_GET, 'subject', FILTER_VALIDATE_INT);

    $stmt = $conn->query("SELECT * FROM o_level_subejcts_papers WHERE subject_id = $subject ");

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    
} elseif (isset($_GET['delete_subject'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    // get pap
    $stmt = $conn->query("SELECT COUNT(*) AS counts FROM o_level_subejcts_papers RIGHT JOIN o_level_student_marks ON o_level_student_marks.subject_paper_id = o_level_subejcts_papers.id WHERE o_level_subejcts_papers.subject_id = $subject_id ");


    // echo $stmt->fetchObject()->counts;

    if ($stmt->fetchObject()->counts > 0) {
        die(json_encode(array('success'=>false, 'msg'=>"Some papers in the subject are already assigned to students")));
    } else {
        $conn->exec("DELETE FROM o_level_subejcts_papers WHERE  subject_id = $subject_id ");
        $conn->exec("DELETE FROM o_level_subejcts WHERE  id = $subject_id ");
        die(json_encode(array('success'=>true, 'msg'=>"Update successfull")));
    }

} elseif (isset($_GET['add_o-level_subject'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_VALIDATE_INT);
    $subject_name = filter_input(INPUT_POST, 'subject_name', FILTER_SANITIZE_STRING);
    $subject_code = filter_input(INPUT_POST, 'subject_code', FILTER_SANITIZE_STRING);
    $no_of_papers_done = filter_input(INPUT_POST, 'no_of_papers_done', FILTER_VALIDATE_INT);
    $subject_is_core = isset($_POST['subject_is_core']) ? 1 : 0;

    $subject_id = $subject_id ? $subject_id : 0;


    if ($subject_name && $subject_code && $no_of_papers_done) {
        if ($subject_id > 0) { // means edit
            $conn->exec("UPDATE `o_level_subejcts` SET `name`='$subject_name',`subject_code`='$subject_code',`is_core`='$subject_is_core', no_of_papers_done = '$no_of_papers_done' WHERE `id`=$subject_id");
        } else { // means new
            $conn->exec("INSERT INTO `o_level_subejcts` SET `name`='$subject_name',`subject_code`='$subject_code',`is_core`='$subject_is_core', no_of_papers_done = '$no_of_papers_done'");
            $subject_id = $conn->lastInsertId();
        }

        die (json_encode(
            array(
                'success' => true,
                'msg' => "Update Successfull",
                'id' => $subject_id
            )
        ));
    } else {
        die(json_encode(array('success'=>true,'msg'=>"Please supply all fields")));
    }
    

} elseif (isset($_GET['get_all_o_level_subjects'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $where = "";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " AND combination LIKE '%$search%' ";
    }

    $stmt = $conn->query("SELECT * FROM o_level_subejcts WHERE 1=1 ");

    $results = array();

    foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $key => $row) {

        $row->subject_is_core = '';
        if ($row->is_core) {
            $row->subject_is_core = 'compulsory';
        }

        // get the papers in the subject
        $stmt2 = $conn->query("SELECT IFNULL(GROUP_CONCAT(paper_code SEPARATOR ', '), '') AS subject_papers FROM o_level_subejcts_papers WHERE subject_id = $row->id ");
        $row->subject_papers = $stmt2->fetchObject()->subject_papers;

        // get the default papers in the subject
        $stmt2 = $conn->query("SELECT IFNULL(GROUP_CONCAT(paper_code SEPARATOR ', '), '') AS subject_papers FROM o_level_subejcts_papers WHERE subject_id = $row->id AND is_default = '1'   ");
        $row->subject_default_papers = $stmt2->fetchObject()->subject_papers;



        array_push($results, $row);
    }

    echo json_encode($results);



} elseif (isset($_GET['delete_combination'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $combination_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    // check if their are users on combination
    $stmt = $conn->query("SELECT COUNT(*) AS availability FROM a_level_students WHERE combination_id = '$combination_id'");
    $availability = $stmt->fetchObject()->availability;

    if ($availability > 0) {
        die(json_encode(array('success'=>false, 'msg'=>"The combination is assigned to $availability students")));
    } else {
        $conn->exec("DELETE FROM a_level_combinations WHERE id = $combination_id");
        die(json_encode(array('success'=>true, 'msg'=>"Update successfull")));
    }

} elseIf (isset($_GET['save_combination'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $combination_id = filter_input(INPUT_POST, 'combination_id', FILTER_VALIDATE_INT);
    $combination_name = filter_input(INPUT_POST, 'combination_name', FILTER_SANITIZE_STRING);

    if (!empty($combination_name)) {
        if ($combination_id) { // edit combination instead
            $conn->exec("UPDATE `a_level_combinations` SET `combination`='$combination_name' WHERE id = $combination_id");
        } else { // add combination
            $conn->exec("INSERT INTO `a_level_combinations` SET `combination`='$combination_name'");
            $combination_id = $conn->lastInsertId();
        }
    }
    

    echo json_encode(array ('success' => true, 'msg' => "Update successfull", 'id' => $combination_id, 'combination_name' => $combination_name));


} elseif (isset($_GET['get_all_A-level_combination'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $where = "";
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $where = " AND combination LIKE '%$search%' ";
    }

    $stmt = $conn->query("SELECT * FROM a_level_combinations WHERE 1=1 $where ");

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));



} elseif (isset($_GET['delete_user'])) {
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