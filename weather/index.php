<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mmarcus
 * Date: 8/5/13
 * Time: 11:14 PM
 * To change this template use File | Settings | File Templates.
 */
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $headers = apache_request_headers();

    if(strstr($headers['Accept'], 'text/html')){
        require ('base_markup.phtml');
    } else if (strstr($headers['Accept'], 'application/json')){
        require_once(__DIR__ . '/lib/meekrodb.2.2.class.php');
        require_once(__DIR__ . '/weatherapi.class.php');
        require_once(__DIR__ . '/lib/api.weathersource.sdk/sdk/weather_source_api_requests.php');
        DB::$user = 'root';
        DB::$password = 'root';
        DB::$dbName = 'metro_weather';

        $reqMethod = strtolower($_SERVER['REQUEST_METHOD']) . 'Method';

        $wApi = new WeatherApi($_REQUEST);
        $wApi->$reqMethod($_REQUEST);

    } else {
        throw new Exception('Improper headers.');
    }