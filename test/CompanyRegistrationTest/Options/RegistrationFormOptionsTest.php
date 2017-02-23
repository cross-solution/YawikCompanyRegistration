<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 - 2016 Cross Solution (http://cross-solution.de)
 * @author cbleek
 * @license   AGPLv3
 */

namespace CompanyRegistration\Test\Options;

use YawikCompanyRegistration\Options\RegistrationFormOptions as Options;

class RegistrationFormOptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Options $options
     */
    protected $options;

    public function setUp()
    {
        $options = new Options;
        $this->options = $options;
    }

    /**
     * @covers YawikCompanyRegistration\Options\RegistrationFormOptions::getFields
     * @covers YawikCompanyRegistration\Options\RegistrationFormOptions::setFields
     */
    public function testSetGetFields()
    {
        $data="test";
        $this->options->setFields($data);
        $this->assertEquals($data, $this->options->getFields());
    }

    /**
     * @covers YawikCompanyRegistration\Options\RegistrationFormOptions::isEnabled
     * @dataProvider dataProviderisEnabled
     */
    public function testIsFieldEnabled($data,$result){
             $this->options->setFields($data);
             $this->assertEquals($result, $this->options->isEnabled("test"));
    }


    public static function dataProviderIsEnabled(){
        return [
            [["test"=>['enabled'=>true]],true],
            [["test"=>['enabled'=>false]],false],
        ];
    }

    /**
     * @covers YawikCompanyRegistration\Options\RegistrationFormOptions::isRequired
     * @dataProvider dataProviderIsRequired
     */
    public function testIsFieldRequired($data,$result){
        $this->options->setFields($data);
        $this->assertEquals($result, $this->options->isRequired("test"));
    }

    public static function dataProviderIsRequired(){
        return [
            [["test"=>['required'=>true]],true],
            [["test"=>['required'=>false]],false],
        ];
    }

}
