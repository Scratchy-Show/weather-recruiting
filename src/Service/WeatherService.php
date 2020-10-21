<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

class WeatherService
{
    private $client;
    private $apiKey;
    private $dataPhpArray;

    public function __construct($apiKey)
    {
        $this->client = HttpClient::create();
        $this->apiKey = $apiKey;
        $this->dataPhpArray = [];
    }

    /**
     * @param $city
     * @return array
     * @throws
     */
    public function getWeather($city)
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://api.openweathermap.org/data/2.5/weather?q=' .$city . '&appid='
                . $this->apiKey . '&lang=fr&units=metric'
            );

            $dataJson = $response->getContent();

            $this->dataPhpArray  = json_decode($dataJson, true);
        }
        catch (Exception $e) {
            throw new Exception();
        }

        return [
            //Weather
            'description' => $this->dataPhpArray['weather'][0]['description'],
            'icon'        => $this->dataPhpArray['weather'][0]['icon'],
            'temp'        => $this->roundTemperatureValue($this->dataPhpArray['main']['temp']),
            'feels_like'  => $this->roundTemperatureValue($this->dataPhpArray['main']['feels_like']),
            'temp_min'    => $this->roundTemperatureValue($this->dataPhpArray['main']['temp_min']),
            'temp_max'    => $this->roundTemperatureValue($this->dataPhpArray['main']['temp_max']),
            'humidity'    => $this->dataPhpArray['main']['humidity'],
            'speed'       => $this->convertWindSpeedAndRoundedValue($this->dataPhpArray['wind']['speed']),
            // Sun
            'sunrise'     => $this->convertTimeTimezone($this->dataPhpArray['sys']['sunrise']),
            'sunset'      => $this->convertTimeTimezone($this->dataPhpArray['sys']['sunset']),
            // Town
            'name'        => $this->dataPhpArray['name'],
            'timezone'    => $this->dataPhpArray['timezone']
        ];
    }

    // Converted to kilometer hour and rounded the value
    public function convertWindSpeedAndRoundedValue($speedMeterSecond) {
        $speedKilometerHour =  $speedMeterSecond * 3.6;
        return $this->roundTemperatureValue($speedKilometerHour);
    }

    // Round the temperature value
    public function roundTemperatureValue($preciseTemperature) {
        return round($preciseTemperature);
    }

    // Convert time to timezone
    public function convertTimeTimezone($timeStamp) {
        date_default_timezone_set('UTC');

        $timezone = $this->dataPhpArray['timezone'];

        return date('H:i', $timeStamp + $timezone);
    }
}
