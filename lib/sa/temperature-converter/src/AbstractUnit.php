<?php
/**
 * Created by PhpStorm.
 * User: sergeiakimov
 * Date: 10/1/17
 * Time: 10:19 AM
 */

namespace Sa\TemperatureConverter;

use Sa\TemperatureConverter\Exceptions\InvalidArgumentException;

/**
 * Class AbstractUnit
 *
 * @package Sa\TemperatureConverter
 */
abstract class AbstractUnit
{

    /**
     * Symbol
     *
     * @var string
     */
    protected $symbol;

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [];

    /**
     * AbstractUnit constructor.
     *
     * @param $symbol
     */
    public function __construct($symbol)
    {
        $this->symbol = strtoupper($symbol);
    }

    /**
     * Convert from Celsius
     *
     * @param $temperature
     * @return mixed
     */
    public abstract function fromCelsius(float $temperature): float;

    /**
     * Convert from Fahrenheit
     *
     * @param $temperature
     * @return mixed
     */
    public abstract function fromFahrenheit(float $temperature): float;

    /**
     * Convert from Kelvin
     *
     * @param $temperature
     * @return mixed
     */
    public abstract function fromKelvin(float $temperature): float;

    /**
     * Convert from temperature
     *
     * @param Temperature $temperature
     * @param AbstractUnit $unit
     * @return Temperature
     * @throws InvalidArgumentException
     */
    public function fromTemperature(Temperature $temperature, AbstractUnit $unit): Temperature
    {

        $reflect = new \ReflectionClass($temperature->getUnit());

        $method = "from" . $reflect->getShortName();

        if (!method_exists($this, $method)) {
            throw new InvalidArgumentException("Unsupported scale");
        }

        if ($temperature->getUnit()->getSymbol() === $unit->getSymbol()) {
            return $temperature;
        }

        return new Temperature($unit->{$method}($temperature->getTemperature()), $unit);
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Get symbol print
     *
     * @return string
     */
    public function getSymbolPrint(): string
    {
        return "°{$this->getSymbol()}";
    }

    /**
     * Convert object to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'symbol' => $this->symbol,
            'symbol_formatted' => $this->getSymbolPrint(),
        ];
    }

}