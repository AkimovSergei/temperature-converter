<?php

namespace Sa\TemperatureConverter\Units;

use Sa\TemperatureConverter\AbstractUnit;
use Sa\TemperatureConverter\Validation\RuleMinOrEquals;

/**
 * Class Fahrenheit
 *
 * @package Sa\TemperatureConverter\Units
 */
class Fahrenheit extends AbstractUnit
{

    /**
     * Fahrenheit constructor.
     */
    public function __construct()
    {
        parent::__construct("F");

        $this->rules = [
            'temperature' => [
                new RuleMinOrEquals(-459.67),
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
        return $temperature * 1.8 + 32;
    }

    /**
     * Convert Fahrenheit to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromFahrenheit(float $temperature): float
    {
        return $temperature;
    }

    /**
     * Convert Kelvin to Celsius
     *
     * @param $temperature
     * @return float
     */
    public function fromKelvin(float $temperature): float
    {
        return $temperature + 1.8 - 459.7;
    }

}
