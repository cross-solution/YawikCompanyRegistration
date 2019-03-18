<?php

chdir(dirname(__DIR__));
return [
    'modules' => [
        'Core',
        'Auth',
        "Settings",
        'Jobs',
        'Organizations',
        'CompanyRegistration',
    ],
];
