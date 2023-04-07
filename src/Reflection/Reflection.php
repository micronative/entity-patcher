<?php

namespace Micronative\EntityPatcher\Reflection;

use Micronative\EntityPatcher\Exception\ReflectionException;
use ReflectionClass;

class Reflection
{
    /**
     * @param object|string $classname
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function reflect($classname): ReflectionClass
    {
        if (is_object($classname)) {
            $classname = get_class($classname);
        }

        try {
            $reflectionClass = new ReflectionClass($classname);
        } catch (\Throwable $throwable) {
            throw new ReflectionException(ReflectionException::ERROR_FAILED_TO_CREATE_REFLECT_CLASS . $throwable->getMessage());
        }

        return $reflectionClass;
    }
}
