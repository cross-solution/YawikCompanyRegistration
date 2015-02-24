<?php
/**
 * YAWIK
 * 
 * @filesource
 * @copyright (c) 2013-2015 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

return array(
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'Auth\Controller\Register' => 'YawikCompanyRegistration\Factory\Controller\RegisterFactory',
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
        'invokables' => array(
            'Registration\Form\Register' => 'YawikCompanyRegistration\Form\Register',
        ),
        'factories' => array(
        )
    ),
);