<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Micronative\EntityPatcher\EntityReader;
use Micronative\EntityPatcher\Exception\ReflectionException;
use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Reflection;

class EntityTransformer
{
    private AnnotationReader $annotationReader;
    private EntityReader $entityReader;

    /**
     * @param AnnotationReader|null $annotationReader
     * @param EntityReader|null $entityReader
     */
    public function __construct(AnnotationReader $annotationReader = null, EntityReader $entityReader = null)
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->entityReader = $entityReader ?? new EntityReader();
    }

    /**
     * @param object $entity
     * @param string $keyedBy
     * @return array
     * @throws ReflectionException
     */
    public function transform(object $entity, string $keyedBy): array
    {
        switch ($keyedBy) {
            case Patcher::KEYED_BY_COLUMN:
                return $this->arrayByColumn($entity);
            case Patcher::KEYED_BY_PROPERTY:
            default:
                return $this->arrayByProperty($entity);
        }
    }

    /**
     * @param object $entity
     * @return array
     * @throws ReflectionException
     */
    private function arrayByProperty(object $entity): array
    {
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();
        $array = [];
        foreach ($properties as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, Column::class);
            if ($annotation instanceof Column) {
                $array[$property->getName()] = $this->entityReader->getPropertyValue($entity, $property);
            }
        }

        return $array;
    }

    /**
     * @param object $entity
     * @return array
     * @throws ReflectionException
     */
    private function arrayByColumn(object $entity): array
    {
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();
        $array = [];
        foreach ($properties as $property) {
            $annotation = $this->annotationReader->getPropertyAnnotation($property, Column::class);
            if ($annotation instanceof Column) {
                $array[$annotation->name] = $this->entityReader->getPropertyValue($entity, $property);
            }
        }

        return $array;
    }
}