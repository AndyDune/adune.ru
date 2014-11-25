<?php

namespace RznPress\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        $category = [];
        $category = $this->params()->fromRoute('category', null);

        $page = $this->params()->fromRoute('page', null);
        $date = $this->params()->fromRoute('date', null);

        /** @var \RznBase\EventManager\EventManager $eventManager */
        $eventManager = $this->getEventManager();
        //print_r($eventManager);
        $sm = $this->getServiceLocator();

        $eventManager = $sm->get('rzn_event_manager');
        $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);
        /** @var \Zend\EventManager\ResponseCollection $res */
        $res = $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);
        if ($res->stopped()) {
            // Обработчик был остановлен - это ошибка.
            ?><h2>Остановлено</h2><?
        }
        print_r($res);

        return ['category' => $category, 'page' => $page, 'date' => $date];
    }

    public function postAction()
    {
        $id = $this->params()->fromRoute('id', null);
        return ['id' => $id];
    }

    /**
     * Список всех доступных категорий
     * @return array
     */
    public function getCategoryAvailable()
    {

    }

}
