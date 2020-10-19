<?php

namespace App\Service;

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
     */
    public function getToulouseWeather()
    {
        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?id=2972315&appid='. $this->apiKey . '&lang=fr&units=metric'
        );

        $dataJson = $response->getContent();

        $dataPhpArray  = json_decode($dataJson, true);

        return [
            //Weather
            'description' => $dataPhpArray['weather'][0]['description'],
            'icon'        => $dataPhpArray['weather'][0]['icon'],
            'temp'        => $dataPhpArray['main']['temp'],
            'feels_like'  => $dataPhpArray['main']['feels_like'],
            'temp_min'    => $dataPhpArray['main']['temp_min'],
            'temp_max'    => $dataPhpArray['main']['temp_max'],
            'humidity'    => $dataPhpArray['main']['humidity'],
            'speed'       => $this->convertWindSpeed($dataPhpArray['wind']['speed']),
            // Sun
            'sunrise'     => $dataPhpArray['sys']['sunrise'],
            'sunset'      => $dataPhpArray['sys']['sunset'],
            // Town
            'name'        => $dataPhpArray['name'],
        ];
    }

    // Converted to kilometer hour
    public function convertWindSpeed($speedMeterSecond) {
        return $speedMeterSecond * 3.6;
    }
}
