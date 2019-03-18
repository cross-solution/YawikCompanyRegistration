<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace CompanyRegistration\Form;

use Auth\Form\RegisterFormInterface;
use CompanyRegistration\Options\RegistrationFormOptions;
use Core\Form\ButtonsFieldset;
use Core\Form\Form;
use Zend\Captcha\Image;
use Zend\Captcha\ReCaptcha;
use Zend\Form\Fieldset;
use Auth\Options\CaptchaOptions;
use Auth\Entity\User;

class Register extends Form implements RegisterFormInterface
{
    public function __construct($name = 'register-form', CaptchaOptions $options, RegistrationFormOptions $formOptions, $role = User::ROLE_RECRUITER)
    {
        parent::__construct($name, []);

        $this->setAttribute('data-handle-by', 'native');
        $this->setAttribute('class', 'form-horizontal');

        $fieldset = new Fieldset('register');
        $fieldset->setOptions(array('renderFieldset' => true));

        if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_GENDER)) {
            $fieldset->add(
                [
                    'name'       => RegistrationFormOptions::FIELD_GENDER,
                    'type'       => 'Zend\Form\Element\Select',
                    'options'    => [
                        'label'         => /*@translate */ 'Salutation',
                        'value_options' => [
                            ''       => '', // => /*@translate */ 'please select',
                            'male'   => /*@translate */ 'Mr.',
                            'female' => /*@translate */ 'Mrs.',
                        ]
                    ],
                    'attributes' => [
                        'data-placeholder' => /*@translate*/ 'please select',
                        'data-allowclear'  => 'false',
                        'data-searchbox'   => -1,
                        'required'         => $formOptions->isRequired(RegistrationFormOptions::FIELD_GENDER)
                    ],
                ]
            );
        }


        if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_NAME)){
            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => RegistrationFormOptions::FIELD_NAME,
                    'options'    => array(
                        'label' => /*@translate*/ 'Name',
                    ),
                    'attributes' => [
                        'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_NAME)
                    ],
                )
            );
        }

        if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_EMAIL))
        $fieldset->add(
            array(
                     'type' => 'email',
                     'name' => RegistrationFormOptions::FIELD_EMAIL,
                     'options' => array(
                         'label' => /*@translate*/ 'Email',
                     ),
                     'attributes' => [
                         'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_EMAIL)
                     ],                     
                 )
        );

        if (User::ROLE_RECRUITER === $role) {
            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_ORGANIZATION_NAME)){
                $fieldset->add(
                    array(
                        'type'       => 'text',
                        'name'       => RegistrationFormOptions::FIELD_ORGANIZATION_NAME,
                        'options'    => array(
                            'label' => /*@translate*/ 'Companyname',
                        ),
                        'attributes' => [
                            'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_ORGANIZATION_NAME)
                        ],
                    )
                );
            }

            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_POSTAL_CODE)){
                $fieldset->add(
                    [
                        'type'       => 'text',
                        'name'       => RegistrationFormOptions::FIELD_POSTAL_CODE,
                        'options'    => array(
                            'label' => /*@translate*/ 'Postalcode',
                        ),
                        'attributes' => [
                            'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_POSTAL_CODE)
                        ],
                    ]
                );
            }

            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_CITY)) {

                $fieldset->add(
                    array(
                        'type'       => 'text',
                        'name'       => 'city',
                        'options'    => [
                            'label' => /*@translate*/ 'City',
                        ],
                        'attributes' => [
                            'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_CITY)
                        ],
                    )
                );
            }

            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_STREET)) {
                $fieldset->add(
                    array(
                        'type'       => 'text',
                        'name'       => RegistrationFormOptions::FIELD_STREET,
                        'options'    => [
                            'label' => /*@translate*/ 'Street',
                        ],
                        'attributes' => [
                            'required' =>$formOptions->isRequired(RegistrationFormOptions::FIELD_STREET)
                        ],
                    )
                );
            }

            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_HOUSE_NUMBER)) {
                $fieldset->add(
                    array(
                        'type'       => 'text',
                        'name'       => RegistrationFormOptions::FIELD_HOUSE_NUMBER,
                        'options'    => [
                            'label' => /*@translate*/ 'house number',
                        ],
                        'attributes' => [
                            'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_HOUSE_NUMBER)
                        ],
                    )
                );
            }

            if ($formOptions->isEnabled(RegistrationFormOptions::FIELD_PHONE)) {
                $fieldset->add(
                    array(
                        'type'       => 'text',
                        'name'       => RegistrationFormOptions::FIELD_PHONE,
                        'options'    => [
                            'label' => /*@translate*/ 'Phone',
                        ],
                        'attributes' => [
                            'required' => $formOptions->isRequired(RegistrationFormOptions::FIELD_PHONE)
                        ],
                    )
                );
            }
        }

        $fieldset->add(
            array(
                'name'       => 'role',
                'type'       => 'hidden',
                'attributes' => array(
                    'value' => $role,
                ),
            )
        );

        $this->add($fieldset);

        $mode = $options->getMode();
        if (in_array($mode, [CaptchaOptions::RE_CAPTCHA, CaptchaOptions::IMAGE])) {
            if ($mode == CaptchaOptions::IMAGE) {
                $captcha = new Image($options->getImage());
            } elseif ($mode == CaptchaOptions::RE_CAPTCHA) {
                $captcha = new ReCaptcha($options->getReCaptcha());
            }

            if (!empty($captcha)) {
                $this->add(
                    array(
                        'name'    => 'captcha',
                        'options' => array(
                            'label'   => /*@translate*/ 'Are you human?',
                            'captcha' => $captcha,
                        ),
                        'type'    => 'Zend\Form\Element\Captcha',
                    )
                );
            }
        }

        $buttons = new ButtonsFieldset('buttons');
        $buttons->add(
            array(
                    'type' => 'submit',
                    'name' => 'button',
                    'attributes' => array(
                        'type' => 'submit',
                        'value' => /*@translate*/ 'Register',
                        'class' => 'btn btn-primary'
                    ),
                )
        );

        $this->add(
            array(
                 'name' => 'csrf',
                 'type' => 'csrf',
                 'options' => array(
                     'csrf_options' => array(
                         'salt' => str_replace('\\', '_', __CLASS__),
                         'timeout' => 3600
                     )
                 )
             )
        );

        $this->add($buttons);
    }
}
