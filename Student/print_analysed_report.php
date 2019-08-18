<?php
 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);


 require_once '../Includes/Class/generate_analysed_report.php';

 $school_id = $_GET['school_id'];
 $level = $_GET['level'];


$analysed_report = new GenerateAnalysedReport($school_id, $level);
$school_details = $analysed_report->getSchoolDetails();
$subjects =  $analysed_report->getAllOLevelSubjects();
$students =  $analysed_report->getAllOStudentsInSchool();


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

        .grade-table td {
            /* display: inline-block; */
            width: auto;
            /* border: 1px solid black; */
            padding: 0px;
            margin: 0px;
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
        <!-- begin section for generaing students report -->
        <section style="border:none; padding: 10px; width: 100%; margin:auto;">
            <div style="text-align:center;">

            <table style="text-align:center;margin:auto;padding:auto">
                <tr>
                    <td>
                        <img src="../Images/logo.jpeg" style="width:'auto'; height: 100px;" alt="">
                    </td>
                    <td>
                        <h2 stlye="display:inline">KAMPALA INTEGRATED SECONDARY SCHOOLS' <br> EXAMINATION BUREAU 2019</h2>
                        <h4 stlye="display:inline"><?= $school_details->name?> <?= $school_details->district?> <?= $school_details->center_no?></h2>
                    </td>
                </tr>

            </table>
                
                <h4 style="margin:0px;" class="report-text">UCE MOCK ANALYSED REPORT</h4>
            </div>



            <div style="text-align:center;">
                
            </div>
                        
            <br>
            <div>
                <div style="text-align:center;">



                    <table class="grade-table">
                        <thead>
                                <td>No</td>
                                <td>Name</td>
                                <td>Index No</td>
                                <!-- begin generate subjects -->
                                <?php foreach($subjects as $key => $subject):?>
                                <td><?= $subject->short_name?></td>
                                <?php endforeach;?>
                                <!-- end generate subjects -->
                                <td>Aggregates</td>
                                <td>Grade</td>
                        </thead>    
                        <tbody>
                            <?php foreach($students as $key => $student):?>
                            <?php
                                $student_performance_records = [];
                            ?>
                            <tr>
                                <td><?= ($key + 1)?></td>
                                <td><?= $student->first_name . ' ' . $student->second_name?></td>
                                <td><?= $student->index_no?></td>
                                <!-- begin generate subjects -->
                                <?php foreach($subjects as $key2 => $subject):?>

                                <?php
                                    // paper grade details
                                    $grade_details = $analysed_report->getScoreOnStudentOLevelMarks($student->id, $subject->id);
                                    $student_performance_records[] = $grade_details;
                                ?>
                                
                                <td><?= $grade_details['grade']?></td>
                                <?php endforeach;?>
                                <?php
                                    // get grade and aggregates
                                    $grade_detailsX = $analysed_report->getOLevelAggregatesAndGrade($student_performance_records);

                                ?>
                                <!-- end generate subjects -->
                                <td><?= $grade_detailsX['aggregates']?></td>
                                <td><?= $grade_detailsX['grade']?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>




                    <span class="report-text"><em>"Quality assessment for reliable results"</em></span>
                </div>
            </div>

        </section>
        <br><br>
        <!-- end section for generaing students report -->
        

    
</main>


<script>

    function printReport ()
    {
        window.print();
    }
</script>


</body>
</html>