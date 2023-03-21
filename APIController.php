<?php
    function index($paginate = null, $rocket_name = null) {
        $result = json_decode(getLatestLaunches(), true);
        
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

        // check flight status
        if ($status) {
            $status = "<p id='rocket-status-data' class='subtitle-status mb-0'>Success</p>";
        } else if (!$status) {
            if (!$result['upcoming']) {
                $status = "<p id='rocket-status-data' class='subtitle-status-failed mb-0'>Failed</p>";
            } else {
                $status = "<p id='rocket-status-data' class='subtitle-status mb-0'>Upcoming</p>";
            }
        }

        // count reused cores
        foreach ($result['cores'] as $cores) {
            if($cores['reused'] == true) {
                $cores_reused++;
            }
        }

        // check descriptions
        if (!$description) {
            $description = 'No descriptions';
        }

        echo "
            <div class='row m-4'>
            <div class='col align-self-center'>
                <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'>
                    <div class='carousel-inner'>
                        <div class='carousel-item active'>
                            <img src='images/dafault-image-2.png' class='d-block w-100'>
                        </div>
                        <div class='carousel-item'>
                            <img src='images/default-image-1.png' class='d-block w-100'>
                        </div>
                    </div>
                    <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'>
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
                <p id='weather-forecast'><i class='fa-solid fa-cloud me-2'></i><span style='font-weight: 500;'>Weather Forecast : </span>{$weather_data}</p>
                <p id='weather-description'></p>
            </div>
        </div>
        ";
    }

    function viewData($status, $paginate = null, $rocket_name = null) {
        $data = json_decode(getLatestLaunches(), true);
        $count = 0;
        
        foreach ($data as $result) {
            if ($paginate != null && $count < $paginate) {
                $count ++;
            } else if ($paginate != null && $count == $paginate) {
                break;
            }

            if ($rocket_name != null && $rocket_name != $result['name']) {
                continue;
            } else if ($rocket_name != null && $rocket_name == $result['name']) {
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

                if ($status) {
                    $status = "<p id='rocket-status-data' class='subtitle-status mb-0'>Success</p>";
                } else {
                    $status = "<p id='rocket-status-data' class='subtitle-status-failed mb-0'>Failed</p>";
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
                        <div id='carouselExampleFade' class='carousel slide carousel-fade' data-bs-ride='carousel'>
                            <div class='carousel-inner'>
                                <div class='carousel-item active'>
                                    <img src='images/dafault-image-2.png' class='d-block w-100'>
                                </div>
                                <div class='carousel-item'>
                                    <img src='images/default-image-1.png' class='d-block w-100'>
                                </div>
                            </div>
                            <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleFade' data-bs-slide='prev'>
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
                        <p id='weather-forecast'><i class='fa-solid fa-cloud me-2'></i><span style='font-weight: 500;'>Weather Forecast : </span>{$weather_data}</p>
                        
                    </div>
                </div>
                ";
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