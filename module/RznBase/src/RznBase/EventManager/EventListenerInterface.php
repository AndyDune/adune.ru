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


namespace RznBase\EventManager;


interface EventListenerInterface
{
    public function trigger($e);
} 