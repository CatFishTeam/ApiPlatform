<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsFlightInJourney extends Constraint
{
    public $message = 'The flight {{ date }} are not contained in the journey time lapse';
}
