<?php

namespace Sa\TemperatureConverter\Units;

use Sa\TemperatureConverter\AbstractUnit;
use Sa\TemperatureConverter\Validation\RuleMinOrEquals;

/**
 * Class Celsius
 *
 * @package Sa\TemperatureConverter\Units
 */
class Celsius extends AbstractUnit
{

    /**
     * Celsius constructor.
     */
    public function __construct()
    {
        parent::__construct("C");

        $this->rules = [
            'temperature' => [
                new RuleMinOrEquals(-273.15),
            ],
        ];

        $this->errors = [
            'temperature' => [
                'Temperature is too small.'
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
        return $temperature;
    }

    /**
     * Convert Fahrenheit to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromFahrenheit(float $temperature): float
    {
        return ($temperature - 32) / 1.8;
    }

    /**
     * Convert Kelvin to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromKelvin(float $temperature): float
    {
        return $temperature - 273.15;
    }

}
