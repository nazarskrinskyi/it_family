<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AgeDifference extends Constraint
{
    public string $message = 'The age difference between a parent and child must be at least 16 years.';

    public int $minDifference = 16;
}
