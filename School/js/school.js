


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


function getSchools() {
    $.getJSON('update_school.php', { get_all_schools: '' }, function (schools) {

        let action_buttons = "";


        //GENERATE DATA INTO THE TABLE

        let schools_list = "";

        $.each(schools, function (index, school) {
            schools_list += "<tr>"
                + "<td >" + school.id + "</td>"
                + "<td >" + school.name + "</td>"
                + "<td >" + school.center_no + "</td>"
                + "<td >" + school.district + "</td>"
                + "<td >" + school.no_of_students + "</td>"
                + "<td ></td>"
            "</tr>"
        });

        $('#schools-list').html(schools_list);


    });
}



$(function () {
    getSchools();
})