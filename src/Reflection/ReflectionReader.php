<?php

namespace Micronative\EntityPatcher\Reflection;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappingAttribute;
use Micronative\EntityPatcher\Exception\ReflectionException;
use Micronative\EntityPatcher\Patcher;
use ReflectionProperty;

class ReflectionReader
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
        if ($property->isInitialized($entity)) {
            $property->setAccessible(true);
            return $property->getValue($entity);
        }

        return null;
    }

    /**
     * Set property value
     *
     * @param object $entity
     * @param ReflectionProperty $property
     * @param mixed|null $value
     * @return void
     */
    public function setPropertyValue(object $entity, ReflectionProperty $property, $value = null)
    {
        $property->setAccessible(true);
        $property->setValue($entity, $value);
    }

    /**
     * @param ReflectionProperty $property
     * @param MappingAttribute $annotation
     * @param string $keyedBy
     * @return string|null
     */
    public function getKey(ReflectionProperty $property, MappingAttribute $annotation, string $keyedBy): string
    {
        if ($annotation instanceof Column) {
            switch ($keyedBy) {
                case Patcher::KEYED_BY_COLUMN:
                    return $annotation->name;
                case Patcher::KEYED_BY_PROPERTY:
                default:
                    return $property->getName();
            }
        }

        return $property->getName();
    }

    /**
     * @param object $entity
     * @return ReflectionProperty[]
     * @throws ReflectionException
     */
    public function getProperties(object $entity): array
    {
        $reflectionClass = (new Reflection())->reflect(get_class($entity));
        return $reflectionClass->getProperties();
    }
}