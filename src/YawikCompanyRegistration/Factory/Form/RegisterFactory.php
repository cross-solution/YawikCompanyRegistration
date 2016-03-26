<?php
/**
 * YAWIK
 *
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

namespace YawikCompanyRegistration\Factory\Form;

use YawikCompanyRegistration\Form\Register;
use Auth\Form\RegisterInputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Auth\Options\CaptchaOptions;

class RegisterFactory implements FactoryInterface
{
    /**
    * @var string 
    */
    protected $role = 'recruiter';

    public function __construct($options = []){
        if (isset($options['role'])) {
            $this->role=$options['role'];
        } else {
            $this->role='recruiter';
        }
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Register
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $serviceLocator \Zend\Form\FormElementManager
         * @var $filter RegisterInputFilter
         */
        $filter = $serviceLocator->getServiceLocator()->get('Auth\Form\RegisterInputFilter');

        /* @var $config CaptchaOptions */
        $config = $serviceLocator->getServiceLocator()->get('Auth/CaptchaOptions');

        $form = new Register(null, $config, $this->role);

        $form->setAttribute('id', 'registration');

        $form->setInputfilter($filter);

        return $form;
    }
}