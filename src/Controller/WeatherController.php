<?php

namespace App\Controller;

use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

class WeatherController extends AbstractController
{
    private $weatherService;

    public function __construct(WeatherService $weather)
    {
        $this->weatherService = $weather;
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     * @throws
     */
    public function index(Request $request)
    {
        $defaultData = ['message' => 'Rechercher une ville'];
        $form = $this->createFormBuilder($defaultData)
            ->add('city', TextType::class,  [
                'attr' => [
                    'placeholder' => 'Indiquer votre ville'
                ],
                'constraints' =>  [
                    new NotBlank(['message' => 'La valeur ne peut être vide'])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form->get('city')->getData();

            $data = $this->weatherService->getWeather($city);

            return $this->render('weather/index.html.twig', array(
                'data' => $data,
                'form' => $form->createView()
            ));
        }
        $Toulouse = 'Toulouse';

        $data = $this->weatherService->getWeather($Toulouse);

        return $this->render('weather/index.html.twig', array(
            'data' => $data,
            'form' => $form->createView()
        ));
    }
}
