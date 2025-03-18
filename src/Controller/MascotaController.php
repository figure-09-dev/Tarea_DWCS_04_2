<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MascotaController extends AbstractController
{
    #[Route('/mascota', name: 'app_mascota')]
    public function index(): Response
    {
        return $this->render('mascota/index.html.twig', [
            'controller_name' => 'MascotaController',
        ]);
    }
}
