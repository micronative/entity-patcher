<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use ReflectionProperty;

class ArrayToCollectionTransformer
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
     * @param ReflectionProperty $property
     * @param string $classname
     * @param array $data
     * @param string $keyedBy
     * @return array|null
     * @throws DataException|ObjectFactoryException
     */
    public function transformCollection(
        ReflectionProperty $property,
        string             $classname,
        array              $data,
        string             $keyedBy
    ): ?array
    {
        $array = [];
        foreach ($data as $key => $item) {
            if (!is_array($item) || empty($item)) {
                throw new DataException(sprintf(DataException::ERROR_INPUT_DATA, $property->getName()));
            }
            $transformer = new ArrayToObjectTransformer($this->annotationReader, $this->reflectionReader);
            $array[$key] = $transformer->transform($classname, $item, $keyedBy);
        }

        if (empty($array)) {
            return null;
        }

        return $array;
    }
}