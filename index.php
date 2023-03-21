<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interoprobability Task : Geting data from APIs</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e725ea6c67.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --danger-pink: #F04465;
            --yellow-primary: #FFB100;
            --black-primary: #1E1E1E;
        }

        *{
            font-family: 'Inter', sans-serif;
        }

        .video-background {
            width: 100vw;
            height: 100vh;
        }

        .blur {
            background: linear-gradient(180deg, rgba(226, 226, 226, 0.15) 0%, rgba(255, 255, 255, 0.15) 100%);
            box-shadow: 0px 4px 20px -1px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(25px);
            border-radius: 10px;
        }

        .btn-warning {
            background-color: var(--yellow-primary);
            color: white;
            font-size: 1rem;
            border: none;
        }

        .btn-warning:hover {
            background-color: transparent;
            border: 2px solid var(--yellow-primary);
            border-radius: 10px;
            color: var(--yellow-primary);
        }

        .card {
            width: 30rem;
            border: none;
        }

        .card-text {
            color: white;
        }

        .title {
            font-size: 2rem;
            color: var(--yellow-primary);
        }

        video {
            object-fit: fill;
        }

        .video {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.5);
        }

        .video-background {
            position: absolute;
            min-width: 100%;
            min-width: 100%;
            z-index: -1;
        }

    </style>
    
</head>
<body>

    <!-- video background -->
    <div class="video">
        <video class="video-background" autoplay muted loop>
            <source src="launch.mp4" type="video/mp4">
        </video>
        <div class="card blur mx-auto p-4">
            <div class="card-body text-center">
                <div class="card-title">
                    <i class="fas fa-exclamation-triangle fa-2x me-2" style="color: var(--yellow-primary);"></i>
                    <span class="title"><b>Disclaimer</b></span>
                </div>
                
                <p class="card-text">
                    This is a student projects and we have no relation with spaceX in any form. 
                    All of the data were obtained using free opensource APIs 
                </p>
                <a href="dashboard.php" class="btn btn-warning text-center align-center px-2 ps-4 pe-4">Okay, Lets see some rocket launches data !</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>