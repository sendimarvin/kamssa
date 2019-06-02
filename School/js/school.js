// this will hold the school display info
var SCHOOL_DATA = {
    get_all_schools: "",
    rows : 5,
    search : "",
    page : 1
}


//min and max page
var MAX_PAGE = MIN_PAGE = 1;



function submitSChoolForm () {

    if (validateSChoolData()) {
        $('#school-form').submit();
    }
    
}

function validateSChoolData() {

    let school_name = $('#school_name').val();
    let center_no = $('#center_no').val();
    let number_of_students = $('#number_of_students').val();
    let district = $('#district').val();

    school_name = school_name.trim();
    center_no = center_no.trim();
    number_of_students = parseInt(number_of_students);
    district = district.trim();

    if (!school_name) {
        alert("Invalid School Name");
        return false;
    }

    if (!center_no) {
        alert("Invalid Center No.");
        return false;
    }

    if (!number_of_students) {
        alert("Please enter number of students");
        return false;
    }

    if (!district) {
        alert("Please a valid district");
        return false;
    }

    return true;

}


function confirmSchoolDeletion () 
{
    let id = $('#delete_id').val();
    $.post('update_school.php?delete_school', {id: id}, function (response){
        if (response.success) {
            $('#confirmation-modal').modal('hide');
            //reload schools from here
            getSchools();
        }
    }, 'JSON');
}

function deleteSchool (id) 
{
    $('#delete_id').val(id);
    //open confirmation dlg
    $('#confirmation-modal').modal('show');
}


function editSchool (school) 
{
    $('#school-form-title').text("Edit School");
    //set edit content
    $('#school_id').val(school.id);
    $('#school_name').val(school.name);
    $('#center_no').val(school.center_no);
    $('#district').val(school.district);
    $('#number_of_students').val(school.no_of_students);


    $('#myModal').modal('show');
    console.log(school);
}

function addSchool () 
{
    $('#school-form-title').text("Add School");
    $('#school_id').val("0");
    $('#school_name').val("");
    $('#center_no').val("");
    $('#district').val("");
    $('#number_of_students').val("");
    $('#myModal').modal('show');
}


function getSchools() 
{
    $.getJSON('update_school.php', SCHOOL_DATA, function (result) {

        setminMaxParameters (result.totals);


        //GENERATE DATA INTO THE TABLE
        let schools_list = "";
        schools = result.rows
        $.each(schools, function (index, school) {
            schools_list += "<tr>"
                + "<td >" + school.id + "</td>"
                + "<td >" + school.name + "</td>"
                + "<td >" + school.center_no + "</td>"
                + "<td >" + school.district + "</td>"
                + "<td >" + school.no_of_students + "</td>"
                + "<td ><button class='btn btn-primary' onClick='editSchool(" + JSON.stringify(school) + ")'>Edit</button> <button class='btn btn-danger' onClick='deleteSchool(" + school.id + ")'>Delete</button></td>"
            "</tr>"
        });
        $('#schools-list').html(schools_list);
    });
}

function searchInput (element)
{
    SCHOOL_DATA.search =   $(element).val();
    getSchools();
}

function setRecordsToDisplay (element)
{
    SCHOOL_DATA.rows =   $(element).val();
    getSchools();
}

function setPage(page_no)
{
    SCHOOL_DATA.page = page_no;
    getSchools();   
}

function goToPage (caller)
{   
    console.log(caller);
    if (caller == 'Previous') {
        //index cannot go below 0
        if (SCHOOL_DATA.page  <= 0) { //reset page to 1
            setPage(1);
        } else { //decrement page
            setPage((SCHOOL_DATA.page - 1));
        }
    } else if (caller == 'Next') {
        //index cannot go below 0
        if (SCHOOL_DATA.page  >= MAX_PAGE) { //reset page to 1
            setPage(MAX_PAGE);
        } else { //decrement page
            setPage((SCHOOL_DATA.page + 1));
        }
    } else {
        //leave page
    }
}


function setminMaxParameters (totals)
{
    try {
        //set entries from here
        MAX_PAGE = Math.ceil( totals / SCHOOL_DATA.rows   );

        $('#max-entries').text(totals);
        $('#max-pages').text(MAX_PAGE);
    } catch (e) {
        alert ('Error calculating remaining schools');
    }
}



$(function () {
    getSchools();
});


