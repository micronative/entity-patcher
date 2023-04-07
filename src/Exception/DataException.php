<?php

namespace Micronative\EntityPatcher\Exception;

class DataException extends \Exception
{
    const ERROR_INPUT_DATA = 'The property "%s" is an array. Please check input data.';
}