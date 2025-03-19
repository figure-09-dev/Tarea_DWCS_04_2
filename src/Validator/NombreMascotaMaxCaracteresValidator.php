<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintValidator;

final class NombreMascotaMaxCaracteresValidator extends ConstraintValidator
{
    const MAX_CARACTERES = 30;
    public function validate(mixed $nombreMascota, Constraint $constraint): void
    {
        /* @var NombreMascotaMaxCaracteres $constraint */

        if (null === $nombreMascota || '' === $nombreMascota) {
            return;
        }

        // TODO: implement the validation here
        if (sizeof($nombreMascota) > 30) {
            $this->context->buildViolation($constraint->message)
            ->setParameter('{{ nombreMascota }}', $nombreMascota)
            ->addViolation()
        ;
        }

    }
}
