<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

class WeatherService
{
    private $client;
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->client = HttpClient::create();
        $this->apiKey = $apiKey;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getToulouseWeather()
    {
        try {
            $response = $this->client->request(
                'GET',
                'https://api.openweathermap.org/data/2.5/weather?id=2972315&appid='
                . $this->apiKey . '&lang=fr&units=metric'
            );

            $dataJson = $response->getContent();

            $dataPhpArray  = json_decode($dataJson, true);
        }
        catch (Exception $e) {
            throw new Exception();
        }

        return [
            //Weather
            'description' => $dataPhpArray['weather'][0]['description'],
            'icon'        => $dataPhpArray['weather'][0]['icon'],
            'temp'        => $this->roundTemperatureValue($dataPhpArray['main']['temp']),
            'feels_like'  => $this->roundTemperatureValue($dataPhpArray['main']['feels_like']),
            'temp_min'    => $this->roundTemperatureValue($dataPhpArray['main']['temp_min']),
            'temp_max'    => $this->roundTemperatureValue($dataPhpArray['main']['temp_max']),
            'humidity'    => $dataPhpArray['main']['humidity'],
            'speed'       => $this->convertWindSpeedAndRoundedValue($dataPhpArray['wind']['speed']),
            // Sun
            'sunrise'     => $dataPhpArray['sys']['sunrise'],
            'sunset'      => $dataPhpArray['sys']['sunset'],
            // Town
            'name'        => $dataPhpArray['name'],
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
}
