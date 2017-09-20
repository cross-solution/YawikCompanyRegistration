<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace CompanyRegistration\Factory\Controller;

use CompanyRegistration\Controller\RegistrationController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CompanyRegistration\Options\RegisterControllerOptions;

/**
 * Class RegisterFactory
 * @package Registration\Factory\Controller
 */
class RegisterControllerFactory implements FactoryInterface
{
	public function __invoke( ContainerInterface $container, $requestedName, array $options = null )
	{
		$options = new RegisterControllerOptions(array());
		
		$repositories = $container->get('repositories');
		$authRegisterService = $container->get('Auth\Service\Register');
		$logger = $container->get('Core/Log');
		$formManager = $container->get('FormElementManager');
		return new RegistrationController(
			$options,
			$repositories,
			$authRegisterService,
			$logger,
			$formManager
		);
	}
}