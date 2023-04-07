<?php

namespace Micronative\EntityPatcher\Reflection;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappingAttribute;
use Micronative\EntityPatcher\Patcher;
use ReflectionProperty;

class ReflectionReader
{
    /**
     * @param object $entity
     * @return ReflectionProperty[]
     */
    public function getProperties(object $entity): array
    {
        $reflectionClass = (new Reflection())->reflect($entity);
        return $reflectionClass->getProperties();
    }

    /**
     * @param object $entity
     * @param string $propertyName
     * @return false|ReflectionProperty
     */
    public function getProperty(object $entity, string $propertyName)
    {
        $properties = $this->getProperties($entity);
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
        if ($property->isInitialized($entity)) {
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
}
