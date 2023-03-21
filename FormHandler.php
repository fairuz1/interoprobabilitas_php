<?php
    session_start(); 
    $display_option = intval($_POST["display-option"]);
    $sort           = $_POST["sort-option"];
    $paginate       = $_POST["paginate"];
    $end_date       = $_POST["date-end"];
    $start_date     = $_POST["date-start"];

    if (empty($_POST["rocket-name"])) {
        $rocket_name = '';
    } else {
        $rocket_name = $_POST["rocket-name"];
    }

    $_SESSION["display_option"] = $display_option;
    $_SESSION["sort"]           = $sort;
    $_SESSION["paginate"]       = $paginate;
    $_SESSION["status"]         = 'request';
    $_SESSION["end_date"]       = $end_date;
    $_SESSION["start_date"]     = $start_date;

    header('Location: dashboard.php');
?>