
<?php

if (!isset($_SESSION))
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<title>KAMSSA</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel = "icon" type = "../image/png" href = "../Images/logo.jpeg	">
<link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/themes/icon.css">
<link rel="stylesheet" type="text/css" href="../Js/jquery-easyui-1.6.4/demo/demo.css">
<script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.easyui.min.js"></script>
<script type="text/javascript" src="../Js/jquery-easyui-1.6.4/jquery.edatagrid.js"></script>

</head>

<body>

<div class="content-wrapper" style="padding:0px 0px 0px 0px; background-color:white; width:1200px; margin-left:auto; margin-right:auto;">
    
    <!-- begin section for the nav bar -->
    <ul id="menu-navbar" class="content-wrapper">
        <li><a href="index.php">KAMSSA HOME</a></li>
        <!-- <li><a href="#news">News</a></li> -->
        <li><a href="#contact">Settings</a></li>

        <span id="logout-text-section">
            <span>Logged in as <?= $_SESSION['username']?></span>    
            <li >
                <a href="../index.php?logout"><span id="logout-text">Logout</span></a>
            </li>
        </span>
        
    </ul>

    <div menu-section2>
        <button id="menu-btn" onClick="$('#menu-tems-section').toggle();">Menu</button>
        <!-- begin section menu items -->
        <?php
            require_once '../Includes/menu_items.php';
        ?>
        <!-- End section menu items -->
    </div>

    <!-- begin section for schools -->
    <table id="subjects-dg" class="easyui-datagrid" title="O-level subject setup" style="width:1170px;height:500px"
        data-options="singleSelect:true,collapsible:true,method:'get', pagination:'true', url:'update_settings.php?get_all_o_level_subjects', fitcolumns:false" toolbar="#settings-dg-toolbar">
        <thead>
            <tr>
                <th data-options="field:'id',width:80">No</th>
                <th data-options="field:'name',width:200">Subject Name</th>
                <th data-options="field:'subject_code',width:150,align:'center'">Subject Code</th>
                <th data-options="field:'subject_papers',width:200,align:'left'">Papers</th>
                <th data-options="field:'subject_is_core',width:100,align:'center'">Compulsory</th>
                <th data-options="field:'subject_default_papers',width:150,align:'center'">Default Papers</th>
                <th data-options="field:'no_of_papers_done',width:'auto',align:'center'">Papers Done</th>
                <th data-options="field:'action',width:180,align:'center'" formatter= "userActionFormtter">Action</th>
            </tr>
        </thead>
    </table>

    <div id="settings-dg-toolbar">
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onClick="openAddSubjectDlg()">Add</a>
        <input type="text" id="user-section-general-search" placeholder="Search..." style="width:300px;height:20px;">
    </div>
    <!-- End section for schools -->



    <!-- Begin School Dialog -->
    <div id="subject-dlg" class="easyui-dialog" title="Add School" style="width:600px;height:500;top:100px;padding:10px;"
            data-options="iconCls:'icon-save',resizable:true,modal:true, closed:true, closable:false" 
            buttons="#subject-dlg-btns">
        
        
        <form id="update-subject-form" class="easyui-form" method="POST" novalidate="false">
            <table>

                <input type="hidden" name="subject_id" id="subject_id">

                <tr>
                    <td>Subject Name</td>
                    <td>
                        <input class="easyui-validatebox" type="text" id="subject_name" name="subject_name"  required>
                    </td>
                </tr>

                <tr>
                    <td>Subject Short Name</td>
                    <td>
                        <input class="easyui-validatebox" type="text" id="short_name" name="short_name"  required>
                    </td>
                </tr>

                <tr>
                    <td>Subject Code</td>
                    <td>
                        <input class="easyui-validatebox" type="text" id="subject_code" name="subject_code"  required>
                    </td>
                </tr>

                <tr>
                    <td>No of papers done</td>
                    <td>
                        <input type="text" class="easyui-numberbox" data-options="min:1,required:true" id="no_of_papers_done" value="1" name="no_of_papers_done"  required>
                    </td>
                </tr>

                <tr>
                    <td>Compulsory</td>
                    <td>
                        <input type="checkbox" id="subject_is_core" name="subject_is_core"  required>
                    </td>
                </tr>

            </table>

        </form>



        <!-- begin section add papers in subject -->
        <div id="subject-papers">
            <table id="dg-subject-papers"></table>
        </div>
        <!-- end section add papers in subject -->

            
    </div>

    <div id="subject-dlg-btns">
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveSubject()">Save</a>
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onClick="$('#subject-dlg').dialog('close');">Close</a>
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
        <!-- <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onClick="saveSubject()">Save</a> -->
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
                    <td>Mark</td>
                    <td>
                        <input class="easyui-numberbox" data-options="min:0, max:100, precession:2" type="number" id="paper_mark" name="paper_mark" style="width:300px;" required>
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
                    <td>Mark</td>
                    <td>
                        <input class="easyui-numberbox" data-options="min:0, max:100, precession:2" type="number" id="paper_mark_A_level" name="paper_mark_A_level" style="width:300px;" required>
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
    function openAddSubjectDlg ()
    {
        $('#update-subject-form').form('clear');
        $('#subject-dlg').dialog('setTitle', 'Add School').dialog('open');
        setPapersSubject (0);
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

    function saveSubject ()
    {
        $('#update-subject-form').form('submit', {
            url: "update_settings.php?add_o-level_subject",
            onSubmit: function (param) {
                return $(this).form('validate');
            },
            success: function (data) {
                //reload schools grid from here
                $('#subject-dlg').dialog('close');
                $('#subjects-dg').datagrid('reload');
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
            return '<input type="button" value="edit" onClick="openEditALevelStudentDlg()">'
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

    function userActionFormtter (value, row, index)
    {
        if (row.id) {
            return '<input type="button" value="edit" onClick="editSubject('+index+')"> <input type="button" value="delete" onClick="deleteSubject('+row.id+')">';
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

    function deleteSubject (id) 
    {
        id = parseInt(id);
        $.messager.confirm('Confirm', 'Are you sure you want to delete this Subject?', function (r) {
            if (r) {
                $.post('update_settings.php?delete_subject', {id: id}, function (response){
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            $('#subjects-dg').datagrid('reload');
                            showMessager('Info', 'Subject Deleted Successfully');
                        } else {
                            showMessager('Info', response.msg);
                        }
                    } catch (e) {
                        console.log(e);
                    }
                    
                });
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

    function editSubject (index)
    {
        $('#subjects-dg').datagrid('selectRow', index);
        var row = $('#subjects-dg').datagrid('getSelected');
        if (!row) {
            showMessager('Warning', 'Please select a school to edit');
            return;
        }
        
        $('#update-subject-form').form('clear');
        
        $('#subject_id').val(row.id);
        $('#subject_name').val(row.name);
        $('#short_name').val(row.short_name);
        $('#subject_code').val(row.subject_code);
        $('#no_of_papers_done').numberbox('setValue', row.no_of_papers_done);

        if (parseInt(row.is_core)) {
            $('#subject_is_core').prop('checked', true);
        } else {
            $('#subject_is_core').prop('checked', false);
        }

        $('#subject-dlg').dialog('open');

        setPapersSubject (row.id);
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

    function openEditALevelStudentDlg ()
    {
        setTimeout(() => {
            let row = $('#Alevel-students-dg').datagrid('getSelected');
            if (row) {
                $('#A_level_student_id').val(row.id);
                $('#A_level_school_name').combobox("setValue", row.school_id);
                $('#A_level_center_no').val(row.center_no);
                $('#A_level_first_name').val(row.first_name);
                $('#A_level_second_name').val(row.second_name);
                $('#A_level_index_no').val(row.index_no);
                $('#A_level-dlg').dialog('setTitle', 'Edit A-level Student').dialog('open'); 
                //load student results from here
                $('#Alevel-student-subjects-dg').datagrid({
                    url: 'update_school.php?get_student_subject_papers_Alevel&student_id='+ row.id
                });

            } else {
                showMessager('Warning', 'Please Select Student to edit');
            }
              
        }, 500);
        
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
                $('#paper_mark').numberbox('setValue', row.marks);
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

    function setPapersSubject (subject) {
        subject = parseInt(subject);
        if (!subject) return $('#subject-papers').hide();
        $('#subject-papers').show();
        $('#dg-subject-papers').edatagrid({
            url: 'update_settings.php?get_o_level_papers&subject=' + subject,
            saveUrl: 'update_settings.php?save_new_paper&subject=' + subject,
            destroyUrl: 'update_settings.php?delete_paper&subject=' + subject,
            updateUrl: 'update_settings.php?update_paper&subject=' + subject,
        });
    }

</script>


<script>
    $(function () {
        $('#dg-subject-papers').edatagrid({
            url: 'update_settings.php?get_o_level_papers&subject=' + 2,
            saveUrl: 'update_settings.php?save_new_paper&subject=' + 2,
            destroyUrl: 'update_settings.php?delete_paper&subject=' + 2,
            updateUrl: 'update_settings.php?update_paper&subject=' + 2,
        });
        $('#dg-subject-papers').edatagrid({
            title: 'Papers',
            singleSelect: true,
            collapsible: true,
            method: 'get',
            pagination: true,
            fitCoumns: true,
            url: 'update_settings.php?get_o_level_papers&subject=' + 2,
            columns: [[
                {field:'id', width:80, align:'left', title:'Id'},
                {field:'paper_code', width:150, align:'left', title:'Paper Code', editor: {type:'text'}},
                {field:'is_default',  align:'left', width:150, title:'Default', editor:{
                    type: 'combobox',
                    options: {
                        panelHeight: 'auto',
                        editable: false,
                        data: [
                            {
                                value: '1',
                                text: 'Default',
                            },
                            {
                                value: '0',
                                text: 'Not Default',
                                selected: true
                            }
                        ],
                        valueField: 'value',
                        textField: 'text'
                    }
                },
                formatter: function (value, row, index) {
                    console.log(value);
                    if (parseInt(value)) {
                        return 'Default'
                    } else {
                        return 'Not Default';
                    }
                }},
                {field:'paper_name', align:'left', width:150, title:'Paper Name', editor: {type:'text'}},
            ]],
            toolbar: [
                {
                    text: 'Save',
                    iconCls: 'icon-save',
                    handler: function () {
                        $('#dg-subject-papers').edatagrid('saveRow');
                    }
                },
                {
                    text: 'New',
                    iconCls: 'icon-add',
                    handler: function () {
                        $('#dg-subject-papers').edatagrid('addRow', 0);
                    }
                },
                {
                    text: 'Delete',
                    iconCls: 'icon-remove',
                    handler: function () {
                        $('#dg-subject-papers').edatagrid('destroyRow');
                    }
                }
            ]
        });


        $('#update-subject-form, #o_level_student_subject-form, #update-o_level-form, #update-A_level-form ').form({
            url: ""
        });

        $('#user-section-general-search').keyup(function (e) {
            var search = $(this).val();
            $('#subjects-dg').datagrid({
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

            $('#o_level_school_name').combobox({
                data: data,
                width: 300,
                panelHeight: 100,
                valueField: "id",
                textField: "name",
                editable: false,
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
                editable: false,
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
                editable: false,
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
                editable: false,
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
                editable: false,
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
                editable: false,
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
                editable: false,
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
            editable: false,
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
            editable: false,
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
            editable: false,
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