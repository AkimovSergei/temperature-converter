<?php

namespace Sa\TemperatureConverter\Validation;

abstract class ValidationRule
{

    public abstract function passes($value);

}