<?php
/**
 * Created by PhpStorm.
 * User: sergeiakimov
 * Date: 10/1/17
 * Time: 1:45 PM
 */

namespace Sa\TemperatureConverter\Validation;

/**
 * Class RuleMinOrEquals
 *
 * @package Sa\TemperatureConverter\Validation
 */
class RuleMinOrEquals extends ValidationRule
{
    /**
     * Min value
     *
     * @var
     */
    protected $min;

    /**
     * Validate messages
     *
     * @var
     */
    protected $message = 'Value is too small';

    /**
     * RuleMin constructor.
     *
     * @param $min
     */
    public function __construct($min)
    {
        $this->min = $min;
    }

    /**
     * Validate
     *
     * @param $value
     * @return bool
     */
    public function passes($value)
    {
        return $this->min <= $value;
    }

    /**
     * Validation message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}