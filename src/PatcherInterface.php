<?php

namespace Micronative\EntityPatcher;

interface PatcherInterface
{
    /**
     * Patch an entity with provided data
     *
     * @param object $entity
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return void
     */
    public function patch(object $entity, array $data, string $keyedBy): void;

    /**
     * Create new entity with provided data
     *
     * @param string $classname
     * @param array $data
     * @param string $keyedBy data keyed by column name or property name
     * @return object
     */
    public function create(string $classname, array $data, string $keyedBy): object;

    /**
     * Serialise an entity to array
     *
     * @param object $entity
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     */
    public function serialise(object $entity, string $keyedBy): array;

    /**
     * Serialise a collection of entities to array
     *
     * @param array $entities
     * @param string $keyedBy data keyed by column name or property name
     * @return array
     */
    public function serialiseCollection(array $entities, string $keyedBy): array;
}
