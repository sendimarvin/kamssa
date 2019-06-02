

<?php 
    require '../Includes/header.php';
?>


<body>





<div class = "row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
    <?php 
        require '../Includes/navbar.php';
    ?>
    </div>
    <div class="col-md-1"></div>
</div>


<div class = "row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        


        <div class="card" >
        <div class="card-body">
            <h5 class="card-title text-center">School Profile</h5>
            <!-- <h6 class="card-subtitle mb-2 text-muted text-center">Add new school to system</h6> -->
            
            <div class = "row">
                <button class="btn btn-primary" onClick="addSchool()">Add</button>
            </div>


            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" id="school-form-title">Add School</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        
                            <form action="update_school.php" method="POST" id="school-form" onSubmit="validateSChoolData()" validate>

                                <input type="hidden" name="school_id" id="school_id" value="0">

                                <div class="form-group row" style="margin:0px" >
                                    <label for="school_name" class="col-sm-3 col-form-label">School Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" name="school_name" id="school_name" required>
                                    </div>
                                </div>


                                <div class="form-group row" style="margin:0px">
                                    <label for="center_no" class="col-sm-3 col-form-label">Center No:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control form-control-sm" name="center_no" id="center_no" required>
                                    </div>
                                    
                                </div>

                                <div class="form-group row" style="margin:0px" >
                                    <label for="number_of_students" class="col-sm-3 col-form-label">Number of students:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control form-control-sm" id="number_of_students" name="number_of_students" required>
                                    </div>
                                </div>

                                <div class="form-group row " style="margin:0px">
                                    <label for="district" class="col-sm-3 col-form-label">District:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="district" id="district" required>
                                    </div>
                                </div>
                                


                            </form>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary" onClick="submitSChoolForm()">Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Confirmation Modal -->
            <div class="modal" id="confirmation-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="delete_id">
                            <span>Are you sure you want to delete this school?</span>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-danger" onClick="confirmSchoolDeletion()">Delete</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group row" style="margin:10px">
                <label class="col-form-label" for="inputState">Show</label>
                <div class="col-sm-1">
                    <select id="inputState" onChange="setRecordsToDisplay(this)" class="form-control form-control-sm">
                        <option value="5" selected>5</option>
                        <option value="10" >10</option>
                        <option value="25" >25</option>
                        <option value="50" >50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <span class="col-form-label" >entries</span>
            
                
                <div class="col-sm-5">
                    <input class="form-control"  class="form-control form-control-sm" type="text" onKeyUp="searchInput(this)" placeholder="Search..." name ="school-search">
                </div>
                
            </div>

            <!-- begin list all added schools in the system -->
            <div>
                <table  id="dtBasicExample" class="table table-striped table-bordered table-sm table-hover" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th class="th-sm">No</th>
                            <th class="th-sm">School Name</th>
                            <th class="th-sm">Center No</th>
                            <th class="th-sm">District</th>
                            <th class="th-sm">No of Students</th>
                            <th class="th-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody id = "schools-list">
                        <!-- <tr>
                            <td >No</td>
                            <td >School Name</td>
                            <td >Center No</td>
                            <td >District</td>
                            <td >No of Students</td>
                            <td >Action</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <!-- end list all added schools in the system -->

            <div class="row">

                
                <div class="col-sm-4 text-center">
                    <span >showing 1 of <span id="max-pages">10</span> of <span id="max-entries">57</span></span>
                </div>

                <div class="col-sm-5 text-center" >
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0)" onClick="goToPage('Previous')" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onClick="setPage($(this).text())">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onClick="setPage($(this).text())">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0)" onClick="setPage($(this).text())">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" onClick="goToPage('Next')">Next</a>
                            </li>
                        </ul>
                    </nav>                
                </div>

            </div>

            



        </div>
        </div>




    </div>
    <div class="col-md-1"></div>
</div>

<script src="js/school.js"></script>
</body>
</html>