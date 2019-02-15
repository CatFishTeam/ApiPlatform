<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class IsFlightInJourneyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof IsFlightInJourney) {
            throw new UnexpectedTypeException($constraint, IsFlightInJourney::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if(!is_a(!$value,'Flight')){
            //dump(json_encode(gettype($value)));
            throw new UnexpectedValueException($value, 'Flight');
        }

        $flight = $this->context->getObject();
        $journey = $flight->getJourneys();

        return json_encode($journey);

        /*
        if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
        */
    }
}
