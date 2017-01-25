<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

return array(
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Auth\Controller\Register' => 'YawikCompanyRegistration\Factory\Controller\RegisterControllerFactory',
        )
    ),

    'view_manager' => array(
        'template_map' => array(
            'registration\completed' => __DIR__ . '/../view/yawik-company-registration/registration/complete.phtml',
        ),

        'template_path_stack' => array(
            'Registration' => __DIR__ . '/../view',
        ),
    ),

    'form_elements' => array(
        'factories' => [
            'Auth\Form\Register' => 'YawikCompanyRegistration\Factory\Form\RegisterFactory',
        ]
    ),
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
    'options' => [
        'YawikCompanyRegistration/RegistrationFormOptions' => [
            'class' => '\YawikCompanyRegistration\Options\RegistrationFormOptions'
        ]
    ]
);
