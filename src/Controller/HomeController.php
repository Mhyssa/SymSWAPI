<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $HttpClient): Response
    {
        $personnages = $HttpClient->request(
            'GET',
            'https://swapi.dev/api/people'
        );
        // dd($personnages->toArray()['results']);

        return $this->render('home/index.html.twig', [
            'personnages' => $personnages->toArray()['results'],
        ]);
    }

    #[Route('/personnage/{id}', name: 'app_personnage', requirements: ['id' => '\d+'])]
    public function personnage(int $id, HttpClientInterface $HttpClient): Response
    {
        $personnage = $HttpClient->request(
            'GET',
            'https://swapi.dev/api/people/'.$id
        );
        

        return $this->render('home/personnage.html.twig', [
            'personnage' => $personnage->toArray(),
        ]);
    }
}
