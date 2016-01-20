<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2015 Cross Solution (http://cross-solution.de)
 * @license   MIT
 * @author    weitz@cross-solution.de
 */

namespace YawikCompanyRegistration\Factory\Controller;

use YawikCompanyRegistration\Controller\RegistrationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use YawikCompanyRegistration\Options\RegisterControllerOptions;

/**
 * Class RegisterFactory
 * @package Registration\Factory\Controller
 */
class RegisterControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RegistrationController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $options = new RegisterControllerOptions(array());

        return new RegistrationController($options);
    }
}