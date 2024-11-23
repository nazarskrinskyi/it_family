<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AgeDifferenceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint AgeDifference */

        $parentAge = $value['parentAge'] ?? null;
        $childAge = $value['childAge'] ?? null;

        if ($parentAge === null || $childAge === null) {
            return;
        }

        $difference = abs($parentAge - $childAge);

        if ($difference < $constraint->minDifference) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ parent }}', $value['parentName'])
                ->setParameter('{{ child }}', $value['childName'])
                ->setParameter('{{ min }}', $constraint->minDifference)
                ->addViolation();
        }
    }
}
