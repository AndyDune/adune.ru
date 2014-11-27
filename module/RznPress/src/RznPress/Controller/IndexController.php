<?php

namespace RznPress\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $events = $this->getEventManager();
        //print_r($events->getListeners('dispatch'));
        return new ViewModel();
    }

    public function listAction()
    {
        $category = [];
        $category = $this->params()->fromRoute('category', null);

        $page = $this->params()->fromRoute('page', null);
        $date = $this->params()->fromRoute('date', null);


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
