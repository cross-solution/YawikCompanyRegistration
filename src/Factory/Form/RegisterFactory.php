<?php
/**
 * YAWIK
 *
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

namespace CompanyRegistration\Factory\Form;

use CompanyRegistration\Form\Register;
use CompanyRegistration\Options\RegistrationFormOptions;
use Auth\Form\RegisterInputFilter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
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
	
	public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
	{
		/**
		 * @var $filter RegisterInputFilter
		 */
		$filter = $container->get('Auth\Form\RegisterInputFilter');
		
		/* @var $config CaptchaOptions */
		$config = $container->get('Auth/CaptchaOptions');
		
		/* @var $configForm RegistrationFormOptions */
		$formOptions = $container->get('CompanyRegistration/RegistrationFormOptions');
		
		$form = new Register(null, $config, $formOptions, $this->role);
		
		$form->setAttribute('id', 'registration');
		
		$form->setInputfilter($filter);
		
		return $form;
	}
}