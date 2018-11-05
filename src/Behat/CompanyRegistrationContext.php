<?php

namespace CompanyRegistration\Behat;

use Behat\Behat\Context\Context;
use Yawik\Behat\CommonContextTrait;

/**
 * Class CompanyRegistrationContext
 *
 * @package CompanyRegistration\Behat
 * @author Anthonius Munthi <me@itstoni.com>
 * @since 0.32
 */
class CompanyRegistrationContext implements Context
{
    use CommonContextTrait;

    /**
     * @Given /I want to register/
     */
    public function iWantToRegister()
    {
        $url = $this->buildUrl('lang/register');
        $this->minkContext->getSession()->visit($url);
    }
}
