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
    'router' => [
        'routes' => [
            'user/login' => array(
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => 'user',
                        'action'     => 'login'
                    ]
                ]
            ),
            'user/register' => array(
                'type' => 'Literal',
                'options' => [
                    'route' => '/register',
                    'defaults' => [
                        'controller' => 'user',
                        'action'     => 'register'
                    ]
                ]
            ),
            'user/logout' => array(
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => 'user',
                        'action'     => 'logout'
                    ]
                ]
            )
        ]
    ],

    'controllers' => [
        'factories' => array(
            'user' => 'RznUser\Factory\Controller\UserControllerFactory',
        ),
    ],

    'form_elements' => [
        'invokables' => array(
            'user_login' => 'RznUser\Form\Login',
            'user_register' => 'RznUser\Form\Register'
        )
    ],

    'rzn_event_manager' => [
        'user_login_before' => array(
            'invokables' => ['RznUser\EventListener\UserLoginBefore' => 'RznUser\EventListener\UserLoginBefore'],
        ),
        'user_login_after' => array(
            'invokables' => ['RznUser\EventListener\UserLogin' => 'RznUser\EventListener\UserLogin'],
        )
    ],

    'view_manager' => [
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ],

);