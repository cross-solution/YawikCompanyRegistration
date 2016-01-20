<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2015 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace YawikCompanyRegistration\Form;

use Core\Form\ButtonsFieldset;
use Core\Form\Form;
use Zend\Captcha\Image;
use Zend\Captcha\ReCaptcha;
use Zend\Form\Fieldset;
use Auth\Options\CaptchaOptions;
use Auth\Entity\User;

class Register extends Form
{
    public function __construct($name = 'register-form', CaptchaOptions $options, $role = 'recruiter')
    {
        parent::__construct($name, []);

        $this->setAttribute('data-handle-by', 'native');
        $this->setAttribute('class', 'form-horizontal');

        $fieldset = new Fieldset('register');
        $fieldset->setOptions(array('renderFieldset' => true));

        $fieldset->add(
            array(
                'name' => 'gender',
                'type' => 'Zend\Form\Element\Select',
                'options' => array(
                    'label' => /*@translate */ 'Salutation',
                    'value_options' => array(
                        '' => '', // => /*@translate */ 'please select',
                        'male' => /*@translate */ 'Mr.',
                        'female' => /*@translate */ 'Mrs.',
                    )
                ),
                'attributes' => array(
                    'data-placeholder' => /*@translate*/ 'please select',
                    'data-allowclear' => 'false',
                    'data-searchbox' => -1,
                    'required' => true
                ),
            )
        );

        $fieldset->add(
            array(
                     'type' => 'text',
                     'name' => 'name',
                     'options' => array(
                         'label' => /*@translate*/ 'Name',
                     ),
                     'attributes' => [
                         'required' => true
                     ],
                 )
        );

        $fieldset->add(
            array(
                     'type' => 'email',
                     'name' => 'email',
                     'options' => array(
                         'label' => /*@translate*/ 'Email',
                     ),
                     'attributes' => [
                         'required' => true
                     ],                     
                 )
        );

        if (User::ROLE_RECRUITER === $role) {
            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'organizationName',
                    'options'    => array(
                        'label' => /*@translate*/
                            'Companyname',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );

            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'postalCode',
                    'options'    => array(
                        'label' => /*@translate*/
                            'Postalcode',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );

            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'city',
                    'options'    => array(
                        'label' => /*@translate*/
                            'City',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );

            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'street',
                    'options'    => array(
                        'label' => /*@translate*/
                            'Street',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );

            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'houseNumber',
                    'options'    => array(
                        'label' => /*@translate*/
                            'house number',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );

            $fieldset->add(
                array(
                    'type'       => 'text',
                    'name'       => 'phone',
                    'options'    => array(
                        'label' => /*@translate*/
                            'Phone',
                    ),
                    'attributes' => [
                        'required' => true
                    ],
                )
            );
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
                            'label'   => /*@translate*/
                                'Are you human?',
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
