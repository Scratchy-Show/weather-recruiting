<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherService;

class WeatherController extends AbstractController
{
    private $weatherService;

    public function __construct(WeatherService $weather)
    {
        $this->weatherService = $weather;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $data = $this->weatherService->getToulouseWeather();
        return $this->render('weather/index.html.twig', array(
            'data' => $data
        ));
    }
}
