<?php

namespace RznBlog\Controller;

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
        $category = $this->params()->fromRoute('category', null);
        $category1 = $this->params()->fromRoute('category1', null);
        $category2 = $this->params()->fromRoute('category2', null);
        $page = $this->params()->fromRoute('page', null);
        return ['category' => $category,'category2' => $category2,'category1' => $category1, 'page' => $page];
    }

    public function postAction()
    {
        return new ViewModel();
    }
}
