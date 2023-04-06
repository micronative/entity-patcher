<?php

namespace Micronative\EntityPatcher;

use Micronative\EntityPatcher\Exception\ReflectionException;
use ReflectionProperty;

class EntityReader
{
    /**
     * @param object $entity
     * @param string $propertyName
     * @return false|ReflectionProperty
     * @throws ReflectionException
     */
    public function getProperty(object $entity, string $propertyName)
    {
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            if ($property->name == $propertyName) {
                return $property;
            }
        }

        return false;
    }

    /**
     * Get property value
     *
     * @param object $entity
     * @param ReflectionProperty|null $property
     * @return mixed
     */
    public function getPropertyValue(object $entity, ReflectionProperty $property)
    {
        $property->setAccessible(true);

        return $property->getValue($entity);
    }
}