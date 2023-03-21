<?php
    function index($paginate = null) {
        $result = json_decode(getLatestLaunches(), true);
        htmlDataGenerator2($result);
    }

    function viewData($display_option, $paginate = null, $end_date = null, $start_date = null) {
        if ($display_option == 0) {
            $data = json_decode(getAllLaunches(), true);
            htmlDataGenerator1($data, $paginate, $end_date = null, $start_date = null);
        } else if ($display_option == 1) {
            $data = json_decode(getNextLaunches(), true);
            htmlDataGenerator2($data);
        } else if ($display_option == 2) {
            $data = json_decode(getLatestLaunches(), true);
            htmlDataGenerator2($data);
        } else if ($display_option == 3) {
            $data = json_decode(getPastLaunches(), true);
            htmlDataGenerator1($data, $paginate, $end_date = null, $start_date = null);
        } 
    }

    function htmlDataGenerator2($result) {
        $name = $result['name'];
        $status = $result['success'];
        $dateAndLocation = $result['date_local'] . ', Kennedy Space Center, California, USA';
        $filght_number = $result['flight_number'];
        $new_cores = count($result['cores']);
        $cores_reused = 0;
        $description = $result['details'];
        $weather = getWeather('Lompoc', 'us', $result['date_unix'], $result['date_unix']);
        $weather_data = $weather['weather'][0]['description'];
        $youtube_id = 'https://www.youtube.com/embed/' . $result['links']['youtube_id'] . '?mute=1';

        if ($status == null && $result['upcoming'] == true) {
            $status = "<p id='rocket-status-data' class='subtitle-status mb-0'>Upcoming</p>";
            $weather_description = "<span id='weather-description' style='color:var(--blue-primary)'>The forcasted weather in the city of Lomboc, California are expected to be <b>{$weather_data}</b>.</span>";
        } else {
            if ($status) {
                $status = "<p id='rocket-status-data' class='subtitle-status-success mb-0'>Success</p>";
                $weather_description = "<span id='weather-description' style='color:var(--green-primary)'>The weather in the city of Lomboc, California was <b>{$weather_data}</b> and it does not seems to be causing any problems to the rocket's flight.</span>";
            } else {
                $status = "<p id='rocket-status-data' class='subtitle-status-failed mb-0'>Failed</p>";
                $weather_description = "<span id='weather-description' style='color:var(--red-primary)'>The weather condition was <b>{$weather_data}</b> and the lunch was unsuccessful, although this may need more scientific data, the weather might be one of the reason of unsuccessful launch.</span>";
            }
        }
        
        foreach ($result['cores'] as $cores) {
            if($cores['reused'] == true) {
                $cores_reused++;
            }
        }

        if (!$description) {
            $description = 'No descriptions';
        }

        echo "
            <div class='row m-4'>
            <div class='col align-self-center'>
                <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'>";
                if (count($result['links']['flickr']['original']) != 0 ) {
                    echo "<div class='carousel-inner'>";
                    foreach ($result['links']['flickr']['original'] as $link) {
                        echo "                            
                            <div class='carousel-item active'>
                                <img src='{$link}' class='d-block w-100'>
                            </div>
                        ";
                    }
                    echo "</div>";
                } else {
                    echo "
                        <div class='carousel-inner'>
                            <div class='carousel-item active'>
                                <img src='images/default-image-4.jpg' class='d-block w-100'>
                            </div>
                        </div>
                    ";
                }
        echo "      <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'>
                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Previous</span>
                    </button>
                    <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='next'>
                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                        <span class='visually-hidden'>Next</span>
                    </button>
                </div>
            </div>
    
            <div class='col align-self-center ms-2'>
                <iframe width='400' height='200' src='{$youtube_id}'></iframe>
                <p id='rocket-name-data' class='title-name mb-0'>{$name}</p>
                {$status}
                <p id='rocket-launch-place-data'>{$dateAndLocation}</p>
                
                <div class='row'>
                    <p id='flight-number-data' class='col-auto'><span style='font-weight: 500;'>flight number : </span>{$filght_number}</p>
                    <p id='cores-data' class='col-auto'><span style='font-weight: 500;'>cores : </span>{$new_cores}</p>
                    <p id='cores-reused' class='col-auto'><span style='font-weight: 500;'>cores reused : </span>{$cores_reused}</p>
                </div>
    
                <p id='flight-description'>{$description}</p>
                <p id='weather-forecast' class='mb-0'><i class='fa-solid fa-cloud me-2'></i><span style='font-weight: 500;'>Weather Forecast : </span>{$weather_data}</p>
                {$weather_description}
            </div>
        </div>
        ";
    }

    function checkLaunchDate($end_date, $start_date, $date) {
        if ($end_date != null && $start_date != null) {
            $date = $result['date_local'];

            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            $temp = $day . '-' . $month . '-' . $year;
            $launchDate = date_create_from_format("m-d-Y", $temp)->format("Y-m-d");
            $encd_start_date = date_create_from_format("Y-m-d", $start_date);
            $encd_end_date = date_create_from_format("Y-m-d", $end_date);

            if ($launchDate >= $encd_start_date && $launchDate <= $encd_end_date) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function htmlDataGenerator1($data, $paginate, $end_date, $start_date) {
        $count = 0;
        foreach ($data as $result) {
            if ($count < intval($paginate)) {
                if (!checkLaunchDate($end_date, $start_date, $result['date_local'])) {
                    // echo 'look at me!';
                    continue;
                } else {
                    echo 'end date value : ' . $end_date;
                    $name = $result['name'];
                    $status = $result['success'];
                    $dateAndLocation = $result['date_local'] . ', Kennedy Space Center, California, USA';
                    $filght_number = $result['flight_number'];
                    $new_cores = count($result['cores']);
                    $cores_reused = 0;
                    $description = $result['details'];
                    $weather = getWeather('Lompoc', 'us', $result['date_unix'], $result['date_unix']);
                    $weather_data = $weather['weather'][0]['description'];
                    $youtube_id = 'https://www.youtube.com/embed/' . $result['links']['youtube_id'] . '?mute=1';
    
                    if ($status == null && $result['upcoming'] == true) {
                        $status = "<p id='rocket-status-data' class='subtitle-status mb-0'>Upcoming</p>";
                        $weather_description = "<span id='weather-description' style='color:var(--blue-primary)'>The forcasted weather in the city of Lomboc, California are expected to be <b>{$weather_data}</b>.</span>";
                    } else {
                        if ($status) {
                            $status = "<p id='rocket-status-data' class='subtitle-status-success mb-0'>Success</p>";
                            $weather_description = "<span id='weather-description' style='color:var(--green-primary)'>The weather in the city of Lomboc, California was <b>{$weather_data}</b> and it does not seems to be causing any problems to the rocket's flight.</span>";
                        } else {
                            $status = "<p id='rocket-status-data' class='subtitle-status-failed mb-0'>Failed</p>";
                            $weather_description = "<span id='weather-description' style='color:var(--red-primary)'>The weather condition was <b>{$weather_data}</b> and the lunch was unsuccessful, although this may need more scientific data, the weather might be one of the reason of unsuccessful launch.</span>";
    
                        }
                    }
            
                    foreach ($result['cores'] as $cores) {
                        if($cores['reused'] == true) {
                            $cores_reused++;
                        }
                    }
    
                    if (!$description) {
                        $description = 'No descriptions';
                    }
    
                    echo "
                        <div class='row m-4'>
                        <div class='col align-self-center'>
                            <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'>";
                            if (count($result['links']['flickr']['original']) != 0 ) {
                                echo "<div class='carousel-inner'>";
                                foreach ($result['links']['flickr']['original'] as $link) {
                                    echo "                            
                                        <div class='carousel-item active'>
                                            <img src='{$link}' class='d-block w-100'>
                                        </div>
                                    ";
                                }
                                echo "</div>";
                            } else {
                                echo "
                                    <div class='carousel-inner'>
                                        <div class='carousel-item active'>
                                            <img src='images/default-image-4.jpg' class='d-block w-100'>
                                        </div>
                                    </div>
                                ";
                            }
                    echo "      <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'>
                                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Previous</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='next'>
                                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                    <span class='visually-hidden'>Next</span>
                                </button>
                            </div>
                        </div>
                
                        <div class='col align-self-center ms-2'>
                            <iframe width='400' height='200' src='{$youtube_id}'></iframe>
                            <p id='rocket-name-data' class='title-name mb-0'>{$name}</p>
                            {$status}
                            <p id='rocket-launch-place-data'>{$dateAndLocation}</p>
                            
                            <div class='row'>
                                <p id='flight-number-data' class='col-auto'><span style='font-weight: 500;'>flight number : </span>{$filght_number}</p>
                                <p id='cores-data' class='col-auto'><span style='font-weight: 500;'>cores : </span>{$new_cores}</p>
                                <p id='cores-reused' class='col-auto'><span style='font-weight: 500;'>cores reused : </span>{$cores_reused}</p>
                            </div>
                
                            <p id='flight-description'>{$description}</p>
                            <p id='weather-forecast' class='mb-0'><i class='fa-solid fa-cloud me-2'></i><span style='font-weight: 500;'>Weather Forecast : </span>{$weather_data}</p>
                            {$weather_description}
                        </div>
                    </div>
                    ";
    
                    $count ++;
                }
            }
        }
    }

    function getBaseUrl($name) {
        if ($name == 'rspaceX') {
            return "https://api.spacexdata.com/v5";
        } else if ($name == 'open_weather') {
            return "https://api.openweathermap.org/data/2.5/weather";
        } else if ($name == 'geocoding') {
            return "http://api.openweathermap.org/geo/1.0/direct?";
        }
    }

    function getCarouselImages() {
        
    }

    function getAllLaunches() {
        $base_url = getBaseUrl('rspaceX');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . '/launches',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return $response;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getLatestLaunches() {
        $base_url = getBaseUrl('rspaceX');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . '/launches/latest',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return $response;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getNextLaunches() {
        $base_url = getBaseUrl('rspaceX');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . '/launches/next',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return $response;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getPastLaunches() {
        $base_url = getBaseUrl('rspaceX');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . '/launches/past',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return $response;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getWeatherData($startDate, $endDate) {
        $base_url = getBaseUrl('open_wather');
        $location_data = getMathematicalLocation('California', 'USA');
        $string_data = 'city?lat= ' . $location_data['latitude'] . '&lon=' . $location_data['longitude'] . '&type=hour&start={start}&end={end}&appid={API key}';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . $string_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return $response;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getMathematicalLocation($city_name, $country_code, $startDate, $endDate, $limit = null) {
        $base_url = getBaseUrl('geocoding');
        $appid = '19f31f6fbf4ba489ee3f4930f4cc03bd';
        $string_data = 'q=' . $city_name . ',' . $country_code . '&type=hour&start=' . $startDate . '&end=' . $endDate . '&appid=' . $appid . '';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . $string_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            $decoded_response = json_decode($response, true);
            return $base_url . $string_data;
        } else {
            return "Something is wrong with the request..";
        }
    }

    function getWeather($city_name, $country_code, $startDate, $endDate, $limit = null) {
        $base_url = getBaseUrl('open_weather');
        $appid = '19f31f6fbf4ba489ee3f4930f4cc03bd';
        $string_data = '?q=' . $city_name . ',' . $country_code . '&type=hour&start=' . $startDate . '&end=' . $endDate . '&appid=' . $appid;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url . $string_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            $decoded_response = json_decode($response, true);
            // $lat = strval($decoded_response[0]['weather']['description']);
            // $lon = strval($decoded_response[0]['lon']);
            // $detailedLocation = array('weather' => $lat, 'longitude' => $lon);

            return $decoded_response;
        } else {
            return "Something is wrong with the request..";
        }
    }
?>