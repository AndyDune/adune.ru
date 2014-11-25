<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 25.11.14                                      
  * ----------------------------------------------------
  *
  */

namespace RznUser\EventListener;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use RznBase\EventManager\Event;
use RznBase\EventManager\EventListenerInterface;

class UserLoginBefore implements ServiceLocatorAwareInterface, EventListenerInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /*
     * Применяется если нет интерфейса EventListenerInterface
     *
    public function __invoke(Event $e)
    {
        echo get_class($e->getTarget());
        print_r($e->getParams());
    }
    */

    public function trigger($e)
    {
        echo get_class($e->getTarget());
        //$e->stopPropagation(); - если ошибка
        print_r($e->getParams());
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceManager;
    }

}