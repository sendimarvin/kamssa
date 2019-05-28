<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['submit'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $name = $_POST['school_name'];
    $center_no = $_POST['center_no'];
    $number_of_students = $_POST['number_of_students'];
    $district = $_POST['district'];


    if ( !empty($name) &&  !empty($center_no) && !empty($number_of_students) && !empty($district)) {


        $sql = "INSERT INTO schools (`name`, `no_of_students`, `district`, `center_no`) VALUES
        ('$name', $number_of_students, '$district', '$center_no')";

        $conn->exec($sql);

        echo "Data Successfully saved";

        header ('Location: index.php');

    }


} elseif (isset($_GET['get_all_schools'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;



    $sql = "SELECT * FROM schools WHERE 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);

}







?>