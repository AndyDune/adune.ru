<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 07.11.14                                      
  * ----------------------------------------------------
  *
  */


use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use RznUser\Controller\UserController;

class UserControllerFactory implements FactoryInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;
    /**
     * Create controller
     *
     * @param ControllerManager $serviceLocator
     * @return UserController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /* @var ServiceLocatorInterface $serviceLocator */
        $this->serviceLocator = $controllerManager->getServiceLocator();

        $userService = $this->serviceLocator->get('rznuser_user_service');
        $options = $this->serviceLocator->get('rznuser_module_options');

        $controller = new UserController($userService, $options);
        $eventManager = $controller->getEventManager();

        $eventManager->attach('getLoginForm', [$this, 'setLoginForm']);
        $eventManager->attach('getRegisterForm', [$this, 'setRegisterForm']);

        return $controller;
    }

    public function setLoginForm($e)
    {
        $e->getContext->setLoginForm($this->serviceLocator->get('rznuser_login_form'));
    }

    public function setRegisterForm($e)
    {
        $e->getContext()->setRegisterForm($this->serviceLocator->get('rznuser_register_form'));
    }

}
