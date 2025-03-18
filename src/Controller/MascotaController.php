<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Mascota;
use App\Service\MascotaService;
use DateTimeImmutable;
use PhpParser\Node\Stmt\TryCatch;

final class MascotaController extends AbstractController
{
    #[Route('/mascota', name: 'app_mascota')]
    public function index(): Response
    {
        return $this->render('mascota/index.html.twig', [
            'controller_name' => 'MascotaController',
        ]);
    }

    #[Route('/mascota/new', name: 'app_mascota_new')]
    public function crearMascota(Request $request, MascotaService $mascotaService): Response
    {
        $usuario = $this->getUser();

        try {
            $nombre = $request->request->get('nombre');
            $peso = $request->request->get('peso');
            $fecha_naci = new DateTimeImmutable($request->request->get('fechaNacimiento'));
    
            $mascota = $mascotaService->crearMascota($nombre, $fecha_naci, $peso, $usuario);
            
            $this->addFlash('success', 'Entidad creada correctamente');

            return $this->render('mascota/index.html.twig', [
                'controller_name' => 'MascotaController',
                'Mascota' => $mascota
            ]);

        } catch (\Throwable $th) {
            if (!$usuario) {
                $this->addFlash('error', 'Debes iniciar sesión para crear una entidad');
                return $this->redirectToRoute('app_login');
            }
        }


       

      
    }

    /**
    * 
    *  $nombre = $request->request->get('nombre');
    *  $mascota = $mascotaService->crearMascota($nombre, $usuario);
    */

    /*
     public function index(DateTime $fecha ):Response
    {

        $autores =$this->consultasService->getAutoresByFechaNac($fecha);

        return $this->render('consultas/index.html.twig', [
            'controller_name' => 'ConsultasController',
            'autores' => $autores
        ]);
    }
    */
}
