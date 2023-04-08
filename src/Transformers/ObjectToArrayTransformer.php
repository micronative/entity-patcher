<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappingAttribute;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use ReflectionProperty;

class ObjectToArrayTransformer
{
    private AnnotationReader $annotationReader;
    private ReflectionReader $reflectionReader;
    private array $mappingTree;

    /**
     * @param AnnotationReader|null $annotationReader
     * @param ReflectionReader|null $reflectionReader
     * @param array $mappingTree
     */
    public function __construct(
        AnnotationReader $annotationReader = null,
        ReflectionReader $reflectionReader = null,
        array            $mappingTree = []
    )
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->reflectionReader = $reflectionReader ?? new ReflectionReader();
        $this->mappingTree = $mappingTree;
    }

    /**
     * @param ?object $entity
     * @param string $keyedBy
     * @return array|null
     */
    public function transform(?object $entity, string $keyedBy): ?array
    {
        if ($entity == null) {
            return null;
        }

        $this->mappingTree[] = get_class($entity);
        $properties = $this->reflectionReader->getProperties($entity);
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
     * @return array|null
     */
    private function transformCollection(?array $entities, string $keyedBy): ?array
    {
        $transformer = new CollectionToArrayTransformer(
            $this->annotationReader,
            $this->reflectionReader,
            $this->mappingTree
        );
        return $transformer->transform($entities, $keyedBy);
    }

    /**
     * @param object $entity
     * @param ReflectionProperty $property
     * @param MappingAttribute $annotation
     * @param string $keyedBy
     * @return array|mixed|null
     */
    private function getValue(
        object             $entity,
        ReflectionProperty $property,
        MappingAttribute   $annotation,
        string             $keyedBy
    )
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
                    return $this->transformCollection(
                        $this->reflectionReader->getPropertyValue($entity, $property),
                        $keyedBy
                    );
                }

                return null;
        }
    }
}
