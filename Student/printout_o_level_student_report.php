

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



class OLevelStudentReport {
    private $student_id  = 0;
    private $conn = null;

    public $aggregates = 0;
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
            FROM o_level_students  AS STUDENTS
            WHERE  STUDENTS.id = {$this->student_id} ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ);
        return $results; 
    }


    public function getStudentSchoolDetails ()
    {

        $sql = "SELECT SCHOOLS.* 
            FROM o_level_students  AS STUDENTS
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
        $sql = "SELECT SUBJECTS.id, SUBJECTS.name, 
            IF((MIN(MARKS.marks) = -1 OR SUBJECTS.no_of_papers_done <> COUNT(MARKS.marks)), 'X', AVG(MARKS.marks) ) AS average_score, 
            PAPERS.subject_id, SUBJECTS.is_core
            FROM `o_level_student_marks` AS MARKS
            JOIN o_level_subejcts_papers AS PAPERS ON PAPERS.id = MARKS.subject_paper_id
            JOIN o_level_subejcts AS SUBJECTS ON SUBJECTS.id = PAPERS.subject_id
            WHERE MARKS.student_id = {$this->student_id} GROUP BY PAPERS.subject_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);

        $data = [];
        $aggregates =  0;
        $found_subject_ids = [];
        foreach ($results as $key => $subject) {
            //grade student from here
            $found_subject_ids[] = $subject->id;

            $subject_aggregate = 0;
            if (($subject->average_score == 'X')) {
                $subject_aggregate = 'X';
                $subject->grade = 'X';
            } elseif ($subject->average_score >= 80) {
                $subject_aggregate = 1;
                $subject->grade = 'D1';
            } elseif ($subject->average_score >= 75) {
                $subject_aggregate = 2;
                $subject->grade = 'D2';
            } elseif ($subject->average_score >= 66) {
                $subject_aggregate = 3;
                $subject->grade = 'C3';
            }elseif ($subject->average_score >= 60) {
                $subject_aggregate = 4;
                $subject->grade = 'C4';
            }elseif ($subject->average_score >= 55) {
                $subject_aggregate = 5;
                $subject->grade = 'C5';
            }elseif ($subject->average_score >= 50) {
                $subject_aggregate = 6;
                $subject->grade = 'C6';
            }elseif ($subject->average_score >= 45) {
                $subject_aggregate = 7;
                $subject->grade = 'P7';
            } elseif ($subject->average_score >= 35) {
                $subject_aggregate = 8;
                $subject->grade = 'P8';
            }else {
                $subject_aggregate = 9;
                $subject->grade = 'F9';
            }
            $subject->subject_aggregate = $subject_aggregate;

            $data[] = $subject;
            $subject->{'points'} = $subject_aggregate;
            $results[$key] = $subject;
        }

        // $aggregates = $this->getBestDone8($data);

        // $this->aggregates = $aggregates;

        // find missing core subjects
        $missing_subjects = $this->getMissingCoreSubejcts($found_subject_ids);

        if (!empty($missing_subjects)) {
            $this->is_missing_core = true;
        }

        return array_merge($missing_subjects, $results );
    }


    // public function getBestDone8 ($subjects_details)
    // {
    //     $new_results = []; // max initial size is 8


    //     foreach ($subjects_details as $key => $subjects_detail) {
    //         if ($subjects_detail->grade == 'X')
    //                 continue;

    //         if (count($new_results) < 8) {
    //             $new_results[] = $subjects_detail;
    //             continue;
    //         } else { // means stack is already full with 8

    //             // check if new subjuect is lower than some that exists
    //             foreach ($new_results as $key2 => $new_result) {
    //                 if ($new_result->subject_aggregate > $subjects_detail->subject_aggregate) {
    //                     // shift paper and break

    //                     // echo "shifting paper";
    //                     // print_r($new_results[$key2]);
    //                     // echo "with";
    //                     // print_r($subjects_detail);
    //                     $new_results[$key2] = $subjects_detail;
    //                     break;
    //                 }
    //             }
    //         }
    //     }

    //     // grade best 8 done
    //     $best_done_agg = 0;
    //     foreach ($new_results as $key => $new_result) {
    //         // echo "<br>";
    //         // print_r($new_result);
    //         $best_done_agg += $new_result->subject_aggregate;
    //     }

    //     return $best_done_agg;

    // }

    /**
     * This will check for the missing subjects that are core
     * @param student subjects data
     * @return array mussing subjects
     */
    private function getMissingCoreSubejcts($found_subject_ids)
    {
        $all_ids = implode(',', $found_subject_ids);
        if (empty($all_ids)) {
            $all_ids = "-1";
        }

        $stmt = $this->conn->query("SELECT `id`, `name`, 'X' AS average_score, 'X' AS grade, 
            'X' AS points, is_core
            FROM o_level_subejcts WHERE id NOT IN ($all_ids) AND is_core = '1'; ");

        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function getTotalPass7s ($subject_details)
    {
        $total_pass7s = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if (intVal($subject_detail['points']) === 7)
                ++$total_pass7s;
        }
        return $total_pass7s;
    }

    public function getTotalPass8s ($subject_details)
    {
        $total_pass8s = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if (intVal($subject_detail['points']) === 8)
                ++$total_pass8s;
        }
        return $total_pass8s;
    }

    public function getTotalCredits ($subject_details)
    {
        $total_credits = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if ($subject_detail['points'] <> 'X' && $subject_detail['points'] >= 3 && $subject_detail['points'] <= 6)
                ++$total_credits;
        }
        return $total_credits;
    }

    public function is_english_greater_than_pass8 ($subject_details)
    {
        $is_greater_than_pass8 = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'english') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $is_greater_than_pass8 = true;
                break;
            }
        }
        return $is_greater_than_pass8;
    }

    public function has_atleast_pass8_in_maths ($subject_details)
    {
        $has_atleast_credit_in_maths = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'mathematics') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $has_atleast_credit_in_maths = true;
                break;
            }
        }
        return $has_atleast_credit_in_maths;
    }

    public function has_atleast_pass8_in_physics ($subject_details)
    {
        $has_atleast_credit_in_maths = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'physics') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $has_atleast_credit_in_maths = true;
                break;
            }
        }
        return $has_atleast_credit_in_maths;
    }

    public function has_atleast_pass8_in_chemistry ($subject_details)
    {
        $has_atleast_credit_in_maths = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'chemistry') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $has_atleast_credit_in_maths = true;
                break;
            }
        }
        return $has_atleast_credit_in_maths;
    }

    public function has_atleast_pass8_in_biology ($subject_details)
    {
        $has_atleast_credit_in_maths = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'biology') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $has_atleast_credit_in_maths = true;
                break;
            }
        }
        return $has_atleast_credit_in_maths;
    }

    public function getGrade ($aggregates, $subject_details)
    {
        $total_pass = $this->getTotalPass ($subject_details);
        $total_pass7s = $this->getTotalPass7s ($subject_details);
        $total_pass8s = $this->getTotalPass8s ($subject_details);
        $total_passes = ($total_pass7s + $total_pass8s);

        // $total_pass8 = $this->getTotalPass8 ($subject_details);
        $total_credits = $this->getTotalCredits ($subject_details);
        $is_maths_greater_than_pass8 = $this->is_maths_greater_than_pass8($subject_details);
        $is_english_greater_than_pass8 = $this->is_english_greater_than_pass8($subject_details);
        $has_atleast_credit_in_english = $this->has_atleast_credit_in_english($subject_details);
        $has_atleast_pass8_in_maths = $this->has_atleast_pass8_in_maths($subject_details);
        $has_atleast_pass8_in_physics = $this->has_atleast_pass8_in_physics($subject_details);
        $has_atleast_pass8_in_biology = $this->has_atleast_pass8_in_biology($subject_details);
        $has_atleast_pass8_in_chemistry = $this->has_atleast_pass8_in_chemistry($subject_details);
        // $has_done_all_complusory_subject = $this->has_done_all_complusory_subject($subject_details);
        // $has_done_less_than_8_subjects = $this->has_done_less_than_8_subjects($subject_details);

        if ($aggregates > 69 && $aggregates <= 72 ) {
            return 9; 
        } elseif ($aggregates > 58 && $aggregates <= 69 && ( ($total_credits == 1) || ($total_pass7s == 2) || ($total_pass8s == 3) )) {
            return 4;
        } elseif ($aggregates > 45 && $aggregates <= 58 && ( ($total_credits == 5) || (($total_credits == 4) && ($total_passes == 3)) || (($total_credits == 3) && ($total_passes == 5)) )) {
            return 3;
        } elseif ($aggregates > 32 && $aggregates <= 45 && ($is_maths_greater_than_pass8 && $is_english_greater_than_pass8 && $total_credits >= 6)) {
            return 2;
        } elseif ($aggregates <= 8 && $aggregates <= 32 && ($has_atleast_credit_in_english && $has_atleast_pass8_in_maths && ($has_atleast_pass8_in_physics || $has_atleast_pass8_in_biology || $has_atleast_pass8_in_chemistry) )) {
            return 1;
        } else {
            return "Undefined grade";
        }
    }


    /**
     * Gets subject performed details and returns aggregates and grade
     * @param array $student_details => array assocciation of  
     */
    public function getOLevelAggregatesAndGrade ($subject_details)
    {
        // filter out undone papers
        $subject_details_new = [];

        foreach ($subject_details as $key => $subject_detail) {
            if ($subject_detail['grade'] <> '')
                $subject_details_new[] = $subject_detail;
        }

        $subjects_done = $this->getTotalSubjectsDone ($subject_details_new);
        $has_done_all_complusory_subject = $this->has_done_all_complusory_subject($subject_details_new);

        if ($subjects_done === 0) return array('aggregates' => 'X', 'grade' => 'X');

        if ($subjects_done < 8) return array('aggregates' => 'X', 'grade' => 'U');

        if (!$has_done_all_complusory_subject) return array('aggregates' => 'X', 'grade' => 7);

        $best_agg = $this->getBestDone8 ($subject_details_new);

        $grade = $this->getGrade($best_agg, $subject_details_new);


        return array('aggregates' => $best_agg, 'grade' => $grade);

    }

    /**
     * gets the total subjects done
     * @param array $subject details => arraty associations
     * @return int => subjects done
     */
    public function getTotalSubjectsDone ($subjects_details)
    {
        $total = 0;
        foreach ($subjects_details as $key => $subjects_detail) {
            if ($subjects_detail['grade'] <> 'X')
                ++$total;
        }
        return $total;
    }

    
    public function getBestDone8 ($subjects_details)
    {
        $new_results = []; // max initial size is 8

        foreach ($subjects_details as $key => $subjects_detail) {
            if ($subjects_detail['grade'] == 'X')
                    continue;

            if (count($new_results) < 8) {
                $new_results[] = $subjects_detail;
                continue;
            } else { // means stack is already ull with 8

                // check if new subjuect is lower than some that exists
                foreach ($new_results as $key2 => $new_result) {
                    if ($new_result['points'] > $subjects_detail['points']) {
                        // shift paper and break
                        $new_results[$key2] = $subjects_detail;
                        break;
                    }
                }
            }
        }

        // grade best 8 done
        $best_done_agg = 0;
        foreach ($new_results as $key => $new_result) {
            $best_done_agg += $new_result['points'];
        }

        if (count($new_results) <> 8)
            return 'X';
        else
            return $best_done_agg;

    }

        /**
     * Gets the grate from aggregates and other extra conditions
     * @param int|string $aggregates => the aggregates of the best done 8 subjects
     * @param array $subject_detail => $contains done subjects
     * @return string|char => grade results
    */
    // public function getGradeNew ($aggregates, $subject_details)
    // {
    //     $total_pass = $this->getTotalPass ($subject_details);
    //     // $total_pass8 = $this->getTotalPass8 ($subject_details);
    //     // $total_credits = $this->getTotalCredits ($subject_details);
    //     $is_maths_greater_than_pass8 = $this->is_maths_greater_than_pass8($subject_details);
    //     $has_atleast_credit_in_english = $this->has_atleast_credit_in_english($subject_details);
    //     $has_done_all_complusory_subject = $this->has_done_all_complusory_subject($subject_details);
    //     $has_done_less_than_8_subjects = $this->has_done_less_than_8_subjects($subject_details);

    //     // var_dump( $is_maths_greater_than_pass8);
    //     if ($has_done_less_than_8_subjects) {
    //         return "U";
    //     } elseif (!$has_done_all_complusory_subject) {
    //         return "X";
    //     } elseif ($aggregates >= 68 && $aggregates <= 72 ) {
    //         return 9;
    //     } elseif ($aggregates >= 8 && $aggregates <= 32 && $total_pass >= 8 && $is_maths_greater_than_pass8 && $has_atleast_credit_in_english ) {
    //         return 1;
    //     } elseif ($aggregates > 8 && $aggregates <= 45 && $total_pass >=8  && ($total_pass >=8)) {
    //         return 2;
    //     } elseif ($aggregates > 8 && $aggregates <= 58 && $total_pass >=8) {
    //         return 3;
    //     } elseif ($aggregates > 8 && $aggregates <= 68) {
    //         return 4;
    //     } elseif ($aggregates > 68 && $aggregates <= 72) {
    //         return 4;
    //     } else {
    //         return "U";
    //     }
    // }

    public function has_done_all_complusory_subject ($subject_details)
    {
        $has_done_all_complusory_subject = true;
        foreach ($subject_details as $key => $subject) {
            if ($subject['is_core'] > 0) {
                if ($subject['points'] == 'X')
                $has_done_all_complusory_subject = false;
                break;
            }
        }
        return $has_done_all_complusory_subject;
    }

    public function has_atleast_credit_in_english ($subject_details)
    {
        $has_atleast_credit_in_english = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'english') {
                if ($subject['points'] <> 'X' && $subject['points'] < 7)
                $has_atleast_credit_in_english = true;
                break;
            }
        }
        return $has_atleast_credit_in_english;
    }

    public function is_maths_greater_than_pass8 ($subject_details)
    {
        $is_greater_than_pass8 = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'mathematics') {
                if ($subject['points'] <> 'X' && $subject['points'] < 8)
                $is_greater_than_pass8 = true;
                break;
            }
        }
        return $is_greater_than_pass8;
    }

    public function getTotalPass ($subject_details)
    {
        $total_pass = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if ($subject_detail['points'] <> 'X' && $subject_detail['points'] < 9)
                ++$total_pass;
        }
        return $total_pass;
    }

    public function has_done_less_than_8_subjects ($subject_details)
    {
        $done_subjects = 0;
        foreach ($subject_details as $key => $subject) {
            if ($subject['points'] == 'X') {
                ++$done_subjects;
            }
        }
        return ($done_subjects >= 8 ) ?  true : false;
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
    <title>O Level Student Report</title>
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
        <section style="border:solid; padding: 10px; width: 800px; margin:auto; background-image:url('../Images/watermark.png'); background-repeat:no-repeat; background-size: cover; background-position: center;">
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
                
                <h4 style="margin:0px;">MOCK PASSLIP</h4>
            </div>

            <table style="margin-left:10%; ">
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
                            <th style="text-align:center; width:200px;">Score</th>
                            <th style="text-align:center; width:200px;">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $subject_details = [];
                            foreach ($studentSubejcts as $counter => $value):
                                $subject_details[] = array('grade' => $value->grade, 'points' => $value->points, 'subject_name' => $value->name, 'is_core' => $value->is_core);
                        ?>
                            <tr>
                                <td style="text-align:left; width:20px;"><?=($counter + 1)?></td>
                                <td style="text-align:left; "><?=$value->name?></td>
                                <td style="text-align:center; width:200px;"><?=round($value->average_score, 0)?></td>
                                <td style="text-align:center; width:200px;"><?=$value->grade?></td>
                            </tr>
                        <?php
                            endforeach;
                            $new_grade_data  = $OLevelStudentReport->getOLevelAggregatesAndGrade($subject_details);
                            // var_dump($new_grade_data);
                        ?>
                        <tr>
                            <td colspan="2"><b>GRADE:&nbsp;&nbsp;</b> AGGREGATE&nbsp;<?=$new_grade_data['aggregates'];?></td>
                            <td style="text-align:center; width:200px;"></td>
                            <td style="text-align:center; width:200px;">***RESULT <?=$new_grade_data['grade'];?>***</td>
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