

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ALevelStudentReport {

     const A_GRADE = [ '1,1,1', '1,1,2', '1,2,2', '1,2,3',  '2,2,2', '2,2,3', '1,1', '1,2', '2,2'];
     const B_GRADE = ['1,1,4', '1,2,4', '1,3,4', '2,2,4', '2,3,4', '2,4,4', '3,3,3', '3,3,4', '1,3', '2,3', '3,3'];
     const C_GRADE = ['1,1,5', '1,2,5', '1,3,5', '2,2,5', '2,3,5', '2,4,5', '3,3,5', '3,4,5', '3,5,5', '1,4', '2,4', '3,4', '4,4'];
     const D_GRADE = ['1,1,6', '1,2,6', '1,3,6', '2,2,6', '2,3,6', '2,4,6', '3,3,6', '3,4,6', '3,5,6', '4,5,6', '1,5', '2,5', '3,5', '4,5', '5,5'];
     const E_GRADE = ['1,1,7', '1,2,7', '1,3,7', '2,2,7', '2,3,7', '2,4,7', '3,3,7', '3,4,7', '3,5,7', '4,5,7', '1,6', '2,6', '3,6', '4,6', '5,6'];
     const O_GRADE = [ '1', '2', '3', '4', '6', '1,7,7', '2,7,7', '3,7,7', '4,7,7', '5,7,7', '6,9,9', '7,7,7', '4,7,8', '4,8,7', '5,7,7', '5,8,7', '5,8,8', '6,7,7', '6,7,8', '5,7,9', '5,8,9', '6,6,9', '6,7,9', '6,8,9',
        '1,7', '2,7', '3,7', '4,7', '5,7', '6,7', '7,7', '1,8', '2,8', '3,8', '4,8', '5,8', '6,8', '7,8', '8,8'];
     const F_GRADE = ['1,9,9', '2,9,9', '3,9,9', '4,9,9', '5,9,9', '6,9,9', '7,9,9', '8,9,9', '9,9,9', '1,9', '2,9', '3,9', '4,9', '5,9', '6,9', '7,9', '8,9', '9,9'];

    // grade for core subjects
    const O_GRADE_CORE = ['A', 'B', 'C', 'D', 'E', 'O'];

    private $student_id  = 0;
    private $conn = null;

    public $student_points = 0;
    public $is_missing_core = false;
    private $results_temp = null;

    public $student_combination = "N/A";

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
            if (intVal($subject->is_core) > 0) {
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

        $this->results_temp = $results;

        
        return $results;
    }

    /**
     * Get the combination from a student subject
     * @param object => student marks
     * @return string combination
     */
    public function getStudentCombination ()
    {
        // kill the object reference
        $subjects = json_decode(json_encode($this->results_temp));

        $found_subjects = [];
        foreach ($subjects as $key => $subject_data) {
            if (intVal($subject_data->is_core) != 2) {
                if (intVal($subject_data->is_core) == 0) {
                    $subject_data->name = substr($subject_data->name, 0, 1);
                }
                $found_subjects[$subject_data->name] = intVal($subject_data->is_core); 
            }
               
        }

        arsort($found_subjects);
        $found_subjects = array_reverse($found_subjects);
        $found_subjects = array_keys($found_subjects);


        if (count($found_subjects) <> 4) {
            return "N/A";
        }

        return $this->getProperCombiation($found_subjects);

    }   

    private function getProperCombiation ($subjects)
    {
        $paper_codes = $subjects[0] . $subjects[1] . $subjects[2]; // i.e PCM / ICT
        $paper_codes = str_split(strtoupper($paper_codes));
        sort($paper_codes);
        $paper_codes = implode("", $paper_codes);


        $stmt = $this->conn->query("SELECT combination, (SELECT combination) AS combination2 FROM   A_level_combiantions WHERE 1=1");

        foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $key => $combination_values) {
            
            // check for combination match
            $first_part = str_split(strtoupper(trim(explode("/", $combination_values->combination)[0])));
            sort($first_part);
            $first_part = implode("", $first_part);

            $fist_part2 = strtoupper(trim(explode("/", $combination_values->combination)[0]));
            
            if ( $paper_codes ==  $first_part ) {
                return $fist_part2 . " / " .  $subjects[3];
            }
        }

        return "N/A";

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
    <style>
        .report-text {
            font-size: 14px;
        }
    </style>
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
            $ALevelStudentReport = new ALevelStudentReport ($db_conn->conn, $student_id);
            $student_details = $ALevelStudentReport->getStudenDetatils();
            $school_details = $ALevelStudentReport->getStudentSchoolDetails();
            $studentSubejcts = $ALevelStudentReport->getStudentSubjectMarks();
    ?>
        <!-- begin section for generaing students report -->
        <section style="border:solid; padding: 10px; width: 800px; margin:auto;">
            <div style="text-align:center;">

            <table style="margin-left: 5%;">
                <tr>
                    <td>
                        <img src="../Images/logo.jpeg" style="width:100px; height: 1o0px;" alt="">
                    </td>
                    <td>
                        <h2 stlye="display:inline">KAMPALA INTEGRATED SECONDARY SCHOOLS' <br> EXAMINATION BUREAU 2019</h2>
                    </td>
                </tr>

            </table>
                
                <h4 style="margin:0px;" class="report-text">UACE MOCK PASSLIP</h4>
            </div>

            <table style="margin-left:5%;">
                <tr>
                    <th class="report-text">STUDENT'S NAME</th>
                    <td><span><?=$student_details->second_name?> <?=$student_details->first_name?></span>  </td>

                    <th class="report-text">SCHOOL</th>
                    <td><span><?=$school_details->name?></span>  </td>

                    <th class="report-text">DISTRICT</th>
                    <td><span><?=$school_details->district?></span>  </td>

                    <th class="report-text">CENTER NO:</th>
                    <td><span><?=$school_details->center_no?></span>  </td>

                </tr>
            </table>


            <div style="text-align:center;">
                <span style="font-weight:bold" class="report-text">COMBINATION <?= $ALevelStudentReport->getStudentCombination()?></span>
                <table style="margin-left:auto; margin-right:auto;">
                    <thead>
                        <tr>
                            <th style="text-align:left; width:40px;">No&nbsp;</th>
                            <th style="text-align:left; width:100px;" class="report-text">Subject</th>
                            <th style="text-align:center; width:200px;" class="report-text">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($studentSubejcts as $counter => $value):
                        ?>
                            <tr>
                                <td style="text-align:left; width:40px;" class="report-text"><?=($counter + 1)?></td>
                                <td style="text-align:left; width:100px;" class="report-text"><?=$value->name?></td>
                                <td style="text-align:center; width:200px;" class="report-text"><?=$value->grade?></td>
                            </tr>
                        <?php
                            endforeach;
                        ?>
                        <tr>
                            <td colspan="2" class="report-text"> <b>TOTAL:&nbsp;&nbsp;</b>POINTS&nbsp;</td>
                            <td style="text-align:center; width:200px;">&nbsp;***<?=$ALevelStudentReport->student_points;?>***</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                        
            <br>
            <div>
                <div style="text-align:center;">
                    <span class="report-text"><em>"Quality assessment for reliable results"</em></span>
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