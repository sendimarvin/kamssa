


<?php


/**
 * This class generates the analysed report
 * 
 */
class GenerateAnalysedReport {

    private $conn;
    public $school_id, $level;
    function __construct ($school_id, $level)
    {
        $this->school_id = $school_id;
        $this->level = $level;
        $this->createDBConn();
    }

    public function createDBConn ()
    {
        require_once 'db_connect.php';
        $db_conn = new DatabaseConnection();
        $this->conn = $db_conn->conn;
    }

    public function getSchoolDetails ()
    {
        $stmt = $this->conn->query("SELECT * FROM schools WHERE id = '{$this->school_id}'");
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * 
     */
    public function getAllOLevelSubjects ()
    {
        $stmt = $this->conn->query("SELECT * FROM o_level_subejcts WHERE 1=1");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getAllOStudentsInSchool ()
    {
        $stmt = $this->conn->query("SELECT * FROM o_level_students WHERE school_id = {$this->school_id}");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    

    /**
     * Generates the o level subject grading details for a students
     * @param int student_id => 
     * @param int subject_id => 
     * @return grade
     */
    public function getScoreOnStudentOLevelMarks ($student_id, $subject_id)
    {
        $stmt = $this->conn->query("SELECT * FROM o_level_subejcts WHERE id = $subject_id ");
        $subject_details = $stmt->fetchObject();

        $total_papers_required = $subject_details->no_of_papers_done;
        $subject_name = $subject_details->name;

        // die("SELECT o_level_student_marks.* FROM  o_level_student_marks LEFT JOIN o_level_subejcts_papers ON o_level_subejcts_papers.id = o_level_student_marks.subject_paper_id WHERE o_level_subejcts_papers.subject_id = $subject_id ");

        // check if student did all the papers
        $stmt2 = $this->conn->query("SELECT o_level_student_marks.* 
            FROM  o_level_student_marks 
            LEFT JOIN o_level_subejcts_papers ON o_level_subejcts_papers.id = o_level_student_marks.subject_paper_id 
            WHERE o_level_subejcts_papers.subject_id = $subject_id AND o_level_student_marks.student_id = $student_id AND  o_level_student_marks.marks > -1 ");
        $papers = $stmt2->fetchAll(PDO::FETCH_OBJ);

        if ($subject_details->is_core == 0 && count($papers) == 0 ) {
            return array('subject_name' => $subject_name, 'grade' => '', 'points' => '', 'is_core' => $subject_details->is_core);
        }


        if (count($papers) <> $total_papers_required || !$total_papers_required) { // check if student did the expected no of papers
            return array('subject_name' => $subject_name, 'grade' => 'X', 'points' => 'X', 'is_core' => $subject_details->is_core);
        }

        // get average score
        $sum_of_marks = 0;
        foreach ($papers as $key => $paper) {
            $sum_of_marks += $paper->marks;
        }

        $average = ($sum_of_marks / $total_papers_required);

        return $this->gradeOLevelSubject($average, $subject_details->is_core, $subject_name);

        
    }

    /**
     * Grades the O level Marks
     * @param double marks
     * @return array ['grade' => , 'units' => ]
     */
    public function gradeOLevelSubject($marks, $is_core, $subject_name)
    {
        $grade = "";
        $points = "";
        if ($marks >= 80) {
            $points = 1;
            $grade = 'D1';
        } elseif ($marks >= 75) {
            $points = 2;
            $grade = 'D2';
        } elseif ($marks >= 66) {
            $points = 3;
            $grade = 'C3';
        }elseif ($marks >= 60) {
            $points = 4;
            $grade = 'C4';
        }elseif ($marks >= 55) {
            $points = 5;
            $grade = 'C5';
        }elseif ($marks >= 50) {
            $points = 6;
            $grade = 'C6';
        }elseif ($marks >= 45) {
            $points = 7;
            $grade = 'P7';
        } elseif ($marks >= 35) {
            $points = 8;
            $grade = 'P8';
        }else {
            $points = 9;
            $grade = 'F9';
        }

        return array('subject_name' => $subject_name, 'grade' => $grade, 'points' => $points, 'is_core' => $is_core);
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

    public function getTotalPass ($subject_details)
    {
        $total_pass = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if ($subject_detail['points'] <> 'X' && $subject_detail['points'] < 9)
                ++$total_pass;
        }
        return $total_pass;
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
            if ($subject_detail['points'] <> 'X' && $subject_detail['points'] <= 6)
                ++$total_credits;
        }
        return $total_credits;
    }

    public function getTotalPass8 ($subject_details)
    {
        $total_pass8s = 0;
        foreach ($subject_details as $key => $subject_detail) {
            if (intVal($subject_detail['points']) === 8)
                ++$total_pass8s;
        }
        return $total_pass8s;
    }


    /**
     * Gets the grate from aggregates and other extra conditions
     * @param int|string $aggregates => the aggregates of the best done 8 subjects
     * @param array $subject_detail => $contains done subjects
     * @return string|char => grade results
    */
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


        if ($aggregates >= 8 && $aggregates <= 32 && ($has_atleast_credit_in_english && $has_atleast_pass8_in_maths && ($has_atleast_pass8_in_physics || $has_atleast_pass8_in_biology || $has_atleast_pass8_in_chemistry) )) {
            return 1;
        } elseif ($aggregates <= 45 || $aggregates <= 45 && ($is_maths_greater_than_pass8 && $is_english_greater_than_pass8 && $total_credits >= 6)) {
            return 2;
        } elseif ($aggregates <= 58 || $aggregates <= 58 && ( ($total_credits == 5) || (($total_credits == 4) && ($total_passes == 3)) || (($total_credits == 3) && ($total_passes == 5)) )) {
            return 3;
        } elseif ( $aggregates <= 69 || $aggregates <= 69 && ( ($total_credits == 1) || ($total_pass7s == 2) || ($total_pass8s == 3) )) {
            return 4;
        } elseif ($aggregates <= 69 || $aggregates > 69 && $aggregates <= 72 ) {
            return 9; 
        } else {
            return "Undefined grade";
        }
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
            } else { // means stack is already full with 8

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

    public function is_maths_greater_than_pass8 ($subject_details)
    {
        $is_greater_than_pass8 = false;
        foreach ($subject_details as $key => $subject) {
            if (strtolower($subject['subject_name']) == 'mathematics') {
                if ($subject['points'] <> 'X' && $subject['points'] <= 8)
                $is_greater_than_pass8 = true;
                break;
            }
        }
        return $is_greater_than_pass8;
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







class GenerateAnalysedReportALevel {

    const A_GRADE = [ '1,1,1', '1,1,2', '1,2,2', '1,2,3',  '2,2,2', '2,2,3', '1,1', '1,2', '2,2'];
    const B_GRADE = ['1,1,4', '1,2,4', '1,3,4', '2,2,4', '2,3,4', '2,4,4', '3,3,3', '3,3,4', '1,3', '2,3', '3,3'];
    const C_GRADE = ['1,1,5', '1,2,5', '1,3,5', '2,2,5', '2,3,5', '2,4,5', '3,3,5', '3,4,5', '3,5,5', '1,4', '2,4', '3,4', '4,4'];
    const D_GRADE = ['1,1,6', '1,2,6', '1,3,6', '2,2,6', '2,3,6', '2,4,6', '3,3,6', '3,4,6', '3,5,6', '4,5,6', '1,5', '2,5', '3,5', '4,5', '5,5'];
    const E_GRADE = ['1,1,7', '1,2,7', '1,3,7', '2,2,7', '2,3,7', '2,4,7', '3,3,7', '3,4,7', '3,5,7', '4,5,7', '1,6', '2,6', '3,6', '4,6', '5,6'];
    const O_GRADE = [ '1', '2', '3', '4', '5', '6', '1,7,7', '2,7,7', '3,7,7', '4,7,7', '5,7,7', '6,9,9', '7,7,7', '4,7,8', '4,8,7', '5,7,7', '5,8,7', '5,8,8', '6,7,7', '6,7,8', '5,7,9', '5,8,9', '6,6,9', '6,7,9', '6,8,9',
        '1,7', '2,7', '3,7', '4,7', '5,7', '6,7', '7,7', '1,8', '2,8', '3,8', '4,8', '5,8', '6,8', '7,8', '8,8'];
    const F_GRADE = ['1,9,9', '2,9,9', '3,9,9', '4,9,9', '5,9,9', '6,9,9', '7,9,9', '8,9,9', '9,9,9', '1,9', '2,9', '3,9', '4,9', '5,9', '6,9', '7,9', '8,9', '9,9'];

    // grade for core subjects
    const O_GRADE_CORE = ['A', 'B', 'C', 'D', 'E', 'O'];

    private $conn;
    public $school_id, $level;
    function __construct ($school_id, $level)
    {
        $this->school_id = $school_id;
        $this->level = $level;
        $this->createDBConn();
    }

    public function createDBConn ()
    {
        require_once 'db_connect.php';
        $db_conn = new DatabaseConnection();
        $this->conn = $db_conn->conn;
    }

    public function getSchoolDetails ()
    {
        $stmt = $this->conn->query("SELECT * FROM schools WHERE id = '{$this->school_id}'");
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * 
     */
    public function getAllALevelSubjects ()
    {
        $stmt = $this->conn->query("SELECT * FROM a_level_subejcts WHERE 1=1");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function getAllAStudentsInSchool ()
    {
        $stmt = $this->conn->query("SELECT a_level_students.*,  
        (SELECT combination FROM a_level_combinations WHERE a_level_combinations.id = a_level_students.combination_id) AS combination
        FROM a_level_students WHERE school_id = {$this->school_id}");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    

    /**
     * Generates the o level subject grading details for a students
     * @param int student_id => 
     * @param int subject_id => 
     * @return grade
     */
    public function getScoreOnStudentALevelMarks ($student_id, $subject_id)
    {
        $stmt = $this->conn->query("SELECT * FROM a_level_subejcts WHERE id = $subject_id ");
        $subject_details = $stmt->fetchObject();

        $total_papers_required = $subject_details->no_of_papers_done;
        $subject_name = $subject_details->name;
        
        // check if student did all the papers
        $stmt2 = $this->conn->query("SELECT a_level_student_marks.* 
            FROM  a_level_student_marks 
            LEFT JOIN a_level_subejcts_papers ON a_level_subejcts_papers.id = a_level_student_marks.subject_paper_id 
            WHERE a_level_subejcts_papers.subject_id = $subject_id AND a_level_student_marks.student_id = $student_id ");
        $papers = $stmt2->fetchAll(PDO::FETCH_OBJ);

        if (count($papers) == 0 ) { // means student does not do paper
            return array('subject_name' => $subject_name, 'grade' => '', 'points' => '', 'is_core' => $subject_details->is_core);
        }

        if (count($papers) <> $total_papers_required || !$total_papers_required) { // check if student did the expected no of papers
            return array('subject_name' => $subject_name, 'grade' => 'X', 'points' => 'X', 'is_core' => $subject_details->is_core);
        }

        // grade paper
        $subject_paper_details = [];
        $temp_sub_data = new \stdClass();
        $marks_data  = [];
        foreach ($papers as $key => $paper) {
            if ($subject_details->is_core == 1) { // grading for ict or submaths
                $temp_sub_data = $paper;
                $marks_data[] = $paper->marks;
            } else {
                $subject_paper_details[] = $this->gradeALevelPaper($paper->marks, $subject_details->is_core, $subject_name); // get paper grade details
            }
        }

        // grade ict or submaths from here
        if (!empty($marks_data)) {
            // get the average score
            $total = 0;
            foreach ($marks_data as $key => $mark) {
                $total += $mark;
            }
            $average_score = (count($marks_data) > 0) ? ($total / count($marks_data)) : 0;
            $subject_paper_details[] = $this->gradeALevelPaper($average_score, $subject_details->is_core, $subject_name);
        }

        return $this->getSubjectGradeDetails($subject_paper_details, $subject_details->is_core, $subject_name);
    }



    public function getSubjectGradeDetails ($subject_paper_details, $is_core, $subject_name)
    {
        $paper_gradings = []; // contains individual paper scores in terms of points
        foreach ($subject_paper_details as $key => $paper_details) {
            $paper_gradings[] = $paper_details['points'];
        }

        sort($paper_gradings);
        $paper_gradings = implode(',', $paper_gradings);

        // die ($paper_gradings);
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
        if (intVal($is_core) > 0) {
            if (array_search($subject_grade, self::O_GRADE_CORE) !== false ) {
                $subject_grade = $subject_paper_details[0]['grade'];
                $paper_points = 1;
            } else {
                $subject_grade = $subject_paper_details[0]['grade'];
                $paper_points = 0;
            }
        }

        return array('subject_name' => $subject_name, 'grade' => $subject_grade, 'points' => $paper_points, 'is_core' => $is_core);

    }


    /**
     * Grades the O level Marks
     * @param double marks
     * @return array ['grade' => , 'units' => ]
     */
    public function gradeALevelPaper($marks, $is_core, $subject_name)
    {
        $grade = "";
        $points = "";
        if ($marks >= 80) {
            $points = 1;
            $grade = 'D1';
        } elseif ($marks >= 75) {
            $points = 2;
            $grade = 'D2';
        } elseif ($marks >= 66) {
            $points = 3;
            $grade = 'C3';
        }elseif ($marks >= 60) {
            $points = 4;
            $grade = 'C4';
        }elseif ($marks >= 55) {
            $points = 5;
            $grade = 'C5';
        }elseif ($marks >= 50) {
            $points = 6;
            $grade = 'C6';
        }elseif ($marks >= 45) {
            $points = 7;
            $grade = 'P7';
        } elseif ($marks >= 35) {
            $points = 8;
            $grade = 'P8';
        } elseif ($marks >= 0) {
            $points = '9';
            $grade = '9';
        } else {
            $points = 'X';
            $grade = 'X';
        }

        return array('subject_name' => $subject_name, 'grade' => $grade, 'points' => $points, 'is_core' => $is_core);
    }


    /**
     * Gets subject performed details and returns aggregates and grade
     * @param array $student_details => array assocciation of  
     * @return int => total points
     */
    public function getALevelPoints ($subject_details)
    {
        $points = 0;
        foreach ($subject_details as $key => $subject) {
            if (is_numeric($subject['points'])) {
                $points += $subject['points'];
            }
        }
        return $points;
    }


}



?>