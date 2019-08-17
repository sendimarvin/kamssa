<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_GET['delete_A_level_student'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $conn->exec("DELETE FROM A_level_student_marks WHERE student_id = $id ");
    $conn->exec("DELETE FROM A_level_students WHERE id = $id ");

    echo '1';

} elseif (isset($_GET['update_A_level_student_mark'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $mark_id = $_POST['mark_id_A_level'];
    $paper_mark = $_POST['paper_mark_A_level'];

    $sql = "UPDATE `A_level_student_marks` SET marks = '$paper_mark' WHERE id= $mark_id ";

    $conn->exec($sql);
    echo '1';

} elseif (isset($_GET['get_student_subject_papers_marks_a_level'])) {

    $student_id = $_GET['student_id'];
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT MARKS.id AS id, SUBJECTS.name AS subject_name, PAPERS.paper_code, MARKS.marks 
        FROM A_level_student_marks AS MARKS 
        JOIN A_level_subejcts_papers AS PAPERS ON PAPERS.id = MARKS.subject_paper_id
        JOIN A_level_subejcts AS SUBJECTS ON SUBJECTS.id = PAPERS.subject_id
        WHERE  MARKS.student_id = $student_id ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($results);


} elseif (isset($_GET['delete_A_level_student_subject'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = $_GET['id'];
    $student_id = $_GET['student_id'];

    $conn->exec("DELETE FROM A_level_student_marks WHERE id= $id AND student_id = $student_id ");

    echo "1";

} elseif (isset($_GET['get_student_subject_papers_Alevel'])) {

    $student_id = $_GET['student_id'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $sql = "SELECT A_level_subejcts.*, 
        GROUP_CONCAT(A_level_subejcts_papers.paper_code) AS paper_codes, 
        GROUP_CONCAT(A_level_subejcts_papers.id) AS paper_ids
        FROM A_level_student_marks 
        LEFT JOIN A_level_subejcts_papers ON A_level_subejcts_papers.id = A_level_student_marks.subject_paper_id
        LEFT JOIN A_level_subejcts ON A_level_subejcts.id = A_level_subejcts_papers.subject_id
        WHERE student_id = $student_id 
        GROUP BY A_level_subejcts.id ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($results);

} elseif (isset($_GET['add_A_level_student_subject'])) {

    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $subject_papers = $_POST['papers_collection'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    // get all papers in subejct
    $sql = "SELECT GROUP_CONCAT(id) AS papers_in_subject FROM A_level_subejcts_papers WHERE subject_id = $subject_id ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $papers_in_subject = $stmt->fetchObject()->papers_in_subject;
    $papers_in_subject = ($papers_in_subject == "") ? '-1' : $papers_in_subject;

    // first delete all the papers that are not in the selection
    $sql = "DELETE FROM A_level_student_marks 
        WHERE student_id = '$student_id' 
        AND (subject_paper_id NOT IN ($subject_papers)) AND subject_paper_id IN ($papers_in_subject) ";

    
    $conn->exec($sql);

    $subject_papers = explode(',', $subject_papers);

    foreach ($subject_papers as $paper_code_id) {
        
        //check existance
        $sql = "SELECT COUNT(*) AS counts FROM A_level_student_marks WHERE student_id = '$student_id' AND subject_paper_id = $paper_code_id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $counts = $stmt->fetchObject()->counts;

        if ($counts == 0) { //add the paper to the student
            $sql = "INSERT INTO A_level_student_marks (`subject_paper_id`, `student_id`)
            VALUES ('$paper_code_id', '$student_id')";
            $conn->exec($sql);
        }

    }

    echo '1';

} elseif (isset($_GET['get_all_A_level_subejcts_papers_combo'])) {

    $subject_id = $_GET['subject_id'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM 	`A_level_subejcts_papers` WHERE subject_id = '$subject_id'  ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['get_all_A_level_subejcts_combo'])) {

    
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM 	`A_level_subejcts` WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['add_A_level_student'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    //get all field from here
    $id = filter_var($_POST['A_level_student_id'], FILTER_VALIDATE_INT);
    $school_id = filter_var($_POST['A_level_school_name'], FILTER_VALIDATE_INT);
    $first_name = filter_var($_POST['A_level_first_name'], FILTER_SANITIZE_STRING);
    $second_name = filter_var($_POST['A_level_second_name'], FILTER_SANITIZE_STRING);
    $index_no = filter_var($_POST['A_level_index_no'], FILTER_SANITIZE_STRING);
    $combination_id = filter_var($_POST['A_level_combination'], FILTER_VALIDATE_INT);


    $sql = "";
    if ($id > 0) {
        $sql = "UPDATE  A_level_students SET school_id = $school_id, first_name = '$first_name', second_name = '$second_name', index_no = '$index_no', combination_id = $combination_id WHERE id = $id ";
        $conn->exec($sql);
    } else {
        $sql = "INSERT INTO  A_level_students SET school_id = $school_id, first_name = '$first_name', second_name = '$second_name', index_no = '$index_no', combination_id = $combination_id";
        $conn->exec($sql);
        $id = $conn->lastInsertId();


        // assin general papaper to student
        $student_id = $id;
        $subject_id = "1";
        $subject_papers = "1";

        // get all papers in subejct
        $sql = "SELECT GROUP_CONCAT(id) AS papers_in_subject FROM A_level_subejcts_papers WHERE subject_id = $subject_id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $papers_in_subject = $stmt->fetchObject()->papers_in_subject;
        $papers_in_subject = ($papers_in_subject == "") ? '-1' : $papers_in_subject;

        // first delete all the papers that are not in the selection
        $sql = "DELETE FROM A_level_student_marks 
            WHERE student_id = '$student_id' 
            AND (subject_paper_id NOT IN ($subject_papers)) AND subject_paper_id IN ($papers_in_subject) ";

        
        $conn->exec($sql);

        $subject_papers = explode(',', $subject_papers);

        foreach ($subject_papers as $paper_code_id) {
            
            //check existance
            $sql = "SELECT COUNT(*) AS counts FROM A_level_student_marks WHERE student_id = '$student_id' AND subject_paper_id = $paper_code_id ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $counts = $stmt->fetchObject()->counts;

            if ($counts == 0) { //add the paper to the student
                $sql = "INSERT INTO A_level_student_marks (`subject_paper_id`, `marks`, `student_id`)
                VALUES ('$paper_code_id', -1,  '$student_id')";
                $conn->exec($sql);
            }

        }

    }

    echo $id;

} elseif (isset($_GET['get_all_A_level_students'])) {

    //request params
    $rows = isset($_GET['rows']) ? $_GET['rows'] : 10;
    $page =  isset($_GET['page']) ? $_GET['page'] : 1;
    $search =  isset($_GET['search']) ? $_GET['search'] : "";

    // search parameters
    $school_id = filter_input(INPUT_GET, 'school_id', FILTER_VALIDATE_INT);
    $extra_search = filter_input(INPUT_GET, 'extra_search', FILTER_SANITIZE_STRING);
    $where = "";
    if ($school_id) {
        $where = " AND schools.id = '{$school_id}' ";
    } 
    if ($extra_search) {
        $where .= " AND (`first_name` LIKE '%$extra_search%' OR `second_name` LIKE '%$extra_search%' OR `index_no` LIKE '%$extra_search%'  )  "; 
    }

    $offset = ($page - 1) * $rows;

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    // get total schools available in the system
    $sql = "SELECT COUNT(*) AS counts FROM A_level_students WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $totals = $stmt->fetchObject()->counts;


    // $sql = "SELECT A_level_students.*,  
    // (SELECT `name` FROM `schools` WHERE schools.id = A_level_students.school_id ) AS school_name,
    // (SELECT `center_no` FROM `schools` WHERE schools.id = A_level_students.school_id ) AS center_no
    // FROM A_level_students WHERE $where ";

    $sql = "SELECT A_level_students.*, schools.name as school_name, schools.center_no,
    a_level_combinations.combination AS combination_name
    FROM A_level_students
    LEFT JOIN schools ON schools.id = A_level_students.school_id
    LEFT JOIN a_level_combinations ON a_level_combinations.id = A_level_students.combination_id
    WHERE 1 $where  LIMIT $offset, $rows";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode(
        array(
            "rows" => $rows,
            "total" => $totals
        )
    );


} elseif (isset($_GET['add_update_school'])) {

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

        echo json_encode (
            array(
                "success" => true,
                "msg" => "Update Successfull"
            )
        );

    }


} elseif (isset($_GET['get_all_schools'])) {

    //request params
    $rows = isset($_GET['rows']) ? $_GET['rows'] : 10;
    $page =  isset($_GET['page']) ? $_GET['page'] : 1;
    $search =  isset($_GET['search']) ? $_GET['search'] : "";

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

    $data = array();

    $counter = 0;
    foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $key => $row) {
        $counter++;
        $row->id2 = $counter;
        array_push($data, $row);
    }

    echo json_encode(
        array(
            "rows" => $data,
            "total" => $totals
        )
    );

} elseif (isset($_GET['get_all_schools_combo'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM schools WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['delete_school'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    // check if there are any stdents in the school
    $stmt  = $conn->query("SELECT COUNT(*) AS `availability` FROM A_level_students WHERE school_id = $id");
    // o level school counts 
    $o_level_student_counts = $stmt->fetchObject()->availability;

    if ($o_level_student_counts > 0) {
        die( json_encode (
            [
                "success" => false,
                "message" => "There are student in O - level under this school"
            ]
        ));
    }

    // check if there are any stdents in the school
    $stmt  = $conn->query("SELECT COUNT(*) AS `availability` FROM o_level_students WHERE school_id = $id");
    // o level school counts 
    $o_level_student_counts = $stmt->fetchObject()->availability;

    if ($o_level_student_counts > 0) {
        die( json_encode (
            [
                "success" => false,
                "message" => "There are student in A-level under this school"
            ]
        ));
    }

    $sql = "DELETE FROM schools WHERE id = $id ";
    $stmt = $conn->exec($sql);
    echo json_encode(
        array(
            "success" => true,
            "message" => "School deleted successfully"
        )
    );
} elseif (isset($_GET['add_o_level_student'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    //get all field from here
    $id = filter_var($_POST['o_level_student_id'], FILTER_VALIDATE_INT);
    $school_id = filter_var($_POST['o_level_school_name'], FILTER_VALIDATE_INT);
    $first_name = filter_var($_POST['o_level_first_name'], FILTER_SANITIZE_STRING);
    $second_name = filter_var($_POST['o_level_second_name'], FILTER_SANITIZE_STRING);
    $index_no = filter_var($_POST['o_level_index_no'], FILTER_SANITIZE_STRING);


    $sql = "";
    if ($id > 0) {
        $sql = "UPDATE  o_level_students SET school_id = $school_id, first_name = '$first_name', second_name = '$second_name', index_no = '$index_no' WHERE id = $id ";
        $conn->exec($sql);
    } else {
        $sql = "INSERT INTO  o_level_students SET school_id = $school_id, first_name = '$first_name', second_name = '$second_name', index_no = '$index_no'";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        addOLevelCompulsorySubjects ($conn, $id);
    }

    echo $id;

} elseif (isset($_GET['get_all_o_level_students'])) {
    //request params
    $rows = isset($_GET['rows']) ? $_GET['rows'] : 10;
    $page =  isset($_GET['page']) ? $_GET['page'] : 1;
    $search =  isset($_GET['search']) ? $_GET['search'] : "";

    // search parameters
    $school_id = filter_input(INPUT_GET, 'school_id', FILTER_VALIDATE_INT);
    $extra_search = filter_input(INPUT_GET, 'extra_search', FILTER_SANITIZE_STRING);

    $where = "";
    if ($school_id) {
        $where .= " AND schools.id = '{$school_id}' ";
    } 
    if ($extra_search) {
        $where .= " AND (`first_name` LIKE '%$extra_search%' OR `second_name` LIKE '%$extra_search%' OR `index_no` LIKE '%$extra_search%' )  "; 
    }

    $offset = ($page - 1) * $rows;

    

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    //get total schools available in the system
    $sql = "SELECT COUNT(*) AS counts FROM o_level_students WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $totals = $stmt->fetchObject()->counts;

    // $sql = "SELECT o_level_students.*,  
    // (SELECT `name` FROM `schools` WHERE schools.id = o_level_students.school_id ) AS school_name,
    // (SELECT `center_no` FROM `schools` WHERE schools.id = o_level_students.school_id AND ) AS center_no
    // FROM o_level_students WHERE 1 $where  LIMIT $offset, $rows";

    $sql = "SELECT o_level_students.*, schools.name as school_name, schools.center_no
        FROM o_level_students
        LEFT JOIN schools ON schools.id = o_level_students.school_id
        WHERE 1 $where  LIMIT $offset, $rows";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode(
        array(
            "rows" => $rows,
            "total" => $totals
        )
    );

} elseif (isset($_GET['delete_o_level_student'])) {

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    $conn->exec("DELETE FROM o_level_student_marks WHERE student_id = $id ");
    $conn->exec("DELETE FROM o_level_students WHERE id = $id ");

    echo '1';

} elseif (isset($_GET['get_all_o_level_subejcts_combo'])) {

    
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM 	`o_level_subejcts` WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['get_all_o_level_papers'])) {


    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM 	`o_level_subejcts` WHERE 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['get_all_o_level_subejcts_papers_combo'])) {

    $subject_id = $_GET['subject_id'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT * FROM 	`o_level_subejcts_papers` WHERE subject_id = '$subject_id'  ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($rows);

} elseif (isset($_GET['add_o_level_student_subject'])) {

    $student_id = $_POST['student_id'];
    $subject_id = $_POST['student_subject_name'];
    $subject_papers = $_POST['papers_collection'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    //get all papers in subejct
    $sql = "SELECT GROUP_CONCAT(id) AS papers_in_subject FROM o_level_subejcts_papers WHERE subject_id = $subject_id ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $papers_in_subject = $stmt->fetchObject()->papers_in_subject;
    $papers_in_subject = ($papers_in_subject == "") ? '-1' : $papers_in_subject;

    //first delete all the papers that are not in the selection
    $sql = "DELETE FROM o_level_student_marks WHERE student_id = '$student_id' AND (subject_paper_id NOT IN ($subject_papers)) AND subject_paper_id IN ($papers_in_subject) ";


    
    $conn->exec($sql);

    $subject_papers = explode(',', $subject_papers);

    foreach ($subject_papers as  $paper_code_id) {
        
        //check existance
        $sql = "SELECT COUNT(*) AS counts FROM o_level_student_marks WHERE student_id = '$student_id' AND subject_paper_id = $paper_code_id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $counts = $stmt->fetchObject()->counts;

        if ($counts == 0) { //add the paper to the student
            $sql = "INSERT INTO o_level_student_marks (`subject_paper_id`, `student_id`)
            VALUES ('$paper_code_id', '$student_id')";
            $conn->exec($sql);
        }

    }

    echo '1';

} elseif (isset($_GET['get_student_subject_papers'])) {

    $student_id = $_GET['student_id'];

    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $sql = "SELECT o_level_subejcts.*, 
        GROUP_CONCAT(o_level_subejcts_papers.paper_code) AS paper_codes, 
        GROUP_CONCAT(o_level_subejcts_papers.id) AS paper_ids
        FROM o_level_student_marks 
        LEFT JOIN o_level_subejcts_papers ON o_level_subejcts_papers.id = o_level_student_marks.subject_paper_id
        LEFT JOIN o_level_subejcts ON o_level_subejcts.id = o_level_subejcts_papers.subject_id
        WHERE student_id = $student_id 
        GROUP BY o_level_subejcts.id";


    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($results);

    die;

} elseif (isset($_GET['get_student_subject_papers_marks'])) {

    $student_id = $_GET['student_id'];
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $sql = "SELECT MARKS.id AS id, SUBJECTS.name AS subject_name, PAPERS.paper_code, MARKS.marks 
        FROM o_level_student_marks AS MARKS 
        JOIN o_level_subejcts_papers AS PAPERS ON PAPERS.id = MARKS.subject_paper_id
        JOIN o_level_subejcts AS SUBJECTS ON SUBJECTS.id = PAPERS.subject_id
        WHERE  MARKS.student_id = $student_id ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($results);


} elseif (isset($_GET['delete_o_level_student_subject'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;

    $id = $_GET['id'];
    $student_id = $_GET['student_id'];

    // delete all student
    echo "DELETE FROM o_level_student_marks WHERE id= $id AND student_id = $student_id ";

    $conn->exec("DELETE FROM o_level_student_marks WHERE id= $id AND student_id = $student_id ");

    echo "1";

} elseif (isset($_GET['update_o_level_student_mark'])) {
    require '../Includes/Class/db_connect.php';
    $db_conn = new DatabaseConnection ();
    $conn = $db_conn->conn;


    $mark_id = $_POST['mark_id'];
    $paper_mark = $_POST['paper_mark'];

    $sql = "UPDATE `o_level_student_marks` SET marks = '$paper_mark' WHERE id= $mark_id ";
    

    $conn->exec($sql);
    echo '1';

}

function addOLevelCompulsorySubjects ($conn, $student_id)
{
    // get all o-level compulsory subjects from system
    $stmtx = $conn->query("SELECT * FROM  o_level_subejcts WHERE is_core = '1'");

    foreach ($stmtx->fetchAll(PDO::FETCH_OBJ) as $index => $row )
    {
        $subject_id = $row->id;
        //get all papers in subejct
        $stmt = $conn->query("SELECT * FROM o_level_subejcts_papers WHERE subject_id = $subject_id AND is_default = '1' ");

        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as  $key2 => $subject_paper) 
        {
            //check existance
            $stmt = $conn->query("SELECT COUNT(*) AS counts FROM o_level_student_marks WHERE student_id = '$student_id' AND subject_paper_id = {$subject_paper->id} ");

            if ($stmt->fetchObject()->counts == 0) { //add the paper to the student
                $conn->exec( "INSERT INTO o_level_student_marks (`subject_paper_id`, `marks`, `student_id`)
                VALUES ('{$subject_paper->id}', -1, '$student_id')");
            }
        }




    }
}






?>