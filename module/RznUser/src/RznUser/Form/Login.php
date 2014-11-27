<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 11.11.14                                      
  * ----------------------------------------------------
  *
  */


namespace RznUser\Form;

use Traversable;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class Login extends Form
{
    public function init()
    {
        $this->setAttribute('method', 'post')
             ->setAttribute('action', '/login/')
             ->setAttribute('enctype', 'multipart/form-data');
    }
}
