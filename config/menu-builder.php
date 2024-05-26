<?php

// configuration for yamanhacioglu/menu-builder
return [
    'base_url' => '',
    'prefix' => '/admin',
    'namespace' => '\YamanHacioglu\MenuBuilder',
    'controller_namespace' => '\YamanHacioglu\MenuBuilder\http\Controllers',
    'resources_path' => 'vendor/yamanhacioglu/menu-builder/publishable/assets/',
    'views' => 'vendor/yamanhacioglu/menu-builder/publishable/views',

    //menu configurations
    'depth' => 5,
    'apply_child_as_parent' => false,
    'levels' => [
        'root' => [
            'style' => 'horizontal', // horizontal | vertical
        ],
        'child' => [
            'show' => 'onClick', // onclick or onhover
            'level_1' => [
                'show' => 'onClick',
                'position' => 'bottom',
            ],
            'level_2' => [
                'show' => 'onHover',
                'position' => 'right',
            ],
        ],
    ],
];
