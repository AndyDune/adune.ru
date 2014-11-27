<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => [
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'RznPress\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ],
            'rznpress_post_old' => [
                'type'    => 'regex',
                'options' => array(
                    'regex'    => '/article/(?<id>[0-9]+).html',
                    'defaults' => array(
                        'controller'    => 'RznPress\Controller\Index',
                        'action'        => 'post',
                    ),
                    'spec' => '/article/%id%.html',
                ),

            ],
            'rznpress_post' => [
                'type'    => 'regex',
                'options' => array(
                    'regex'    => '/(?<id>[0-9]+).html',
                    'defaults' => array(
                        'controller'    => 'RznPress\Controller\Index',
                        'action'        => 'post',
                    ),
                    'spec' => '/%id%.html',
                ),
            ],
            /*
            'rznpress_list_zend' => [
                'type'    => 'segment',
                'options' => array(
                    //'regex'    => '/category/(?<category>[0-9a-b_-]+)(/page/(?<page>([0-9]+)))?',
                    'route'    => '[/date/[:date]][/category/[:category][[/][:category1]][[/][:category2]]][/page/[:page]][/]',
                    'constraints' => array(
                        'category'  => '[(^page)a-zA-Z0-9_-]+',
                        'category1' => '[(^page)a-zA-Z0-9_-]+',
                        'category2' => '[(^page)a-zA-Z0-9_-]+',
                        'page'     => '[0-9]+',
                        'date'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller'    => 'RznPress\Controller\Index',
                        'action'        => 'list',
                        'page'          => 1,
                    ),
                    //'spec' => '/category/%category%/page/%page%',
                ),
            ],
*/
            'rznpress_list' => [
                'type'    => 'RznPress\Router\PathArrayParams',
                'options' => array(
                    //'regex'    => '/category/(?<category>[0-9a-b_-]+)(/page/(?<page>([0-9]+)))?',
                    'route'    => '/article/',
                    'params'   => ['category', 'page', 'date'],
                    'constraints' => array(
                        'category'     => ['count_min' => 1, 'last_to_string' => true, 'regex' => '[a-zA-Z0-9_-]+'],
                        'date'         => ['count_max' => 3, 'regex' => ['[0-9]{4}', '[0-9]{1,2}', '[0-9]{1,2}']],
                        'page'         => ['regex' => '[0-9]+'],
                    ),
                    'defaults' => array(
                        'controller'    => 'RznPress\Controller\Index',
                        'action'        => 'list',
                        'page'          => 1,
                    ),
                    //'spec' => '/category/%category%/page/%page%',
                ),
            ],

        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'RznPress\Router\PathArrayParams' => 'RznPress\Router\PathArrayParams'
        ),


        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'ru_RU',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'RznPress\Controller\Index' => 'RznPress\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
