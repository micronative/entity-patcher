<?php

namespace Micronative\EntityPatcher;

use Doctrine\Common\Annotations\AnnotationReader;
use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Exception\PatcherException;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use Micronative\EntityPatcher\Transformers\ArrayToObjectTransformer;
use Micronative\EntityPatcher\Transformers\CollectionToArrayTransformer;
use Micronative\EntityPatcher\Transformers\ObjectToArrayTransformer;

class Patcher implements PatcherInterface
{
    const KEYED_BY_COLUMN = 'column';
    const KEYED_BY_PROPERTY = 'property';
    private AnnotationReader $annotationReader;
    private ReflectionReader $reflectionReader;

    public function __construct(AnnotationReader $annotationReader = null, ReflectionReader $reflectionReader = null)
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->reflectionReader = $reflectionReader ?? new ReflectionReader();
    }

    /**
     * Create new entity with provided data
     *
     * @param string $classname
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return object
     * @throws PatcherException
     */
    public function create(string $classname, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): object
    {
        try {
            $transformer = new ArrayToObjectTransformer($this->annotationReader, $this->reflectionReader);
            return $transformer->transform($classname, $data, $keyedBy);
        } catch (ObjectFactoryException|DataException|\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA . $throwable->getMessage(), 0, $throwable);
        }
    }

    /**
     * Patch an entity with provided data
     *
     * @param object $entity
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return void
     * @throws PatcherException
     */
    public function patch(object $entity, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): void
    {
        try {
            $transformer = new ArrayToObjectTransformer($this->annotationReader, $this->reflectionReader);
            $transformer->patch($entity, $data, $keyedBy);
        } catch (ObjectFactoryException|DataException|\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA . $throwable->getMessage(), 0, $throwable);
        }
    }

    /**
     * Serialise an entity to array
     *
     * @param object $entity
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     * @throws PatcherException
     */
    public function serialise(object $entity, string $keyedBy = self::KEYED_BY_PROPERTY): array
    {
        try {
            $transformer = new ObjectToArrayTransformer($this->annotationReader, $this->reflectionReader);
            return $transformer->transform($entity, $keyedBy);
        } catch (\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA . $throwable->getMessage(), 0, $throwable);
        }

    }

    /**
     * Serialise a collection of entities to array
     *
     * @param array $entities
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     * @throws PatcherException
     */
    public function serialiseCollection(array $entities, string $keyedBy = self::KEYED_BY_PROPERTY): array
    {
        try {
            $transformer = new CollectionToArrayTransformer($this->annotationReader, $this->reflectionReader);
            $array = $transformer->transform($entities, $keyedBy);
            return $array == null ? [] : $array;
        } catch (\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA . $throwable->getMessage(), 0, $throwable);
        }
    }
}
