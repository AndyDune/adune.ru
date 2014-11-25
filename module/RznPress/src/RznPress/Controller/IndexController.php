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
        $sm = $this->getServiceLocator();

        $eventManager = $sm->get('rzn_event_manager');
        $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);

        $eventManager->trigger('user_login_after', $this, ['line' => __LINE__]);

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
