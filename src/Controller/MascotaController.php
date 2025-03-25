<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Mascota;
use App\Entity\User;
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
                $mascota->setUser($usuario);


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

    #[Route('/mascota/list', name: 'app_mascota_list')]
    public function listarMascotas(MascotaService $mascotaService): Response{

        $usuario = $this->getUser();

        if (!$usuario) {
            return $this->redirectToRoute('app_login');
        } 

        $mascotas = $mascotaService->listarMascotas($usuario);
        return $this->render("mascota/list.html.twig", ["mascotas" => $mascotas]);
        
    }

    #[Route('/mascota/remove', name: 'app_mascota_remove')]
    public function eliminarMascota(MascotaService $mascotaService, Mascota $mascota){
        $usuario = $this->getUser();

        if(!$usuario ){
            $this->addFlash('danger', 'debes estar autenticado para hacer esta accion');
            return $this->redirectToRoute('app_login');
        }

        if ($mascota->getUser() !== $usuario) {
            $this->addFlash('danger', 'No puedes eliminar una mascota que no te pertenece.');
            return $this->redirectToRoute('app_mascota_list');
        }

        // Llama al servicio para eliminar la mascota
        if ($mascotaService->eliminarMascota($mascota)) {
            $this->addFlash('success', 'Mascota eliminada correctamente.');
        } else {
            $this->addFlash('danger', 'Hubo un error al eliminar la mascota.');
        }

        return $this->redirectToRoute('app_mascota_list');

    }
}
