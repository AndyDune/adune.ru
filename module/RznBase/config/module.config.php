<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 24.11.14                                      
  * ----------------------------------------------------
  *
  */
 return array(
     'service_manager' => [
         'invokables' => [
             'RznBase\EventManager\EventManager' => 'RznBase\EventManager\EventManager'
         ],
         'initializers' => [
             'RznBase\EventManager\Initializer'
         ]
     ],

     'controllers' => [
         'initializers' => [
             'RznBase\EventManager\Initializer'
         ]
     ]
     /*
      * Шаблон для описания слушателей событий.
     'rzn_event_manager' => [
         '<event_name>' => array(
             'invokables' => [],
             'factories'  => [],
             'services'   => []
         )
     ]
     */

 );