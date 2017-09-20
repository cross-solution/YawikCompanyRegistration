<?php
$commonModules = include __DIR__.'/../../../config/common.modules.php';
$modules = array_merge($commonModules,[
	'Core',
	'Auth',
	'Jobs',
	'Organizations',
	'CompanyRegistration',
]);
return [
    'modules' => $modules,
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
