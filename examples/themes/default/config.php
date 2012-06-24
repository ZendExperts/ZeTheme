<?php
return array(
    'template_path_stack' => array(
        'default' => __DIR__ . '/view',
    ),
    'template_map' => array(
        'layout/layout'           => __DIR__ . '/view/layout/layout.phtml',
        'application/index/index' => __DIR__ . '/view/application/index/index.phtml',
        'error/404'               => __DIR__ . '/view/error/404.phtml',
        'error/index'             => __DIR__ . '/view/error/index.phtml', 
    ),
);