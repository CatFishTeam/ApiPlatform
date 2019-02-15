<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Flight;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddLuggageEventSubscriber implements EventSubscriberInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['EncodeUserPassword', EventPriorities::POST_VALIDATE],
        ];
    }

    public function EncodeUserPassword(GetResponseForControllerResultEvent $event)
    {
        $flight = $event->getControllerResult();

        if (!$flight instanceof Flight){
            return;
        }

        $passengers = $flight->getPassengers();
        foreach ($passengers as $passenger)
        {
            $flight->addLuggage($passenger->getLuggage());
        }
    }

}
