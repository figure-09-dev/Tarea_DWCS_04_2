<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Mascota;
use App\Repository\MascotaRepository;
use App\Entity\User;


class MascotaService{
    public function __construct(private EntityManagerInterface $entityManager, private MascotaRepository $mascotaRepository)
    {
      
    }

    public function crearMascota(Mascota $mascota)
    {  
        $this->entityManager->persist($mascota);
        $this->entityManager->flush();
        
    }

    public function listarMascotas(User $user){
        return $this->mascotaRepository->findMascotasByUsuario($user);
        
    }

    public function eliminarMascota (Mascota $mascota){
        try {
            $this->entityManager->remove($mascota);
            $this->entityManager->flush();

            return true;
        } catch (\Throwable $th) {

            return false;
        }
    }

}