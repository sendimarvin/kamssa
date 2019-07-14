

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class OLevelStudentReport {

     const A_GRADE = [ '1,1,3', '1,2,3', '2,2,3', '1,1', '1,2', '2,2'];
     const B_GRADE = ['1,2,4', '2,2,4', '2,2,3', '3,3,4', '1,1,4', '3,3,3', '2,3,4', '1,2', '2,3', '3,3'];
     const C_GRADE = ['1,1,5', '1,2,5', '2,2,5', '2,3,5', '3,4,5', '4,4,5', '1,4', '2,4', '3,4', '4,4'];
     const D_GRADE = ['1,2,6', '1,1,6', '1,3,6', '2,2,6', '3,3,6', '4,5,6', '5,5,6', '1,5', '2,5', '3,5', '4,5', '5,5'];
     const E_GRADE = ['1,1,7', '1,2,7', '3,3,7'];
     const O_GRADE = ['1', '2', '3', '4', '5', '6', '1,7,7', '2,7,7', '3,7,7', '4,7,7', '5,7,7', '6,7,7', '7,7,7', '1,5', '2,5', '3,5', '4,5', '5,5'];
     const F_GRADE = [];

    // grade for core subjects
     const O_GRADE_CORE = ['A', 'B', 'C', 'D', 'E', 'O'];

    private $student_id  = 0;
    private $conn = null;

    public $student_points = 0;
    public $is_missing_core = false;

    function __construct ($db_conn, $student_id)
    {
        $this->student_id = $student_id;
        $this->conn = $db_conn;
    }

    function __destruct ()
    {
        $this->conn = null;
        $student_id  = 0;
    }

    public function getStudenDetatils ()
    {
        $sql = "SELECT STUDENTS.* 
            FROM A_level_students  AS STUDENTS
            WHERE  STUDENTS.id = {$this->student_id} ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ);
        return $results; 
    }


    public function getStudentSchoolDetails ()
    {
        $sql = "SELECT SCHOOLS.* 
            FROM A_level_students  AS STUDENTS
            JOIN schools AS SCHOOLS ON SCHOOLS.id = STUDENTS.school_id
            WHERE  STUDENTS.id = {$this->student_id} ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ);
        return $results;
    }

    public function getStudentSubjectMarks ()
    {
        //get subjects for student
        $sql = "SELECT SUBJECTS.id, SUBJECTS.name, GROUP_CONCAT(MARKS.marks SEPARATOR ',') AS paper_scores, PAPERS.subject_id, SUBJECTS.is_core
            FROM `A_level_student_marks` AS MARKS
            JOIN A_level_subejcts_papers AS PAPERS ON PAPERS.id = MARKS.subject_paper_id
            JOIN A_level_subejcts AS SUBJECTS ON SUBJECTS.id = PAPERS.subject_id
            WHERE MARKS.student_id = {$this->student_id} GROUP BY PAPERS.subject_id";

        // echo $sql;
        // die();

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $data = [];
        $student_points =  0;
        foreach ($results as $subject) {

            // make individula gradings
            $paper_scores = explode(',', $subject->paper_scores);
            $paper_gradings = [];
            foreach ($paper_scores as $index => $value) {
                $subject_aggregate = 0;
                if ($value >= 80) {
                    $subject_aggregate = 1;
                } elseif ($value >= 75) {
                    $subject_aggregate = 2;
                } elseif ($value >= 66) {
                    $subject_aggregate = 3;
                }elseif ($value >= 60) {
                    $subject_aggregate = 4;
                }elseif ($value >= 55) {
                    $subject_aggregate = 5;
                }elseif ($value >= 50) {
                    $subject_aggregate = 6;
                }elseif ($value >= 45) {
                    $subject_aggregate = 7;
                } elseif ($value >= 35) {
                    $subject_aggregate = 8;
                }else {
                    $subject_aggregate = 9;
                }
                $paper_gradings[] = $subject_aggregate;
            }
            
            // arrange the papers that are done
            sort($paper_gradings);
            $paper_gradings = implode(',', $paper_gradings);

            // grade from here
            $subject_grade = 'F';
            $paper_points = 0;
            // grading for A
            if (array_search($paper_gradings, self::A_GRADE) !== false ) {
                $subject_grade = 'A';
                $paper_points = 6;
            } elseif (array_search($paper_gradings, self::B_GRADE) !== false ) {
                $subject_grade = 'B';
                $paper_points = 5;
            } elseif (array_search($paper_gradings, self::C_GRADE) !== false ) {
                $subject_grade = 'C';
                $paper_points = 4;
            } elseif (array_search($paper_gradings, self::D_GRADE) !== false ) {
                $subject_grade = 'D';
                $paper_points = 2;
            } elseif (array_search($paper_gradings, self::E_GRADE) !== false ) {
                $subject_grade = 'E';
                $paper_points = 2;
            } elseif (array_search($paper_gradings, self::O_GRADE) !== false ) {
                $subject_grade = 'O';
                $paper_points = 1;
            }


            // GRADE CORE SUBJECTS
            if (intVal($subject->is_core) === 1) {
                if (array_search($subject_grade, self::O_GRADE_CORE) !== false ) {
                    $subject_grade = 'O';
                    $paper_points = 1;
                } else {
                    $subject_grade = 'F';
                    $paper_points = 0;
                }
                
            }

            $subject->grade = $subject_grade;

            $student_points += $paper_points;
            
            $data[] = $subject;
        }
        $this->student_points = $student_points;

        return array_merge($results );
    }
}

