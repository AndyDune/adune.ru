<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => [
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'RznBlog\Controller\Index',
                        'action'     => 'list',
                    ),
                ),
            ],
            'rznblog_post_old' => [
                'type'    => 'regex',
                'options' => array(
                    'regex'    => '/article/(?<id>[0-9]+).html',
                    'defaults' => array(
                        'controller'    => 'RznBlog\Controller\Index',
                        'action'        => 'post',
                    ),
                    'spec' => '/article/%id%.html',
                ),

            ],
            'rznblog_post' => [
                'type'    => 'regex',
                'options' => array(
                    'regex'    => '/(?<id>[0-9]+).html',
                    'defaults' => array(
                        'controller'    => 'RznBlog\Controller\Index',
                        'action'        => 'post',
                    ),
                    'spec' => '/%id%.html',
                ),
            ],
            'rznblog_list' => [
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
                        'controller'    => 'RznBlog\Controller\Index',
                        'action'        => 'list',
                        'page'          => 1,
                    ),
                    //'spec' => '/category/%category%/page/%page%',
                ),
            ],

        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
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
            'RznBlog\Controller\Index' => 'RznBlog\Controller\IndexController'
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
