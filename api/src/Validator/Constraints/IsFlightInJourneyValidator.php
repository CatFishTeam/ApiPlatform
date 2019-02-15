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

        $flight = $this->context->getObject();
        $journeys = $flight->getJourneys();

        foreach ($journeys as $journey){
            if( $flight->getDepartureDate() < $journey->getStartingDate() ) //If flight is before journey starting date
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ date }}', "Departure Date")
                    ->addViolation();
            }
            if($flight->getArrivalDate()  > $journey->getEndingDate())
            {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ date }}', "Arrival Date")
                    ->addViolation();
            }
        }

    }
}
