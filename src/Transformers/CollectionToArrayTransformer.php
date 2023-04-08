<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Micronative\EntityPatcher\Reflection\ReflectionReader;

class CollectionToArrayTransformer
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
     * @param array|null $entities
     * @param string $keyedBy
     * @return array|null
     */
    public function transform(?array $entities, string $keyedBy): ?array
    {
        if (empty($entities)) {
            return null;
        }

        $array = [];
        foreach ($entities as $key => $entity) {
            $classname = get_class($entity);
            if (!in_array($classname, $this->mappingTree)) {
                $transformer = new ObjectToArrayTransformer(
                    $this->annotationReader,
                    $this->reflectionReader,
                    $this->mappingTree
                );
                $array[$key] = $transformer->transform($entity, $keyedBy);
            }
        }

        if (empty($array)) {
            return null;
        }

        return $array;
    }
}
