<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappingAttribute;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Micronative\EntityPatcher\Exception\ReflectionException;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use Micronative\EntityPatcher\Reflection\Reflection;
use ReflectionProperty;

class ObjectToArrayTransformer
{
    private AnnotationReader $annotationReader;
    private ReflectionReader $reflectionReader;
    private array $mappingTree;

    /**
     * @param AnnotationReader|null $annotationReader
     * @param ReflectionReader|null $reflectionReader
     */
    public function __construct(AnnotationReader $annotationReader = null, ReflectionReader $reflectionReader = null)
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->reflectionReader = $reflectionReader ?? new ReflectionReader();
    }

    /**
     * @param object $entity
     * @param string $keyedBy
     * @return array
     * @throws ReflectionException
     */
    public function transform(object $entity, string $keyedBy): array
    {
        $this->mappingTree[] = get_class($entity);
        $reflectionClass = (new Reflection())->reflect($entity);
        $properties = $reflectionClass->getProperties();

        $array = [];
        foreach ($properties as $property) {
            $annotations = $this->annotationReader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof MappingAttribute) {
                    $value = $this->getValue($entity, $property, $annotation, $keyedBy);
                    if ($value !== null) {
                        $array[$this->reflectionReader->getKey($property, $annotation, $keyedBy)] = $value;
                    }
                }
            }
        }

        return $array;
    }

    /**
     * @param array|null $entities
     * @param string $keyedBy
     * @return array
     * @throws ReflectionException
     */
    private function transformCollection(?array $entities, string $keyedBy): array
    {
        if (empty($entities)) {
            return [];
        }

        $array = [];
        foreach ($entities as $key => $entity) {
            $array[$key] = $this->transform($entity, $keyedBy);
        }

        return $array;
    }

    /**
     * @param object $entity
     * @param ReflectionProperty $property
     * @param MappingAttribute $annotation
     * @param string $keyedBy
     * @return array|mixed|null
     * @throws ReflectionException
     */
    private function getValue(object $entity, ReflectionProperty $property, MappingAttribute $annotation, string $keyedBy)
    {
        switch (true) {
            case $annotation instanceof Column:
                return $this->reflectionReader->getPropertyValue($entity, $property);
            case $annotation instanceof OneToOne:
            case $annotation instanceof ManyToOne:
                if (!in_array($annotation->targetEntity, $this->mappingTree)) {
                    return $this->transform($this->reflectionReader->getPropertyValue($entity, $property), $keyedBy);
                }

                return null;
            case $annotation instanceof OneToMany:
            case $annotation instanceof ManyToMany:
                if (!in_array($annotation->targetEntity, $this->mappingTree)) {
                    return $this->transformCollection($this->reflectionReader->getPropertyValue($entity, $property), $keyedBy);
                }

                return null;
        }
    }
}
