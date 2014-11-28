<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 27.11.14                                      
  * ----------------------------------------------------
  *
  */


namespace RznBase\EventManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Initializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $serviceManager)
    {
        if ($instance instanceof EventManagerAwareInterface) {
            $eventManager = $serviceManager->get('RznBase\EventManager\EventManager');
            //print_r($eventManager);
            $instance->setConfigurableEventManager($eventManager);
        }
    }
} 