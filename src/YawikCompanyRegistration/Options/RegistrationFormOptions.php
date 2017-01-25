<?php
/**
 * YAWIK
*
* @filesource
* @license    MIT
* @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
*/
namespace YawikCompanyRegistration\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * registration form options
 *
 * @author Carsten Bleek <bleek@cross-solution.de>
 * @since 0.29
 */
class RegistrationFormOptions extends AbstractOptions
{

    /**
     * valid field names of the registration formular
     */
    const FIELD_GENDER = 'gender';
    const FIELD_NAME = 'name';
    const FIELD_EMAIL = 'email';
    const FIELD_ORGANIZATION_NAME = 'organizationName';
    const FIELD_POSTAL_CODE = 'postalCode';
    const FIELD_CITY = 'city';
    const FIELD_HOUSE_NUMBER = 'houseNumber';
    const FIELD_STREET = 'street';
    const FIELD_PHONE = 'phone';

    /**
     * Formular fields. The keys 'gender', 'name', .... must not be changed. Use 'enabled' => false for disabling a
     * formular field. Use 'required' => false to make formular field optional.
     *
     * @var array
     */
    protected $fields = [
        self::FIELD_GENDER => [
            'enabled' => false,
            'required' => true,
        ],
        self::FIELD_NAME => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_EMAIL => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_ORGANIZATION_NAME => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_POSTAL_CODE => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_CITY => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_STREET => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_HOUSE_NUMBER => [
            'enabled' => true,
            'required' => true,
        ],
        self::FIELD_PHONE => [
            'enabled' => true,
            'required' => true,
        ],
    ];


    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return RegistrationFormOptions
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function isEnabled($field){
        return $this->fields[$field]['enabled'];
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function isRequired($field){
        return $this->fields[$field]['required'];
    }

}