$student_id_collection = $_GET['student_ids'];
$studet_ids = explode(',', $student_id_collection);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A Level Student Report</title>
</head>
<body>
    
<main >

    <header>
        <div class="hide-on-print">
            <button onClick="printReport()">Print</button>
        </div>
    </header>

    <?php
        require '../Includes/Class/db_connect.php';
        $db_conn = new DatabaseConnection ();
        // $db_conn->conn;
        $page_count = 0;
        foreach ($studet_ids as $key => $student_id):
            $page_count++;
            $OLevelStudentReport = new OLevelStudentReport ($db_conn->conn, $student_id);
            $student_details = $OLevelStudentReport->getStudenDetatils();
            $school_details = $OLevelStudentReport->getStudentSchoolDetails();
            $studentSubejcts = $OLevelStudentReport->getStudentSubjectMarks();
    ?>
        <!-- begin section for generaing students report -->
        <section style="border:solid; padding: 10px; width: 800px; margin:auto;">
            <div style="text-align:center;">

            <table style="margin-left: 5%;">
                <tr>
                    <td>
                        <img src="../Images/logo.jpeg" style="width:130px; height: 130px;" alt="">
                    </td>
                    <td>
                        <h2 stlye="display:inline">KAMPALA INTEGRATED SECONDARY SCHOOLS' <br> EXAMINATION BUREAU 2019</h2>
                    </td>
                </tr>

            </table>
                
                <h4 style="margin:0px;">UACE MOCK PASSLIP</h4>
            </div>

            <table style="margin-left:10%;">
                <tr>
                    <th>Student's Name</th>
                    <td><span><?=$student_details->second_name?> <?=$student_details->first_name?></span>  </td>

                    <th>School</th>
                    <td><span><?=$school_details->name?></span>  </td>

                    <th>District</th>
                    <td><span><?=$school_details->district?></span>  </td>

                    <th>Center No:</th>
                    <td><span><?=$school_details->center_no?></span>  </td>

                </tr>
            </table>


            <div style="text-align:center;">
                <table style="margin-left:auto; margin-right:auto;">
                    <thead>
                        <tr>
                            <th style="text-align:left; width:20px;">&nbsp;&nbsp;&nbsp;</th>
                            <th style="text-align:left; ">Subject</th>
                            <th style="text-align:center; width:200px;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($studentSubejcts as $counter => $value):
                        ?>
                            <tr>
                                <td style="text-align:left; width:20px;"><?=($counter + 1)?></td>
                                <td style="text-align:left; "><?=$value->name?></td>
                                <td style="text-align:center; width:200px;"><?=$value->grade?></td>
                            </tr>
                        <?php
                            endforeach;
                        ?>
                        <tr>
                            <td colspan="2"><b>TOTAL:&nbsp;&nbsp;</b>POINTS&nbsp;</td>
                            <td style="text-align:center; width:200px;">&nbsp;***<?=$OLevelStudentReport->student_points;?>***</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                        
            <br>
            <div>
                <div style="text-align:center;">
                    <span ><em>"Quality assessment for reliable results"</em></span>
                </div>
            </div>

        </section>
        <br><br>
        <!-- end section for generaing students report -->
        
        <?php
            if ($page_count == 2):
            $page_count = 0;
        ?>
            <p style = "page-break-before:always;"></p>
        <?php
            endif;
        ?>

    <?php
        endforeach;
    ?>
    
</main>


<script>

    function printReport ()
    {
        window.print();
    }
</script>


</body>
</html>