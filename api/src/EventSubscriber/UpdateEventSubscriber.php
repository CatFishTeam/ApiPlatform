<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Flight;
use App\Entity\User;
use App\Entity\Journey;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UpdateEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['UpdateEntity', EventPriorities::POST_VALIDATE],
        ];
    }

    public function UpdateEntity(GetResponseForControllerResultEvent $event)
    {
        return;
        $method = $event->getRequest()->getMethod();

        if($method !== 'PUT'){
            return;
        }

        $entity = $event->getControllerResult();
        if (!$entity instanceof User || !$entity instanceof Flight || !$entity instanceof Journey){
            return;
        }

        $entity->setUpdatedAt(date('Y-m-d H:i:s'));

    }
}
