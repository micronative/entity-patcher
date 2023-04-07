<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Micronative\EntityPatcher\Reflection\ReflectionReader;

class CollectionToArrayTransformer
{
    private AnnotationReader $annotationReader;
    private ReflectionReader $reflectionReader;

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
     * @param array|null $entities
     * @param string $keyedBy
     * @return array|null
     */
    public function transformCollection(?array $entities, string $keyedBy): ?array
    {
        if (empty($entities)) {
            return null;
        }

        $array = [];
        foreach ($entities as $key => $entity) {
            $transformer = new ObjectToArrayTransformer($this->annotationReader, $this->reflectionReader);
            $array[$key] = $transformer->transform($entity, $keyedBy);
        }

        if (empty($array)) {
            return null;
        }

        return $array;
    }
}