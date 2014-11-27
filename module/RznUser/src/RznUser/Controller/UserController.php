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

namespace RznUser\Controller;

use RznBase\EventManager\EventManagerAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;


class UserController extends AbstractActionController implements EventManagerAwareInterface
{
    protected $loginForm = null;
    protected $registerForm = null;

    protected $configurableEvents;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var UserControllerOptionsInterface
     */
    protected $options;


    public function __construct($userService = null, $options = null)
    {
        $this->userService = $userService;
        $this->options = $options;
    }


    public function setConfigurableEventManager(EventManagerInterface $eventManager)
    {
        $this->configurableEvents = $eventManager;
    }

    /**
     * User page
     */
    public function loginAction()
    {

        $eventManager = $this->configurableEvents;
        $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);
        /** @var \Zend\EventManager\ResponseCollection $res */
        $res = $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);
        if ($res->stopped()) {
            //?><h2>Остановлено</h2><?
        }

        return new ViewModel();
    }


    public function setLoginForm($form)
    {
        $this->loginForm = $form;
    }

    public function getLoginForm()
    {
        if (!$this->loginForm) {
            $this->getEventManager()->trigger('getLoginForm', $this);
        }
        return $this->loginForm;
    }

    public function setRegisterForm($form)
    {
        $this->registerForm = $form;
    }

    public function getRegisterForm()
    {
        if (!$this->registerForm) {
            $this->getEventManager()->trigger('getRegisterForm', $this);
        }
        return $this->registerForm;

    }

} 