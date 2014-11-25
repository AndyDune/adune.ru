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
    'rzn_event_manager' => [
        'user_login_before' => array(
            'invokables' => ['RznUser\EventListener\UserLoginBefore' => 'RznUser\EventListener\UserLoginBefore'],
        ),
        'user_login_after' => array(
            'invokables' => ['RznUser\EventListener\UserLogin' => 'RznUser\EventListener\UserLogin'],
        )
    ]
);