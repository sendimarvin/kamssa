



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

    #menu-btn {
        background-color: #286e88; /* Green */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
    }

    #menu-tems-section {
        display: none;
    }

    [menu-section2] {
        background-color: #e7e7e7;
    }

    .menu-items > li{
        text-decoration: none;
        list-style: none;
    }

    .menu-items > li > a {
        text-decoration: none;
    }

    .menu-items > li > a:hover {
        text-decoration: none;
        cursor: pointer;
        color: #ABC;
    }

    #menu-tems-section td li {
        font-size: 16px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        /* background-color: #ccc; */
        /* border: 1px solid #222; */
        text-align: center;
    }

</style>


<div id="menu-tems-section">
    <table>
        <tr>
            <td>
                <ul class="menu-items">
                    <li><a href="settings.php">Users Management</a></li>
                    <li><a href="combinations.php">Combinations</a></li>
                </ul>
            </td>
            <td>
                <ul class="menu-items">
                    <li><a href="o_level_subject_setup.php">O level subjects setup</a></li>
                    <li><a href="a_level_subject_setup.php">A level subjects setup</a></li>
                </ul>
            </td>
        </tr>
    </table>
</div>