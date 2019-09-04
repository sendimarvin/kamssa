

<?php

    if (!isset($_SESSION)) {
        session_start();
    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>KAMSSA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "icon" type = "../image/png" href = "../Images/logo.jpeg ">
    <link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/demo/demo.css">
    <script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.edatagrid.js"></script>

    <style>
        
        body {
            background-image: url("../Images/my-bg.jpg");
            background-repeat: no-repeat, repeat;
            background-color: #ccc;
        }



        #menu-navbar {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #ABC;
        }

        #menu-navbar  li {
            float: left;
        }

        #menu-navbar  li a {
            display: block;
            color: #001f3f;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

            /* Change the link color to #111 (black) on hover */
        #menu-navbar li a:hover {
            background-color: #FFF;
        }

        #logout-text {
            color: red;
            font-size: 14px;
            font-weight: normal;
            cursor:pointer;
        }

        .content-wrapper {
            border-radius: 10px 10px 0 0;
        }

        #menu-navbar #logout-text-section {
            text-align: right;
            float: right;
        }

        #menu-navbar #logout-text-section a:hover {
            background-color: #001f3f;
            color: red;
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <div class="content-wrapper" style="padding:0px 0px 0px 0px; background-color:white; width:1200px; margin-left:auto; margin-right:auto;">
        
        <!-- begin section for the nav bar -->
        <ul id="menu-navbar" class="content-wrapper">
            <li><a href="index.php">KAMSSA HOME</a></li>
            <!-- <li><a href="#news">News</a></li> -->
            <?php if ($_SESSION['Settings']): ?>
            <li><a href="settings.php">Settings</a></li>
            <?php endif;?>

            <li id="logout-text-section"><a href="../index.php?logout"><span id="logout-text">Logout</span></a></li>
        </ul>

        <div class="easyui-layout" style="width:auto;height:600px;">
            <div data-options="region:'center',title:'KAMSSA'" >
                <div class="easyui-tabs" data-options="fit:true,border:false,plain:true">

                    <!-- begin section for schools -->
                    <?php if($_SESSION["Schools"]):?>
                    <div title="Schools"style="padding:10px">

                        <table id="schools-dg" class="easyui-datagrid" title="School Profile" style="width:1170px;height:500px"
                            data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_schools', fitcolumns:true" toolbar="#schools-dg-toolbar">
                            <thead>
                                <tr>
                                    <th data-options="field:'id2',width:80 ">ID</th>
                                    <th data-options="field:'id',width:80, hidden:true">No</th>
                                    <th data-options="field:'name',width:300">School Name</th>
                                    <th data-options="field:'center_no',width:200,align:'center'">Center No.</th>
                                    <th data-options="field:'district',width:280,align:'left'">District</th>
                                    <th data-options="field:'no_of_students',width:120, align:'center'">No. of Students</th>
                                    <th data-options="field:'action',width:180,align:'center'" formatter= "schoolActionFormtter">Action</th>
                                </tr>
                            </thead>
                        </table>

                        <div id="schools-dg-toolbar">
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddSchoolDlg()">Add</a>
                            <input type="text" id="school-section-general-search" placeholder="Search..." style="width:300px;height:20px;">
                        </div>
                
                    </div>
                    <?php endif;?>
                    <!-- End section for schools -->

                    <!-- Begin Students Section -->
                    <?php if($_SESSION["Students"]):?>
                    <div title="Students" style="padding:5px">

                        <div class="easyui-tabs" data-options="fit:true,border:false,plain:true">

                            <!-- begin tab section for update o-lvel student information -->
                            <div title="O-Level Students" style="padding:5px">

                                <table id="olevel-students-dg" class="easyui-datagrid" title="O-level Students" style="width:1150px;height:458px"
                                    data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_o_level_students'" toolbar="#olevel-students-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'school_name',width:250">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                            <th data-options="field:'action',width:120,align:'center'" formatter= "oLevelStudentActionFormtter">Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div id="olevel-students-dg-toolbar">
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddOLevelStudentDlg()">Add</a>
                                    <input type="text" id="o-level-school-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="o-level-general-search" placeholder="search center no, index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#o-level-school-search').combobox('setValue', '');
                                        $('#o-level-general-search').val('');
                                        searchOLevelSchool();
                                    ">Show All</a>
                                </div>

                            </div>
                            <!-- end tab section for update o-lvel student information -->

                            <!-- begin tab section for update A-lvel student information -->
                            <div title="A-Level Students" style="padding:5px">
                                <table id="Alevel-students-dg" class="easyui-datagrid" title="A-level Students" style="width:1150px;height:458px"
                                    data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_A_level_students'" toolbar="#Alevel-students-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'school_name',width:200">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                            <th data-options="field:'combination_name',width:100">Combination Name</th>
                                            <th data-options="field:'action',width:120,align:'center'" formatter= "ALevelStudentActionFormtter">Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div id="Alevel-students-dg-toolbar">
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddALevelStudentDlg()">Add</a>
                                    <input type="text" id="A-level-school-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="A-level-general-search" placeholder="search center no, index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#A-level-school-search').combobox('setValue', '');
                                        $('#A-level-general-search').val('');
                                        searchALevelSchool();
                                    ">Show All</a>
                                </div>
                            </div>
                            <!-- end tab section for update A-lvel student information -->

                        </div>

                    </div>
                    <?php endif;?>
                    <!-- End Students Section -->


                    <?php if($_SESSION["Results"]):?>
                    <div title="Results" style="padding:5px">
                        
                        <div class="easyui-tabs" data-options="fit:true,border:false,plain:true">
                            <div title="O-Level Students Marks" style="padding:5px">
                                <!-- Olevel marks -->

                                <table id="olevel-students-marks-dg" class="easyui-datagrid" title="O-level Students Marks" style="width:1150px;height:458px"
                                    data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_o_level_students'" toolbar="#olevel-students-marks-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'school_name',width:250">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                            <th data-options="field:'action',width:120,align:'center'" formatter= "oLevelStudentMarksActionFormtter">Action</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div id="olevel-students-marks-dg-toolbar">
                                    <input type="text" id="o-level-school-marks-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="o-level-marks-general-search" placeholder="search index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#o-level-school-marks-search').combobox('setValue', '');
                                        $('#o-level-marks-general-search').val('');
                                        searchOLevelSchoolMarks();
                                    ">Show All</a>
                                </div>



                            </div>

                            <!-- begin section for adding i alevel marks -->
                            <div title="A-Level Students Marks" style="padding:5px">

                                <table id="Alevel-students-marks-dg" class="easyui-datagrid" title="A-level Students Marks" style="width:1150px;height:458px"
                                    data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_A_level_students'" toolbar="#Alevel-students-marks-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'school_name',width:250">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                            <th data-options="field:'action',width:120,align:'center'" formatter= "ALevelStudentMarksActionFormtter">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- dialog buttons for students marks grid -->
                                <div id="Alevel-students-marks-dg-toolbar">
                                    <input type="text" id="A-level-school-marks-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="A-level-marks-general-search" placeholder="search index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#A-level-school-marks-search').combobox('setValue', '');
                                        $('#A-level-marks-general-search').val('');
                                        searchALevelSchoolMarks();
                                    ">Show All</a>
                                </div>

                            </div>
                            <!-- end section for adding i alevel marks -->
                        </div>

                    </div>
                    <?php endif;?>


                    <?php if($_SESSION["Reports"]):?>
                    <div title="Reports" style="padding:5px">
                        <!-- Reports -->
                        <div class="easyui-tabs" data-options="fit:true,border:false,plain:true">

                            <!-- end section add Olevel report -->
                            <div title="O-Level Students Report" style="padding:5px">

                                <table id="olevel-students-report-dg" class="easyui-datagrid" title="O-level Students Marks" style="width:1150px;height:458px"
                                    data-options="singleSelect:false,multiple:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_o_level_students'" toolbar="#olevel-students-report-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'select',width:80, checkbox:true">Select All</th>
                                            <th data-options="field:'school_name',width:250">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div id="olevel-students-report-dg-toolbar">
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="printOLevelStudentReport()">Print Report</a>
                                    <input type="text" id="o-level-school-print-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="o-level-print-general-search" placeholder="search index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#o-level-school-print-search').combobox('setValue', '');
                                        $('#o-level-print-general-search').val('');
                                        searchOLevelSchoolPrint();
                                    ">Show All</a>
                                </div> 

                            </div>
                            <!-- end section add Olevel report -->

                            <!-- begin section for generating Alevel report -->
                            <div title="A-Level Students Marks" style="padding:5px">
                                <table id="Alevel-students-report-dg" class="easyui-datagrid" title="A-level Students Marks" style="width:1150px;height:458px"
                                    data-options="singleSelect:false,multiple:true,collapsible:true,method:'get', pagination:'true', url:'update_school.php?get_all_A_level_students'" toolbar="#Alevel-students-report-dg-toolbar">
                                    <thead>
                                        <tr>
                                            <th data-options="field:'id',width:80, hidden:true">No</th>
                                            <th data-options="field:'select',width:80, checkbox:true">Select All</th>
                                            <th data-options="field:'school_name',width:250">School</th>
                                            <th data-options="field:'center_no',width:100">Center No</th>
                                            <th data-options="field:'index_no',width:200">Index No.</th>
                                            <th data-options="field:'first_name',width:200">First Name</th>
                                            <th data-options="field:'second_name',width:200">Second Name</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div id="Alevel-students-report-dg-toolbar">
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onClick="printALevelStudentReport()">Print Report</a>
                                    <input type="text" id="A-level-school-print-search" >&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="A-level-print-general-search" placeholder="search index no and name" style="width:300px;height:20px;">
                                    <a href="javascript:undefined" class="easyui-linkbutton" onClick="
                                        $('#A-level-school-print-search').combobox('setValue', '');
                                        $('#A-level-print-general-search').val('');
                                        searchALevelSchoolPrint();
                                    ">Show All</a>
                                </div>
                            </div>
                            <!-- end section for generating Alevel report -->

                            <!-- begin section analysed report -->
                            <div title="Analysed report" style="padding:5px">

                            <div class="easyui-panel" style="width:400px; height:'auto'">
                            <table>
                                <tr>
                                    <td>School</td>
                                    <td><input type="text" id="analysed-report-school"></td>
                                </tr>
                                <tr>
                                    <td>Level</td>
                                    <td><input type="text" id="analysed-report-level"></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a href="javascript:undefined" class="easyui-linkbutton" onClick="javascript:printAnalysedReport()" data-options="iconCls:'icon-print'">Print</a>
                                    </td>
                                </tr>
                            </table>

                            </div>

                            </div>
                            <!-- end section analysed report -->
                        </div>
                        


                    </div>
                    <?php endif;?>


                </div>
            </div>
        </div>



        <!-- Begin School Dialog -->
        <div id="school-dlg" class="easyui-dialog" title="Add School" style="width:600px;height:300px;top:100px;padding:10px;"
                data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
                buttons="#school-dlg-btns">
            
            
            <form id="update-school-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="school_id" id="school_id">

                    <tr>
                        <td>School Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="school_name" name="school_name"  required>
                        </td>
                    </tr>

                    <tr>
                        <td>Center No</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="center_no" id="center_no" required>
                        </td>
                    </tr>

                    <tr>
                        <td>No of Students</td>
                        <td>
                            <input class="easyui-validatebox" type="number" name="number_of_students" id="number_of_students" required>
                        </td>
                    </tr>

                    <tr>
                        <td>District</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="district" name="district" required>
                        </td>
                    </tr>
                </table>

            </form>

                
        </div>

        <div id="school-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveSchool()">Save</a>
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#school-dlg').dialog('close');">Close</a>
        </div>
        <!-- End School Dialog -->



        <!-- End O Level student Dialog -->
        <div id="o_level-dlg" class="easyui-dialog" title="Add O-level Student" style="width:75%;height:600px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#o_level-dlg-btns">
            
            <form id="update-o_level-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="o_level_student_id" id="o_level_student_id">

                    <tr>
                        <td>School</td>
                        <td>
                            <input type="text" id="o_level_school_name" name="o_level_school_name"  required>
                        </td>
                    </tr>

                    <tr>
                        <td>Center No</td>
                        <td>
                            <input  type="text" name="o_level_center_no" id="o_level_center_no" disabled>
                        </td>
                    </tr>

                    <tr>
                        <td>First Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="o_level_first_name" id="o_level_first_name" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Second Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="o_level_second_name" id="o_level_second_name" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Index no</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="o_level_index_no" name="o_level_index_no" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveOlevelStudent()">Save</a>
                        </td>
                    </tr>

                </table>

            </form>



            <!-- begin section O_level papers -->
            <table id="olevel-student-subjects-dg" class="easyui-datagrid" title="Student Subjects" style="width:95%;height:65%"
                data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:''" toolbar="#olevel-student-subjects-dg-toolbar">
                <thead>
                    <tr>
                        <th data-options="field:'id',width:80, hidden:true">No</th>
                        <th data-options="field:'name',width:250">Subject</th>
                        <th data-options="field:'subject_code',width:250">Subject Code</th>
                        <th data-options="field:'paper_codes',width:250">Subject Papers</th>
                    </tr>
                </thead>
            </table>

            <div id="olevel-student-subjects-dg-toolbar">
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddOLevelStudentSubjectDlg()">Add</a>
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="openEditOLevelStudentSubjectDlg()">Edit</a>
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="deleteOLevelStudentSubject()">Delete</a>
            </div>
            <!-- end section O_level papers -->

                
        </div>

        <div id="o_level-dlg-btns">
            <!-- <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveSchool()">Save</a> -->
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#olevel-students-dg').datagrid('reload');$('#o_level-dlg').dialog('close');">Close</a>
        </div>
        <!-- End O Level student Dialog -->


        <!-- End O Level student Dialog -->
        <div id="A_level-dlg" class="easyui-dialog" title="Add A-level Student" style="width:75%;height:600px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#A_level-dlg-btns">
            
            <form id="update-A_level-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="A_level_student_id" id="A_level_student_id">

                    <tr>
                        <td>School</td>
                        <td>
                            <input type="text" id="A_level_school_name" name="A_level_school_name"  required>
                        </td>
                    </tr>

                    <tr>
                        <td>Center No</td>
                        <td>
                            <input  type="text" name="A_level_center_no" id="A_level_center_no" disabled>
                        </td>
                    </tr>

                    <tr>
                        <td>First Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="A_level_first_name" id="A_level_first_name" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Second Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="A_level_second_name" id="A_level_second_name" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Index no</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="A_level_index_no" name="A_level_index_no" style="width:300px;" required>
                        </td>
                    </tr>

                    <tr>
                        <td>Combiantion</td>
                        <td>
                            <input class="easyui-combobox" type="text" id="A_level_combination" name="A_level_combination" style="width:300px;" 
                                data-options="url:'update_settings.php?get_all_A-level_combination',
                                valueField:'id', textField:'combination', editable:false"
                            required>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveAlevelStudent()">Save</a>
                        </td>
                    </tr>

                </table>

            </form>



            <!-- begin section A_level papers -->
            <table id="Alevel-student-subjects-dg" class="easyui-datagrid" title="Student Subjects" style="width:95%;height:65%"
                data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:''" toolbar="#Alevel-student-subjects-dg-toolbar">
                <thead>
                    <tr>
                        <th data-options="field:'id',width:80, hidden:true">No</th>
                        <th data-options="field:'name',width:250">Subject</th>
                        <th data-options="field:'subject_code',width:250">Subject Code</th>
                        <th data-options="field:'paper_codes',width:250">Subject Papers</th>
                    </tr>
                </thead>
            </table>

            <div id="Alevel-student-subjects-dg-toolbar">
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddALevelStudentSubjectDlg()">Add</a>
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onClick="openEditALevelStudentSubjectDlg()">Edit</a>
                <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onClick="deleteALevelStudentSubject()">Delete</a>
            </div>
            <!-- end section A_level papers -->

                
        </div>

        <div id="A_level-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#Alevel-students-dg').datagrid('reload'); $('#A_level-dlg').dialog('close');">Close</a>
        </div>
        <!-- End A Level student Dialog -->



        <!-- Begin OLevel Student Subject Dialog -->
        <div id="o_level_student_subject" class="easyui-dialog" title="Add Subject" style="width:600px;height:300px;top:100px;padding:10px;"
                data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
                buttons="#o_level_student_subject-btns">
            
            
            <form id="o_level_student_subject-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <tr>
                        <td>Subject</td>
                        <td>
                            <input type="text" id="student_subject_name" name="student_subject_name"  required>
                        </td>
                    </tr>

                    <tr>
                        <td>Paper Code</td>
                        <td>
                            <input id="student_subject_papers" name="student_subject_papers" style="width:200px" required>
                        </td>
                    </tr>
                </table>

            </form>

                
        </div>

        <div id="o_level_student_subject-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveOLevelStudentSubject()">Save</a>
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#o_level_student_subject').dialog('close');">Close</a>
        </div>
        <!-- Begin ALevel Student Subject Dialog -->

        <!-- Begin ALevel Student Subject Dialog -->
        <div id="A_level_student_subject" class="easyui-dialog" title="Add Subject" style="width:600px;height:300px;top:100px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#A_level_student_subject-btns">
            
            
            <form id="A_level_student_subject-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <tr>
                        <td>Subject</td>
                        <td>
                            <input type="text" id="student_subject_name_Alevel" name="student_subject_name_Alevel"  required>
                        </td>
                    </tr>

                    <tr>
                        <td>Paper Code</td>
                        <td>
                            <input id="student_subject_papers_Alevel" name="student_subject_papers_Alevel" style="width:200px" required>
                        </td>
                    </tr>
                </table>

            </form>

                
        </div>

        <div id="A_level_student_subject-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveALevelStudentSubject()">Save</a>
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#A_level_student_subject').dialog('close');">Close</a>
        </div>
        <!-- Begin ALevel Student Subject Dialog -->


        <!-- Begin School-level student marksol Dialog -->
        <div id="o_level-marks-dlg" class="easyui-dialog" title="Add O-level Student Marks" style="width:75%;height:600px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#o_level-marks-dlg-btns"
            >
            
            
            <form id="update-o_level-student-marks-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="o_level_student_id_marks" id="o_level_student_id_marks">

                    <tr>
                        <td>School</td>
                        <td>
                            <input type="text" id="o_level_school_name_marks" name="o_level_school_name_marks"  readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Center No</td>
                        <td>
                            <input  type="text" name="o_level_center_no_marks" id="o_level_center_no_marks" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>First Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="o_level_first_name_marks" id="o_level_first_name_marks" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Second Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="o_level_second_name_marks" id="o_level_second_name_marks" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Index no</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="o_level_index_no_marks" name="o_level_index_no_marks" style="width:300px;" readonly>
                        </td>
                    </tr>


                </table>

            </form>



            <!-- begin section O_level papers -->
            <table id="olevel-student-subjects-marks-dg" class="easyui-datagrid" title="Student Subjects" style="width:900px;height:65%"
                data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:''" toolbar="#olevel-student-subjects-marks-dg-toolbar">
                <thead>
                    <tr>
                        <th data-options="field:'id',width:80, hidden:true">No</th>
                        <th data-options="field:'subject_name',width:200">Subject</th>
                        <th data-options="field:'paper_code',width:200">Paper</th>
                        <th data-options="field:'paper_code',width:100">PaperCode</th>
                        <th data-options="field:'marks',width:100">Marks</th>
                        <th data-options="field:'student_mark_Action',width:100" formatter="student_mark_Action">Action</th>
                    </tr>
                </thead>
            </table>
            <!-- end section O_level papers -->

                
        </div>

        <div id="o_level-marks-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#o_level-marks-dlg').dialog('close');">Close</a>
        </div>
        <!-- End o-level student marks Dialog -->


        <!-- Begin A level School-level student marksol Dialog -->
        <div id="A_level-marks-dlg" class="easyui-dialog" title="Add A-level Student Marks" style="width:75%;height:600px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#A_level-marks-dlg-btns"
            >
            
            
            <form id="update-A_level-student-marks-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="A_level_student_id_marks" id="A_level_student_id_marks">

                    <tr>
                        <td>School</td>
                        <td>
                            <input type="text" id="A_level_school_name_marks" name="A_level_school_name_marks"  readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Center No</td>
                        <td>
                            <input  type="text" name="A_level_center_no_marks" id="A_level_center_no_marks" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>First Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="A_level_first_name_marks" id="A_level_first_name_marks" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Second Name</td>
                        <td>
                            <input class="easyui-validatebox" type="text" name="A_level_second_name_marks" id="A_level_second_name_marks" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Index no</td>
                        <td>
                            <input class="easyui-validatebox" type="text" id="A_level_index_no_marks" name="A_level_index_no_marks" style="width:300px;" readonly>
                        </td>
                    </tr>
                </table>
            </form>

            <!-- begin section A_level papers -->
            <table id="Alevel-student-subjects-marks-dg" class="easyui-datagrid" title="Student Subjects" style="width:900px;height:65%"
                data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:''" toolbar="#Alevel-student-subjects-marks-dg-toolbar">
                <thead>
                    <tr>
                        <th data-options="field:'id',width:80, hidden:true">No</th>
                        <th data-options="field:'subject_name',width:200">Subject</th>
                        <th data-options="field:'paper_code',width:200">Paper</th>
                        <th data-options="field:'paper_code',width:100">PaperCode</th>
                        <th data-options="field:'marks',width:100">Marks</th>
                        <th data-options="field:'student_mark_Action',width:100" formatter="student_mark_Action_A_level">Action</th>
                    </tr>
                </thead>
            </table>
            <!-- end section A_level papers -->
        </div>

        <div id="A_level-marks-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#A_level-marks-dlg').dialog('close');">Close</a>
        </div>
        <!-- End A-level student marks Dialog -->


        <!-- Begin O level student Mark Dialog -->
        <div id="o_level-marks-mark-dlg" class="easyui-dialog" title="Edit O-level Student Mark" style="width:600px;height:300px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#o_level-marks-mark-dlg-btns">

            <form id="update-o_level-student-marks-mark-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="mark_id" id="mark_id">

                    <tr>
                        <td>Subject</td>
                        <td>
                            <input type="text" id="subejct_name" name="subejct_name"  readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Paper</td>
                        <td>
                            <input  type="text" name="paper_name" id="paper_name" readonly>
                        </td>
                    </tr>


                    <tr>
                        <td>Paper Code</td>
                        <td>
                            <input type="text" name="paper_code" id="paper_code" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Mark (Put -1 incase the student never did the paper)</td>
                        <td>
                            <input class="easyui-numberbox" data-options="min:-1, max:100, precession:2" type="number" id="paper_mark" name="paper_mark" style="width:300px;" required>
                        </td>
                    </tr>


                </table>

            </form>


        <div id="o_level-marks-mark-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="updateoLevelStudentMarks()">Save</a>
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#o_level-marks-mark-dlg').dialog('close');">Close</a>
        </div>
        <!-- end O level student Mark Dialog -->


        <!-- Begin A level student Mark Dialog -->
        <div id="A_level-marks-mark-dlg" class="easyui-dialog" title="Edit A-level Student Mark" style="width:600px;height:300px;top:50px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#A_level-marks-mark-dlg-btns">

            <form id="update-A_level-student-marks-mark-form" class="easyui-form" method="POST" novalidate="false">
                <table>

                    <input type="hidden" name="mark_id_A_level" id="mark_id_A_level">

                    <tr>
                        <td>Subject</td>
                        <td>
                            <input type="text" id="subejct_name_A_level" name="subejct_name_A_level"  readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Paper</td>
                        <td>
                            <input  type="text" name="paper_name_A_level" id="paper_name_A_level" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Paper Code</td>
                        <td>
                            <input type="text" name="paper_code_A_level" id="paper_code_A_level" style="width:300px;" readonly>
                        </td>
                    </tr>

                    <tr>
                        <td>Mark (Put -1 incase the student never did the paper)</td>
                        <td>
                            <input class="easyui-numberbox" data-options="min:-1, max:100, precession:2" type="number" id="paper_mark_A_level" name="paper_mark_A_level" style="width:300px;" required>
                        </td>
                    </tr>


                </table>

            </form>


        <div id="A_level-marks-mark-dlg-btns">
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="updateALevelStudentMarks()">Save</a>
            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#A_level-marks-mark-dlg').dialog('close');">Close</a>
        </div>
        <!-- end A level student Mark Dialog -->



        
    </div>
    <script>

        const printAnalysedReport = () => {
            let school_id = $('#analysed-report-school').combobox('getValue');
            let level = $('#analysed-report-level').combobox('getValue');

            if (!school_id) {
                return showMessager('Info', 'Plaese select a school');
            }

            if (!level) {
                return showMessager('Info', 'Plaese select a level');
            }

            if (level == 'O-level')
                var window_status = window.open('print_analysed_report.php?school_id='+ school_id + '&level=' + level, 'Student Printout', 'top:0px;left:0px;width:400px;' );
            else
                var window_status = window.open('print_analysed_report_a_level.php?school_id='+ school_id + '&level=' + level, 'Student Printout', 'top:0px;left:0px;width:400px;' );
            if (!window_status) {
                showMessager('Info', 'Please Disable your pop-up blocker to pritnt the report');
            }



        }

        function openAddSchoolDlg ()
        {
            $('#update-school-form').form('clear');
            $('#school-dlg').dialog('setTitle', 'Add School').dialog('open');
        }

        function searchOLevelSchool ()
        {

            setTimeout(() => {
                let school_id = $('#o-level-school-search').combobox('getValue');
                let extra_search = $('#o-level-general-search').val();

                $('#olevel-students-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                });
                $('#o-level-general-search').focus();
            }, 500);
            
        }

        function searchALevelSchool ()
        {   

            setTimeout(() => {
                let school_id = $('#A-level-school-search').combobox('getValue');
                let extra_search = $('#A-level-general-search').val();

                $('#Alevel-students-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                });
                $('#A-level-general-search').focus();
            }, 500);

            
        }

        /**
         search student marks entries in the o level student marks section
         */
        function searchOLevelSchoolMarks ()
        {

            setTimeout(() => {
                let school_id = $('#o-level-school-marks-search').combobox('getValue');
                let extra_search = $('#o-level-marks-general-search').val();

                $('#olevel-students-marks-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                });
                $('#o-level-marks-general-search').focus();
            }, 500);

            
        }

        function searchOLevelSchoolPrint ()
        {

            setTimeout(() => {
                let school_id = $('#o-level-school-print-search').combobox('getValue');
                let extra_search = $('#o-level-print-general-search').val();

                $('#olevel-students-report-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                }) 
                $('#o-level-print-general-search').focus();
            }, 500);

            
        }

        function searchALevelSchoolPrint ()
        {
            setTimeout(() => {
                let school_id = $('#A-level-school-print-search').combobox('getValue');
                let extra_search = $('#A-level-print-general-search').val();

                $('#Alevel-students-report-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                })
                $('#A-level-print-general-search').focus();
            }, 500);

            
        }

        function searchALevelSchoolMarks ()
        {
            setTimeout(() => {
                let school_id = $('#A-level-school-marks-search').combobox('getValue');
                let extra_search = $('#A-level-marks-general-search').val();

                $('#Alevel-students-marks-dg').datagrid({
                    queryParams: {
                        school_id: school_id,
                        extra_search: extra_search
                    }
                });
                $('#A-level-marks-general-search').focus();
            }, 500);

            
        }

        function saveSchool ()
        {
            $('#update-school-form').form('submit', {
                url: "update_school.php?add_update_school",
                onSubmit: function (param) {
                    return $(this).form('validate');
                },
                success: function (data) {
                    //reload schools grid from here
                    $('#school-dlg').dialog('close');
                    $('#schools-dg').datagrid('reload');
                }
            }); 
        }

        function printOLevelStudentReport ()
        {
            var rows = $('#olevel-students-report-dg').datagrid('getSelections');
            if (rows) {
                var ids = [];

                $.each(rows, function (index, row) {
                    ids.push(row.id);
                });
                ids = ids.join(',');
                
                var window_status = window.open('printout_o_level_student_report.php?student_ids='+ ids, 'Student Printout', 'top:0px;left:0px;width:400px;' );

                if (!window_status) {
                    showMessager('Info', 'Please Disable your po-up blocker to pritnt the report');
                }

            } else {
                showMessager('Info', 'Please select a student to from the list');
            }
        }

        function printALevelStudentReport ()
        {
            var rows = $('#Alevel-students-report-dg').datagrid('getSelections');
            if (rows) {

                var ids = [];

                $.each(rows, function (index, row) {
                    ids.push(row.id);
                });
                ids = ids.join(',');

                var window_status = window.open('printout_A_level_student_report.php?student_ids='+ ids, 'Student Printout', 'top:0px;left:0px;width:400px;' );

                if (!window_status) {
                    showMessager('Info', 'Please Disable your po-up blocker to pritnt the report');
                }

            } else {
                showMessager('Info', 'Please select a student to from the list');
            }
        }


        function oLevelStudentActionFormtter (value, row, index)
        {
            if (row.id) {
                return '<input type="button" value="edit" onClick="openEditOLevelStudentDlg()"> <input type="button" value="delete" onClick="deleteOLevelStudent('+row.id+')">';
            }
        }

        function ALevelStudentActionFormtter (value, row, index)
        {
            if (row.id) {
                return '<input type="button" value="edit" onClick="openEditALevelStudentDlg('+index+')">'
                +' <input type="button" value="delete" onClick="deleteALevelStudent('+row.id+')">';
            }
        }


        function oLevelStudentMarksActionFormtter (value, row, index)
        {
            if (row.id) {
                return '<input type="button" value="View / Edit" onClick="openEditOLevelStudentMarksDlg()">';
            }
        }

        /**
         * return html action bttons to edit an Alevel student mark
         */
        function ALevelStudentMarksActionFormtter (value, row, index)
        {
            if (row.id) {
                return '<input type="button" value="View / Edit" onClick="openEditALevelStudentMarksDlg()">';
            }
        }

        function schoolActionFormtter (value, row, index)
        {
            if (row.id) {
                return '<input type="button" value="edit" onClick="editSchool()"> <input type="button" value="delete" onClick="deleteSchool('+row.id+')">';
            }
        }

        function student_mark_Action ()
        {
            return '<input type="button" value="edit" onClick="openDlgEditoLevelStudentMark()">';
        }


        /**
         * 
         */
        function student_mark_Action_A_level ()
        {
            return '<input type="button" value="edit" onClick="openDlgEditALevelStudentMark()">';
        }

        function editOLevelStudentMark ()
        {
            var row = $('#olevel-student-subjects-dg').dialog('getSelected');
            if (row) {
                
            } else {
                $.messager.show({
                    title: 'Info',
                    msg: 'Please select a paper to edit'
                })
            }
        }

        function deleteSchool (id) 
        {
            $.messager.confirm('Confirm', 'Are you sure you want to delete this school?', function (r) {
                if (r) {
                    $.post('update_school.php?delete_school', {id: id}, function (response){
                    if (response.success) {
                        $('#schools-dg').datagrid('reload');
                        showMessager('Info', 'School Deleted Successfully');
                    } else {
                        showMessager('Info', response.message);
                    }
                }, 'JSON');
                }
            });
        }
        

        function showMessager (title, msg)
        {
            $.messager.show({
                title: title,
                msg: msg
            });
        }

        function editSchool ()
        {

            setTimeout(() => {
                var row = $('#schools-dg').datagrid('getSelected');
                if (!row) {
                    showMessager('Warning', 'Please select a school to edit');
                    return;
                }
                
                $('#update-school-form').form('clear');
                $('#school_id').val(row.id);
                $('#school_name').val(row.name);
                $('#center_no').val(row.center_no);
                $('#number_of_students').val(row.no_of_students);
                $('#district').val(row.district); 
                $('#school-dlg').dialog('setTitle', 'Edit School').dialog('open');

            }, 500);
            

        }

        function openAddOLevelStudentDlg ()
        {
            resetStudentContent();
            $('#o_level-dlg').dialog('setTitle', 'Add O-level Student').dialog('open');
        }

        /**
         * 
         */
        function openAddALevelStudentDlg ()
        {
            resetAlevelStudentContent();
            $('#A_level-dlg').dialog('setTitle', 'Add A-level Student').dialog('open');
        }

        /**
         * This reset the Alevel student form from here
         */
        function resetAlevelStudentContent ()
        {
            $('#A_level_student_id').val('0');
            $('#A_level_school_name').combobox("setValue", "");
            $('#A_level_center_no').val("");
            $('#A_level_first_name').val("");
            $('#A_level_second_name').val("");
            $('#A_level_index_no').val("");

            //load student results from here
            $('#Alevel-student-subjects-dg').datagrid({
                url: 'update_school.php?get_student_subject_papers_Alevel&student_id=-1'
            });

        }

        function openEditOLevelStudentDlg ()
        {
            setTimeout(() => {
                let row = $('#olevel-students-dg').datagrid('getSelected');
                if (row) {
                    $('#o_level_student_id').val(row.id);
                    $('#o_level_school_name').combobox("setValue", row.school_id);
                    $('#o_level_center_no').val(row.center_no);
                    $('#o_level_first_name').val(row.first_name);
                    $('#o_level_second_name').val(row.second_name);
                    $('#o_level_index_no').val(row.index_no);
                    $('#o_level-dlg').dialog('setTitle', 'Edit O-level Student').dialog('open'); 


                    //load student results from here
                    $('#olevel-student-subjects-dg').datagrid({
                        url: 'update_school.php?get_student_subject_papers&student_id='+ row.id
                    });

                } else {
                    showMessager('Warning', 'Please Select Student to edit');
                }
                  
            }, 500);
            
        }

        function openEditALevelStudentDlg (index)
        {
            // select the index first
            $('#Alevel-students-dg').datagrid('selectRow', index);
            let row = $('#Alevel-students-dg').datagrid('getSelected');
            if (row) {
                $('#update-A_level-form').form('clear');
                $('#A_level_student_id').val(row.id);
                $('#A_level_school_name').combobox("setValue", row.school_id);
                $('#A_level_center_no').val(row.center_no);
                $('#A_level_first_name').val(row.first_name);
                $('#A_level_second_name').val(row.second_name);
                $('#A_level_index_no').val(row.index_no);
                if (row.combination_id > 0)
                    $('#A_level_combination').combobox("setValue", row.combination_id);
                $('#A_level-dlg').dialog('setTitle', 'Edit A-level Student').dialog('open'); 


                //load student results from here
                $('#Alevel-student-subjects-dg').datagrid({
                    url: 'update_school.php?get_student_subject_papers_Alevel&student_id='+ row.id
                });

            } else {
                showMessager('Warning', 'Please Select Student to edit');
            }
            
        }

        function openEditOLevelStudentMarksDlg ()
        {
            setTimeout(() => {
                let row = $('#olevel-students-marks-dg').datagrid('getSelected');
                if (row) {
                    $('#o_level_student_id_marks').val(row.id);
                    $('#o_level_school_name_marks').val(row.school_name);
                    $('#o_level_center_no_marks').val(row.center_no);
                    $('#o_level_first_name_marks').val(row.first_name);
                    $('#o_level_second_name_marks').val(row.second_name);
                    $('#o_level_index_no_marks').val(row.index_no);
                    $('#o_level-marks-dlg').dialog('setTitle', 'Edit O-level Student marks').dialog('open'); 


                    //load student results from here
                    $('#olevel-student-subjects-marks-dg').datagrid({
                       url: 'update_school.php?get_student_subject_papers_marks&student_id='+ row.id
                    });

                } else {
                    showMessager('Warning', 'Please Select Student to edit');
                }
                  
            }, 500);
        }


        /**
         *
         */
        function openEditALevelStudentMarksDlg ()
        {
            setTimeout(() => {
                let row = $('#Alevel-students-marks-dg').datagrid('getSelected');
                if (row) {
                    $('#A_level_student_id_marks').val(row.id);
                    $('#A_level_school_name_marks').val(row.school_name);
                    $('#A_level_center_no_marks').val(row.center_no);
                    $('#A_level_first_name_marks').val(row.first_name);
                    $('#A_level_second_name_marks').val(row.second_name);
                    $('#A_level_index_no_marks').val(row.index_no);
                    $('#A_level-marks-dlg').dialog('setTitle', 'Edit A-level Student marks').dialog('open'); 


                    //load student results from here
                    $('#Alevel-student-subjects-marks-dg').datagrid({
                       url: 'update_school.php?get_student_subject_papers_marks_a_level&student_id='+ row.id
                    });

                } else {
                    showMessager('Warning', 'Please Select Student to edit');
                }
                  
            }, 500);
        }

        function openDlgEditoLevelStudentMark ()
        {
            setTimeout(() => {
                let row = $('#olevel-student-subjects-marks-dg').datagrid('getSelected');
                if (row) {
                    $('#mark_id').val(row.id);
                    $('#subejct_name').val(row.subject_name);
                    $('#paper_name').val(row.paper_code);
                    $('#paper_code').val(row.paper_code);
                    row.marks = parseFloat(row.marks, 10);
                    row.marked_out_of = parseFloat(row.marked_out_of, 10);
                    var actual_mark = (row.marks) * (row.marked_out_of / 100)
                    $('#paper_mark').numberbox('setValue', actual_mark);
                    $('#o_level-marks-mark-dlg').dialog('setTitle', 'Edit O-level Student marks').dialog('open'); 
                } else {
                    showMessager('Warning', 'Please Select Student to edit');
                }
                  
            }, 500);
        }

        function openDlgEditALevelStudentMark ()
        {
            setTimeout(() => {
                let row = $('#Alevel-student-subjects-marks-dg').datagrid('getSelected');
                if (row) {
                    $('#mark_id_A_level').val(row.id);
                    $('#subejct_name_A_level').val(row.subject_name);
                    $('#paper_name_A_level').val(row.paper_code);
                    $('#paper_code_A_level').val(row.paper_code);
                    $('#paper_mark_A_level').numberbox('setValue', row.marks);
                    $('#A_level-marks-mark-dlg').dialog('setTitle', 'Edit A-level Student marks').dialog('open'); 
                } else {
                    showMessager('Warning', 'Please Select Student to edit');
                }

            }, 500);
        }

        function updateoLevelStudentMarks ()
        {
            $('#update-o_level-student-marks-mark-form').form('submit', {
                url: 'update_school.php?update_o_level_student_mark',
                onSubmit: function (param) {
                    return $(this).form('validate');
                },
                success: function (response) {
                    if (response == '1') {
                        showMessager('Info', 'Update Successfull');
                        $('#o_level-marks-mark-dlg').dialog('close');
                        $('#olevel-student-subjects-marks-dg').datagrid('reload');
                    } else {
                        showMessager('Warning', 'Something is not right');
                    }
                }
            })
        }

        function updateALevelStudentMarks ()
        {
            $('#update-A_level-student-marks-mark-form').form('submit', {
                url: 'update_school.php?update_A_level_student_mark',
                onSubmit: function (param) {
                    return $(this).form('validate');
                },
                success: function (response) {
                    if (response == '1') {
                        showMessager('Info', 'Update Successfull');
                        $('#A_level-marks-mark-dlg').dialog('close');
                        $('#Alevel-student-subjects-marks-dg').datagrid('reload');
                    } else {
                        showMessager('Warning', 'Something is not right');
                    }
                }
            })
        }


        function deleteOLevelStudent (student_id)
        {
            $.messager.confirm('Confirm', 'Are you sure you want to delete this student?', function (r) {
                if (r) {
                    $.get('update_school.php?delete_o_level_student', {id: student_id }, function(data) {

                        $('#olevel-students-dg').datagrid('reload');
                        showMessager('Info', 'Student Deleted successfully');

                    }, 'JSON' );
                }
            });
        }

        function deleteALevelStudent (student_id)
        {
            $.messager.confirm('Confirm', 'Are you sure you want to delete this student?', function (r) {
                if (r) {
                    $.get('update_school.php?delete_A_level_student', {id: student_id }, function(data) {

                        $('#Alevel-students-dg').datagrid('reload');
                        showMessager('Info', 'Student Deleted successfully');

                    }, 'JSON' );
                }
            });
        }

        function resetStudentContent ()
        {
            $('#o_level_student_id').val('0');
            $('#o_level_school_name').combobox("setValue", "");
            $('#o_level_center_no').val("");
            $('#o_level_first_name').val("");
            $('#o_level_second_name').val("");
            $('#o_level_index_no').val("");

            //load student results from here
            $('#olevel-student-subjects-dg').datagrid({
                url: 'update_school.php?get_student_subject_papers&student_id=-1'
            });

        }

        function saveOlevelStudent ()
        {
            $('#update-o_level-form').form('submit', {
                url: "update_school.php?add_o_level_student",
                onSubmit: function (param) {
                    return $(this).form('validate');
                },
                success: function (insert_id) {
                    $('#o_level_student_id').val(insert_id);
                    //load student results from here
                    $('#olevel-student-subjects-dg').datagrid({
                        url: 'update_school.php?get_student_subject_papers&student_id=' + insert_id
                    });
                    showMessager('Info', 'Update Successful');
                }
            }); 
        }

        function saveAlevelStudent ()
        {
            $('#update-A_level-form').form('submit', {
                url: "update_school.php?add_A_level_student",
                onSubmit: function (param) {
                    return $(this).form('validate');
                },
                success: function (insert_id) {
                    $('#A_level_student_id').val(insert_id);

                    //load student results from here
                    $('#Alevel-student-subjects-dg').datagrid({
                        url: 'update_school.php?get_student_subject_papers_Alevel&student_id=' + insert_id
                    });
                    showMessager('Info', 'Update Successful');
                }
            }); 
        }

        function openEditOLevelStudentSubjectDlg ()
        {
            var row = $('#olevel-student-subjects-dg').datagrid('getSelected');
            if (row) {
                $('#o_level_student_subject-form').form('clear');
                //set the values from here
                $('#student_subject_name').combobox('setValue', row.id);

                $('#student_subject_papers').combogrid({
                    url: 'update_school.php?get_all_o_level_subejcts_papers_combo&subject_id=' + row.id
                });

                var my_paper_ids = row.paper_ids.split(',');
                $('#student_subject_papers').combogrid('setValue', my_paper_ids);
                $('#o_level_student_subject').dialog('setTitle', 'Edit Subject Fro Student').dialog('open');
            } else {
                showMessager('info', 'Please select a subjec to edit');
            }
            
        }

        /**
         * add subject to an Alevel student
         * @param void
         * @return void
         */
        function openEditALevelStudentSubjectDlg ()
        {
            var row = $('#Alevel-student-subjects-dg').datagrid('getSelected');
            if (row) {
                $('#A_level_student_subject-form').form('clear');
                //set the values from here
                $('#student_subject_name_Alevel').combobox('setValue', row.id);

                $('#student_subject_papers_Alevel').combogrid({
                    url: 'update_school.php?get_all_A_level_subejcts_papers_combo&subject_id=' + row.id
                });

                var my_paper_ids = row.paper_ids.split(',');
                $('#student_subject_papers_Alevel').combogrid('setValue', my_paper_ids);
                $('#A_level_student_subject').dialog('setTitle', 'Edit Subject For Student').dialog('open');
            } else {
                showMessager('Info', 'Please select a subjec to edit');
            }
            
        }


        function openAddOLevelStudentSubjectDlg ()
        {
            $('#o_level_student_subject-form').form('clear');
            $('#o_level_student_subject').dialog('setTitle', 'Add Subject for Student').dialog('open');
        }

        function openAddALevelStudentSubjectDlg ()
        {
            $('#A_level_student_subject-form').form('clear');
            $('#A_level_student_subject').dialog('setTitle', 'Add Subject for Student').dialog('open');
        }

        function deleteOLevelStudentSubject ()
        {
            var row = $('#olevel-student-subjects-dg').datagrid('getSelected');
            var student = $('#o_level_student_id').val();
            if (row) {

                $.get('update_school.php?delete_o_level_student_subject', {id: row.id, student_id: student}, function(data) {
                    $('#olevel-student-subjects-dg').datagrid('reload');
                }, 'JSON');

            } else {
                $.messager.show({
                    title: 'info',
                    msg: 'please select a subejct for a student to edit'
                })
            }
        }


        /**
         * Delete A level Student Assigned Subject
         */
        function deleteALevelStudentSubject ()
        {
            var row = $('#Alevel-student-subjects-dg').datagrid('getSelected');
            var student = $('#A_level_student_id').val();
            if (row) {
                $.get('update_school.php?delete_A_level_student_subject', {id: row.id, student_id: student}, function(data) {
                    $('#Alevel-student-subjects-dg').datagrid('reload'); 
                }, 'JSON');

            } else {
                $.messager.show({
                    title: 'info',
                    msg: 'please select a subejct for a student to edit'
                })
            }
        }

        function saveOLevelStudentSubject ()
        {
            $('#o_level_student_subject-form').form('submit', {
                url: "update_school.php?add_o_level_student_subject",
                onSubmit: function (param) {
                    // param.subject_id = 
                    param.student_id = $('#o_level_student_id').val();
                    param.papers_collection = $('#student_subject_papers').combogrid('getValues');

                    return $(this).form('validate');
                },
                success: function (data) {
                    $('#o_level_student_subject').dialog('close');
                    $('#olevel-student-subjects-dg').datagrid('reload');
                    showMessager('Info', 'Update Successful');
                }
            }); 
        }

        /**
         * Update the student subject from here
         */
        function saveALevelStudentSubject ()
        {
            $('#A_level_student_subject-form').form('submit', {
                url: "update_school.php?add_A_level_student_subject",
                onSubmit: function (param) {

                    param.subject_id = $('#student_subject_name_Alevel').combobox('getValue');
                    param.student_id = $('#A_level_student_id').val();
                    param.papers_collection = $('#student_subject_papers_Alevel').combogrid('getValues');

                    return $(this).form('validate');
                },
                success: function (data) {
                    $('#A_level_student_subject').dialog('close');
                    $('#Alevel-student-subjects-dg').datagrid('reload');
                    showMessager('Info', 'Update Successful');
                }
            }); 
        }

    </script>


    <script>
        $(function () {


            $('#analysed-report-level').combobox({
                panelHeight: 'auto',
                data: [
                    {
                        name: 'O-level',
                        value: 'O-level'
                    },
                    {
                        name: 'A-level',
                        value: 'A-level'
                    }
                ],
                valueField: 'value',
                textField: 'name',
                width: 100,
                editable:false
            });

            $('#update-school-form, #o_level_student_subject-form, #update-o_level-form, #update-A_level-form ').form({
                url: ""
            });

            $('#school-section-general-search').keyup(function (e) {
                var search = $(this).val();
                $('#schools-dg').datagrid({
                    queryParams: {
                        search: search
                    }
                });
                $(this).focus();
            });
            

            $('#o-level-general-search').keyup(function (e) {
                searchOLevelSchool();
                $(this).focus();
            });

            $('#A-level-general-search').keyup(function (e) {
                searchALevelSchool();
                $(this).focus();
            });

            $('#o-level-marks-general-search').keyup(function (e) {
                searchOLevelSchoolMarks();
                $(this).focus();
            });

            $('#o-level-print-general-search').keyup(function (e) {
                searchOLevelSchoolPrint();
                $(this).focus();
            });

            $('#A-level-print-general-search').keyup(function (e) {
                searchALevelSchoolPrint();
                $(this).focus();
            });

            $('#A-level-marks-general-search').keyup(function (e) {
                searchALevelSchoolMarks();
                $(this).focus();
            });


            $.getJSON("update_school.php?get_all_schools_combo", {}, function (data) {

                $('#o_level_school_name, #analysed-report-school').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true
                });

                $('#o_level_school_name').combobox({
                    onSelect: function (row) {
                    $('#o_level_center_no').val(row.center_no); 
                    }
                });


                $('#o-level-school-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchOLevelSchool();
                    }
                });
                $('#A-level-school-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchALevelSchool();
                    }
                });

                $('#o-level-school-marks-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchOLevelSchoolMarks();
                    }
                });

                $('#A-level-school-marks-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchALevelSchoolMarks();
                    }
                });

                $('#o-level-school-print-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchOLevelSchoolPrint();
                    }
                });

                $('#A-level-school-print-search').combobox({
                    data: data,
                    width: 300,
                    panelHeight: 100,
                    valueField: "id",
                    textField: "name",
                    editable: true,
                    onSelect: function (row) {
                        searchALevelSchoolPrint();
                    }
                });

            });


            $('#A_level_school_name').combobox({
                width: 300,
                panelHeight: 100,
                url: "update_school.php?get_all_schools_combo",
                valueField: "id",
                textField: "name",
                editable: true,
                onSelect: function (row) {
                   $('#A_level_center_no').val(row.center_no); 
                }
            });

            $('#student_subject_name').combobox({
                width: 200,
                panelHeight: 300,
                url: "update_school.php?get_all_o_level_subejcts_combo",
                valueField: "id",
                textField: "name",
                editable: true,
                onSelect: function (row) {

                    $('#student_subject_papers').combogrid({
                        url: 'update_school.php?get_all_o_level_subejcts_papers_combo&subject_id=' + row.id
                    });
                }
            });


            // load all A level student subjects
            $('#student_subject_name_Alevel').combobox({
                width: 200,
                panelHeight: 300,
                url: "update_school.php?get_all_A_level_subejcts_combo",
                valueField: "id",
                textField: "name",
                editable: true,
                onSelect: function (row) {

                    $('#student_subject_papers_Alevel').combogrid({
                        url: 'update_school.php?get_all_A_level_subejcts_papers_combo&subject_id=' + row.id
                    });

                }
            });

            $('#student_subject_papers').combogrid({
                url: 'update_school.php?get_all_o_level_subejcts_papers_combo&subject_id=0',
                idField: 'id',
                panelHeigh:'auto',
                textField: 'paper_code',
                editable: false,
                singleSelect: false,
                multiple: true,
                columns: [[
                    {field:'select',title:'select',width:50, checkbox:true},
                    {field:'paper_code',title:'Paper',width:150}
                ]]
            });

            // define subject paper codes for student 
            $('#student_subject_papers_Alevel').combogrid({
                url: 'update_school.php?get_all_o_level_subejcts_papers_combo&subject_id=0',
                idField: 'id',
                panelHeigh:'auto',
                textField: 'paper_code',
                editable: false,
                singleSelect: false,
                multiple: true,
                columns: [[
                    {field:'select',title:'select',width:50, checkbox:true},
                    {field:'paper_code',title:'Paper',width:150}
                ]]
            });



        });
    </script>

</body>
</html>