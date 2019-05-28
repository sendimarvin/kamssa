

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
            <h6 class="card-subtitle mb-2 text-muted text-center">Add new school to system</h6>
            
            <div class="card-text">
                <form action="update_school.php" method="POST" onSubmit="validateSChoolData()">


                    <div class="form-group row">
                        <label for="school_name" class="col-sm-2 col-form-label">School Name:</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control form-control-sm" name="school_name" id="school_name" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="center_no" class="col-sm-2 col-form-label">Center No:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" name="center_no" id="center_no" required>
                        </div>
                        
                    </div>

                    <div class="form-group row" >
                        <label for="number_of_students" class="col-sm-2 col-form-label">Number of students:</label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control form-control-sm" name="number_of_students" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="district" class="col-sm-2 col-form-label">District:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" name="district" id="district" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-4">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>


                </form>
            
            </div>


            <!-- begin list all added schools in the system -->
            <div>
                <table class="table table-condensed table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">School Name</th>
                            <th scope="col">Center No</th>
                            <th scope="col">District</th>
                            <th scope="col">No of Students</th>
                            <th scope="col">Action</th>
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

        </div>
        </div>




    </div>
    <div class="col-md-1"></div>
</div>

<script src="js/school.js"></script>
</body>
</html>