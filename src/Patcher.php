<?php

namespace Micronative\EntityPatcher;

use Doctrine\Common\Annotations\AnnotationReader;
use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Exception\PatcherException;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use Micronative\EntityPatcher\Transformers\ArrayToObjectTransformer;
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
     * @throws ObjectFactoryException|DataException|PatcherException
     */
    public function create(string $classname, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): object
    {
        try {
            $transformer = new ArrayToObjectTransformer($this->annotationReader, $this->reflectionReader);
            return $transformer->transform($classname, $data, $keyedBy);
        } catch (ObjectFactoryException|DataException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA, 0, $throwable);
        }
    }

    /**
     * Patch an entity with provided data
     *
     * @param object $entity
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return void
     * @throws ObjectFactoryException|DataException|PatcherException
     */
    public function patch(object $entity, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): void
    {
        try {
            $transformer = new ArrayToObjectTransformer($this->annotationReader, $this->reflectionReader);
            $transformer->patch($entity, $data, $keyedBy);
        } catch (ObjectFactoryException|DataException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA, 0, $throwable);
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
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA, 0, $throwable);
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
            $array = [];
            foreach ($entities as $key => $entity) {
                $transformer = new ObjectToArrayTransformer($this->annotationReader, $this->reflectionReader);
                $value = $transformer->transform($entity, $keyedBy);
                if ($value !== null) {
                    $array[$key] = $value;
                }
            }

            return $array;
        } catch (\Throwable $throwable) {
            throw new PatcherException(PatcherException::ERROR_INPUT_DATA, 0, $throwable);
        }

    }
}
