<?php

namespace Micronative\EntityPatcher;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Micronative\EntityPatcher\Exception\ReflectionException;
use Micronative\EntityPatcher\Transformers\EntityTransformer;
use ReflectionProperty;

class Patcher implements PatcherInterface
{
    const KEYED_BY_COLUMN = 'column';
    const KEYED_BY_PROPERTY = 'property';
    private AnnotationReader $annotationReader;
    private EntityReader $entityReader;
    private EntityTransformer $entityTransformer;

    public function __construct(AnnotationReader $annotationReader = null, EntityReader $entityReader = null)
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->entityReader = $entityReader ?? new EntityReader();
        $this->entityTransformer = new EntityTransformer($this->annotationReader, $this->entityReader);
    }

    /**
     * Patch an entity with provided data
     *
     * @param object $entity
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return void
     */
    public function patch(object $entity, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): void
    {
        // TODO: Implement patch() method.
    }

    /**
     * Create new entity with provided data
     *
     * @param string $classname
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return object
     */
    public function create(string $classname, array $data, string $keyedBy = self::KEYED_BY_PROPERTY): object
    {
        // TODO: Implement create() method.
    }

    /**
     * Serialise an entity to array
     *
     * @param object $entity
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     * @throws ReflectionException
     */
    public function serialise(object $entity, string $keyedBy = self::KEYED_BY_PROPERTY): array
    {
        return $this->entityTransformer->transform($entity, $keyedBy);
    }

    /**
     * Serialise a collection of entities to array
     *
     * @param array $entities
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     * @throws ReflectionException
     */
    public function serialiseCollection(array $entities, string $keyedBy): array
    {
        $array = [];
        foreach ($entities as $key => $entity) {
            $array[$key] = $this->serialise($entity, $keyedBy);
        }

        return $array;
    }
}