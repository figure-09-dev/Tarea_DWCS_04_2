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

    // public function crearMascota(string $nombre, \DateTimeImmutable $fecha_naci, float $peso, User $usuario): Mascota
    // {
    //     $mascota = new Mascota();
    //     $mascota->setNombre($nombre);
    //     $mascota->setFechaNacimiento($fecha_naci);
    //     $mascota->setPeso($peso);
    //     $mascota->setUser($usuario);


        
    //     $this->entityManager->persist($mascota);
    //     $this->entityManager->flush();
        
    //     return $mascota;
    // }


}