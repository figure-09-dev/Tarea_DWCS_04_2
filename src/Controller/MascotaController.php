<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Mascota;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
    public function crearMascota(Request $request,  ValidatorInterface $validator, MascotaService $mascotaService)
    {
        $usuario = $this->getUser();
        $mascota = new Mascota();

        try {
            if ($request->getMethod() === "POST") {
                $nombre = $request->request->get('nombre');
                $peso = $request->request->get('peso');
                $fecha_naci = new DateTimeImmutable($request->request->get('fechaNacimiento'));
                $mascota->setFechaNacimiento($fecha_naci);
                $mascota->setNombre($nombre);
                $mascota->setPeso($peso);


                $errores = $validator->validate($mascota);
                if (count($errores) > 0) {
                    foreach ($errores as $error) {
                        $this->addFlash("warning", $error->getMessage());
                    }
                    return $this->render("mascota/index.html.twig", ["mascota" => $mascota]);
                }
                else{

                    $mascotaService->crearMascota($mascota);
                    $this->addFlash("success", "mascota creada correctamente");
                    return $this->redirectToRoute("mascota/index.html.twig");
                }
            }
            $mascotaService->crearMascota($mascota);
            $this->addFlash('success', 'Entidad creada correctamente');

            return $this->render('mascota/index.html.twig', [
                'controller_name' => 'MascotaController',
                'Mascota' => $mascota
            ]);
        } catch (\Throwable $th) {
            if (!$usuario) {
                $this->addFlash('error', 'Debes iniciar sesión para crear una entidad');
                return $this->redirectToRoute('app_login');
            } else {
                return $this->render("mascota/index.html.twig", ["mascota" => $mascota]);
            }
        }
    }

}
