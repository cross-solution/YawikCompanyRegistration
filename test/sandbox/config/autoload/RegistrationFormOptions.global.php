<?php
/**
 * YAWIK
 *
 * Configuration file of the registration form
 *
 * Copy this file into your autoload directory (without .dist) and adjust it for your needs
 *
 * @copyright (c) 2013 - 2017 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

$fields = [
        'gender' => [
            'enabled' => true,
            'required' => true,
            'order' => 1
        ],
        'name' => [
            'enabled' => true,
            'required' => true,
            'order' => 2
        ],
        'email' => [
            'enabled' => true,
            'required' => true,
            'order' => 3,
        ],
        'organizationName' => [
            'enabled' => true,
            'required' => true,
            'order' => 4,
        ],
        'postalCode' => [
            'enabled' => true,
            'required' => true,
            'order' => 5,
        ],
        'city' => [
            'enabled' => true,
            'required' => true,
            'order' => 6
        ],
        'street' => [
            'enabled' => true,
            'required' => true,
            'order' => 7
        ],
        'houseNumber' => [
            'enabled' => true,
            'required' => true,
            'order' => 8
        ],
        'phone' => [
            'enabled' => true,
            'required' => true,
            'order' => 9
        ],
        ];


//
// Do not change below this line!
//

return [
    'options' => [
        'YawikCompanyRegistration/RegistrationFormOptions' => [
            'options' => [
                'fields' => $fields,
            ],
        ],
    ]
];
