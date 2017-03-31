<?php
return [
    'modules' => [
        'Core',
        'Auth',
        'Jobs',
        'Organizations',
        'CompanyRegistration',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ]
];
