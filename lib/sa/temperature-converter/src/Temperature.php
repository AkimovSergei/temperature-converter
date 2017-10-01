<?php

namespace Sa\TemperatureConverter;

use Sa\TemperatureConverter\Exceptions\InvalidArgumentException;
use Sa\TemperatureConverter\Units\Celsius;
use Sa\TemperatureConverter\Units\Fahrenheit;
use Sa\TemperatureConverter\Units\Kelvin;

/**
 * Class Temperature
 *
 * @package Sa\TemperatureConverter
 */
class Temperature
{

    /**
     * Scales list
     *
     * @var array
     */
    protected static $scales = [
        'C' => Celsius::class,
        'F' => Fahrenheit::class,
        'K' => Kelvin::class,
        // ...
    ];

    /**
     * Temperature
     *
     * @var float
     */
    protected $temperature;

    /**
     * Unit
     *
     * @var AbstractUnit
     */
    protected $unit;

    /**
     * Validation errors
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Temperature constructor.
     *
     * @param $temperature
     * @param $unit
     * @throws InvalidArgumentException
     */
    public function __construct(float $temperature, $unit)
    {
        $this->temperature = $temperature;
        $this->unit = $this->handleUnit($unit);
    }

    /**
     * Handle unit
     *
     * @param $unit
     * @return AbstractUnit
     * @throws InvalidArgumentException
     */
    public function handleUnit($unit): AbstractUnit
    {
        if (!$unit instanceof AbstractUnit && !is_string($unit)) {
            throw new InvalidArgumentException("{$unit} must be an object of type UnitInterface or a string");
        }

        if (is_string($unit)) {
            if (!isset(static::$scales[strtoupper($unit)])) {
                throw new InvalidArgumentException("{$unit} must be an object of type UnitInterface or a string");
            }

            $unit = new static::$scales[strtoupper($unit)];
        }

        return $unit;
    }

    /**
     * @param $unit
     * @return Temperature
     * @throws InvalidArgumentException
     */
    public function convertTo($unit): Temperature
    {
        $unit = $this->handleUnit($unit);

        return $unit->fromTemperature($this, $unit);
    }

    /**
     * @return mixed
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @return AbstractUnit
     */
    public function getUnit(): AbstractUnit
    {
        return $this->unit;
    }

    /**
     * Get formatted temperature
     *
     * @return string
     */
    public function getFormattedTemperature(): string
    {
        return round($this->temperature, 1) . $this->unit->getSymbolPrint();
    }

    /**
     * Object to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'temperature' => $this->temperature,
            'unit' => $this->unit->toArray(),
            'formatted' => $this->getFormattedTemperature(),
        ];
    }

    /**
     * Object to json
     *
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512): string
    {
        return json_encode($this->toArray(), $options, $depth);
    }

    /**
     * Validate
     *
     * @return bool
     */
    public function isValid()
    {
        $rules = $this->getUnit()->getRules();

        if (isset($rules['temperature'])) {
            foreach ($rules['temperature'] as $rule) {
                if (!$rule->passes($this->temperature)) {
                    $this->errors['temperature'] = [$rule->getMessage()];
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
