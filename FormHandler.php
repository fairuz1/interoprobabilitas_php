<?php
    $display_option = intval($_POST["display-option"]);
    $sort           = $_POST["sort-option"];
    $paginate       = $_POST["paginate"];

    if (empty($_POST["rocket-name"])) {
        $rocket_name = '';
    } else {
        $rocket_name = $_POST["rocket-name"];
    }

    $_SESSION["display_option"] = $display_option;
    $_SESSION["sort"] = $sort;
    $_SESSION["paginate"] = $paginate;
    $_SESSION["status"] = 'request';
    $_SESSION["rocket_name"] = $rocket_name;

    header('Location: dashboard.php');
?>