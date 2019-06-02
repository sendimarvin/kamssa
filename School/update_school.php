<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['school_name'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = $_POST['school_id'];
    $name = $_POST['school_name'];
    $center_no = $_POST['center_no'];
    $number_of_students = $_POST['number_of_students'];
    $district = $_POST['district'];
    


    if ( !empty($name) &&  !empty($center_no) && !empty($number_of_students) && !empty($district)) {

        //check if edit school
        $sql;
        if ($id > 0) { //update school with information
            $sql = "UPDATE schools SET name = '$name', 
            no_of_students = $number_of_students, 
            district = '$district', center_no = '$center_no' WHERE id = $id;  ";

        } else { //means new school
            $sql = "INSERT INTO schools (`name`, `no_of_students`, `district`, `center_no`) VALUES
            ('$name', $number_of_students, '$district', '$center_no')";

        }
        
        $conn->exec($sql);

        echo "Data Successfully saved";

        header ('Location: index.php');

    }


} elseif (isset($_GET['get_all_schools'])) {

    //request params
    $rows = isset($_GET['rows']) ? $_GET['rows'] : 10;
    $page =  isset($_GET['page']) ? $_GET['page'] : 1;
    $search =  isset($_GET['search']) ? $_GET['search'] : 1;

    $offset = ($page - 1) * $rows;

    $where = " (`name` LIKE '%$search%' OR `district` LIKE '%$search%' OR `center_no` LIKE '%$search%' ) LIMIT $offset, $rows  "; 


    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    //get total schools available in the system
    $sql = "SELECT COUNT(*) AS counts FROM schools WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $totals = $stmt->fetchObject()->counts;


    $sql = "SELECT * FROM schools WHERE $where ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode(
        array(
            "rows" => $rows,
            "totals" => $totals
        )
    );

} elseif (isset($_GET['delete_school'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    $sql = "DELETE FROM schools WHERE id = $id ";
    $stmt = $conn->exec($sql);
    echo json_encode(
        array(
            "success" => true
        )
    );
}







?>