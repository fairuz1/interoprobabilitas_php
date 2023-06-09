<?php
    session_start(); 
    include 'APIController.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard : Welcome!!</title>

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e725ea6c67.js" crossorigin="anonymous"></script>

    <!-- jquery ui -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        :root {
            --yellow-primary: #FFB100;
            --black-primary: #1E1E1E;
            --gray-placeholder: #BABABA;
            --blue-primary: #004B85;
            --green-primary: #008574;
            --red-primary: #F04465;
            --white-secondary: #F2F2F2;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        .row-header {
            background: url(images/ilustrasi-header.png);
            min-height: 100vw;
            min-height: 20vh;
            overflow: hidden;
        }

        .btn-custom {
            background: transparent;
            border: 1px solid var(--black-primary);
            border-radius: 20px;
            color: var(--black-primary);
        }

        .rocket-images {
            object-fit: contain;
            max-width: 100%;
            max-height: 80% !important;
            width: auto;
            height: auto;
        }

        .heading {
            font-style: normal;
            font-weight: 600;
            font-size: 36px;
        }

        .sub-heading {
            font-style: normal;
            font-weight: 300;
            font-size: 24px;
        }

        .slct-custom, .form-control {
            box-sizing: border-box;
            border: 1px solid var(--black-primary);
            border-radius: 10px;
            max-width: 30vw;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-warning {
            background-color: var(--yellow-primary);
            font-style: normal;
            font-weight: 500;
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background-color: transparent;
            border: 2px solid var(--yellow-primary);
            border-radius: 10px;
            color: var(--yellow-primary);

            font-style: normal;
            font-size: 1rem;
            font-weight: 500;
        }

        .title-name {
            font-style: normal;
            font-weight: 700;
            font-size: 3rem;
            color: var(--yellow-primary);
        }

        .title-name1 {
            font-style: normal;
            font-weight: 700;
            font-size: 4rem;
            color: var(--yellow-primary);
        }

        .subtitle-status {
            font-style: normal;
            font-weight: 500;
            font-size: 2rem;
            color: var(--blue-primary);
        }

        .subtitle-status-success {
            font-style: normal;
            font-weight: 500;
            font-size: 2rem;
            color: var(--green-primary);
        }

        .subtitle-status-failed {
            font-style: normal;
            font-weight: 500;
            font-size: 2rem;
            color: var(--red-primary);
        }

        .carousel-item {
            transition: height 2s;
        }

        .header {
            background-color: var(--white-secondary);
        }

        select {
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
        }

        input {
            box-shadow: none !important;
            border: none !important;
            outline: none !important;
        }

        select:focus {
            box-shadow: none !important;
            border: none !important;
        }

        form-control:focus {
            box-shadow: none !important;
            border: none !important;
        }

        ::placeholder { 
            color: var(--gray-placeholder);
            opacity: 1;
        }

        :-ms-input-placeholder { 
            color: var(--gray-placeholder);
        }

        ::-ms-input-placeholder {
            color: var(--gray-placeholder);
        }

    </style>

</head>
<body>
    <!-- header -->
    <div class="header">
        <div class="row row-header"></div>
        <div class="row text-center">
            <p class="heading mb-0"><span style="color: var(--yellow-primary);">SpaceX’s Rocket</span> Launch Data</p>
            <p class="sub-heading">Find all available SpaceX’s rockets launch date and their coresponding data</p>
        </div>
    
        <!-- filter form -->
        <div class="row">
            <form id='filterForm' action="FormHandler.php" method="post">
                <div class="row justify-content-center mb-3">
                    <div class="col-3">
                        <label for="display-option" class="form-label">Display Option</label>
                        <div class="slct-custom form-control py-3">
                            <i class="fa-solid fa-rocket ms-3"></i>
                            <select name="display-option" id="display-option" onchange="checkDisplayOption()">
                                <option value="0">Display All SpaceX Launch Data</option>
                                <option value="1">Display Next Rocket Launch</option>
                                <option value="2">Display Latest Rocket Launch</option>
                                <option value="3">Display Past Rocket Launch</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="col-3" hidden>
                        <label for="rocket-name" class="form-label">Rocket Name</label>
                        <div class="slct-custom form-control py-3">
                            <i class="fa-solid fa-magnifying-glass ms-3"></i>
                            <input type="text" name="rocket-name" id="rocket-name" class="ms-2" placeholder="CSR-20">
                        </div>
                    </div>

                    <div class="col-auto">
                        <label for="date-start" class="form-label">Date Start</label>
                        <div class="slct-custom form-control py-3">
                            <i class="far fa-calendar-alt ms-3"></i>
                            <input type="text" name="date-start" id="date-start" class="ms-2" placeholder="specify start date" onchange="checkDate()">
                        </div>
                    </div>

                    <div class="col-auto">
                        <label for="date-end" class="form-label">Date End</label>
                        <div class="slct-custom form-control py-3">
                            <i class="far fa-calendar-alt ms-3"></i>
                            <input type="text" name="date-end" id="date-end" class="ms-2" placeholder="specify end date" onchange="checkDate()">
                        </div>
                        <div id="date-warning" class="form-text">Please make sure the end date are after the start date.</div>
                    </div>

                    <div class="col-3" hidden>
                        <label for="paginate" class="form-label">Paginate</label>
                        <div class="slct-custom form-control py-3">
                            <i class="fa-solid fa-magnifying-glass ms-3"></i>
                            <input type="text" name="paginate" id="paginate" class="ms-2">
                        </div>
                    </div>

                    <div class="col-3" hidden>
                        <label for="sort-option" class="form-label">Sort</label>
                        <div class="slct-custom form-control py-3">
                            <i class="fa-solid fa-magnifying-glass ms-3"></i>
                            <input type="text" name="sort-option" id="sort-option" class="ms-2">
                        </div>
                    </div>
        
                    <div class="col-3">
                        <label class="form-label" style="color: transparent;">filler</label>
                        <button id="submit-button" type="button" class="slct-custom form-control btn btn-warning py-3" onclick="sendData()"><i class="fa-regular fa-paper-plane me-2"></i>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mx-4 mt-2">
        <p id="result" class="title-name1 m-0">Result</p>
        <div class="col-auto">
            <span>Sort by : </span>
            <select name="sort-data" id="sort-data" style="font-weight: 500;">
                <option value="asc">earliest</option>
                <!-- <option value="1">latest</option> -->
            </select>
        </div>
        <div class="col-auto">
            <span>Paginate : </span>
            <select name="paginate-data" id="paginate-data" style="font-weight: 500;">
                <option value="10">10 data</option>
                <option value="20">20 data</option>
            </select>
        </div>
    </div>

    <!-- main content -->
    <?php
        if (isset($_SESSION["status"])) {
            if ($_SESSION["status"] == 'home') {
                index(); 
            } else if ($_SESSION["status"] == 'request') {
                viewData($_SESSION["display_option"], $_SESSION["paginate"], $_SESSION["end_date"], $_SESSION["start_date"]);
                $_SESSION["status"] = 'home';
            }
        } else {
            $_SESSION["status"] = 'home';
            index(); 
        }

        echo $_SESSION["end_date"];
    ?>

    <!-- footer -->
    <div class="row">

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        index();
        $( "#date-start" ).datepicker({ altFormat: "yy-mm-dd" });
        $( "#date-end" ).datepicker({ altFormat: "yy-mm-dd" });

        var dateFormat = $( "#date-start" ).datepicker( "option", "dateFormat" );
        $( "#date-start" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        var dateFormat = $( "#date-end" ).datepicker( "option", "dateFormat" );
        $( "#date-end" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

        function sendData() {
            document.getElementById('paginate').value = document.getElementById('paginate-data').value;
            document.getElementById('sort-option').value = document.getElementById('sort-data').value;
            console.log(document.getElementById('paginate-data').value);
            console.log(document.getElementById('sort-data').value);
            document.getElementById('filterForm').submit();
        }

        function index() {
            var current_display_option = <?php echo strval($_SESSION["display_option"]); ?>;
            var current_paginate_option = <?php echo strval($_SESSION["paginate"]); ?>;
            var display_option = document.getElementById('display-option');
            var paginate_option = document.getElementById('paginate-data');

            display_option.selectedIndex = `${current_display_option}`;
            paginate_option.value = `${current_paginate_option}`;
        }

        function checkDate() {
            var start_date = $( "#date-start" ).datepicker('getDate');
            var end_date = $( "#date-end" ).datepicker('getDate');
            var submit_button = document.getElementById('submit-button');

            if (start_date > end_date) {
                submit_button.disabled = true;
            } else {
                submit_button.disabled = false;
            }
        }

        function checkDisplayOption() {
            var start_date = document.getElementById('date-start');
            var end_date = document.getElementById('date-end');
            var display_option = document.getElementById('display-option');

            if (display_option.value == 1 || display_option.value == 2) {
                start_date.disabled = true;
                end_date.disabled = true;

                start_date.placeholder = 'disabled';
                end_date.placeholder = 'disabled';
            } else {
                start_date.disabled = false;
                end_date.disabled = false;

                start_date.placeholder = 'specify start date';
                end_date.placeholder = 'specify end date';
            }
        }
    </script>
</body>
</html>