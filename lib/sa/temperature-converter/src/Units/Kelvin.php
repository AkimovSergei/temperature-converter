<?php

namespace Sa\TemperatureConverter\Units;

use Sa\TemperatureConverter\AbstractUnit;
use Sa\TemperatureConverter\Validation\RuleMinOrEquals;

/**
 * Class Kelvin
 *
 * @package Sa\TemperatureConverter\Units
 */
class Kelvin extends AbstractUnit
{

    /**
     * Kelvin constructor.
     */
    public function __construct()
    {
        parent::__construct("K");

        $this->rules = [
            'temperature' => [
                new RuleMinOrEquals(0),
            ],
        ];
    }

    /**
     * Convert Celsius to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromCelsius(float $temperature): float
    {
        return $temperature + 273.15;
    }

    /**
     * Convert Fahrenheit to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromFahrenheit(float $temperature): float
    {
        return ($temperature - 32) * (5 / 9);
    }

    /**
     * Convert Kelvin to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromKelvin(float $temperature): float
    {
        return $temperature;
    }

}
