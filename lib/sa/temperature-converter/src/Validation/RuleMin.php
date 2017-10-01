<?php
/**
 * Created by PhpStorm.
 * User: sergeiakimov
 * Date: 10/1/17
 * Time: 1:45 PM
 */

namespace Sa\TemperatureConverter\Validation;


class RuleMin extends ValidationRule
{
    /**
     * Min value
     *
     * @var
     */
    private $min;

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
        return $this->min < $value;
    }

}