<?php

namespace Micronative\EntityPatcher\Transformers;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\MappingAttribute;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Exception\ReflectionException;
use Micronative\EntityPatcher\Factory\ObjectFactory;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use ReflectionProperty;

class ArrayToObjectTransformer
{
    private AnnotationReader $annotationReader;
    private ReflectionReader $reflectionReader;
    private ObjectFactory $objectFactory;
    private array $mappingTree;

    /**
     * @param AnnotationReader|null $annotationReader
     * @param ReflectionReader|null $reflectionReader
     */
    public function __construct(
        AnnotationReader $annotationReader = null,
        ReflectionReader $reflectionReader = null,
        ObjectFactory    $objectFactory = null
    )
    {
        $this->annotationReader = $annotationReader ?? new AnnotationReader();
        $this->reflectionReader = $reflectionReader ?? new ReflectionReader();
        $this->objectFactory = $objectFactory ?? new ObjectFactory();
    }

    /**
     * @param string $classname
     * @param array $data
     * @param string $keyedBy
     * @return object
     * @throws ReflectionException|ObjectFactoryException|DataException
     */
    public function transform(string $classname, array $data, string $keyedBy): object
    {
        $this->mappingTree[] = $classname;
        $entity = $this->objectFactory->object($classname);
        $this->patchObject($entity, $data, $keyedBy);

        return $entity;
    }

    /**
     * @param object $entity
     * @param array $data
     * @param string $keyedBy
     * @return object
     * @throws DataException|ObjectFactoryException|ReflectionException
     */
    public function patch(object $entity, array $data, string $keyedBy): object
    {
        $this->mappingTree[] = get_class($entity);
        $this->patchObject($entity, $data, $keyedBy);

        return $entity;
    }

    /**
     * @param object $entity
     * @param array $data
     * @param string $keyedBy
     * @return void
     * @throws DataException
     * @throws ObjectFactoryException
     * @throws ReflectionException
     */
    private function patchObject(object $entity, array $data, string $keyedBy)
    {
        $properties = $this->reflectionReader->getProperties($entity);
        foreach ($properties as $property) {
            $annotations = $this->annotationReader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof MappingAttribute) {
                    $key = $this->reflectionReader->getKey($property, $annotation, $keyedBy);
                    if (isset($data[$key])) {
                        $value = $this->getValue($property, $annotation, $keyedBy, $data[$key]);
                        if ($value !== null) {
                            $this->reflectionReader->setPropertyValue($entity, $property, $value);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param ReflectionProperty $property
     * @param MappingAttribute $annotation
     * @param string $keyedBy
     * @param mixed $data
     * @return mixed
     * @throws DataException|ObjectFactoryException|ReflectionException
     */
    private function getValue(ReflectionProperty $property, MappingAttribute $annotation, string $keyedBy, $data)
    {
        switch (true) {
            case $annotation instanceof Column:
                return $data;
            case $annotation instanceof OneToOne:
            case $annotation instanceof ManyToOne:
                if (!in_array($annotation->targetEntity, $this->mappingTree)) {
                    return $this->transform($annotation->targetEntity, $data, $keyedBy);
                }

                return null;
            case $annotation instanceof OneToMany:
            case $annotation instanceof ManyToMany:
                if (!in_array($annotation->targetEntity, $this->mappingTree)) {
                    return $this->transformCollection($property, $annotation->targetEntity, $data, $keyedBy);
                }

                return null;
        }
    }

    /**
     * @param ReflectionProperty $property
     * @param string $classname
     * @param array $data
     * @param string $keyedBy
     * @return array
     * @throws DataException|ObjectFactoryException|ReflectionException
     */
    private function transformCollection(ReflectionProperty $property, string $classname, array $data, string $keyedBy): array
    {
        $array = [];
        foreach ($data as $key => $item) {
            if (!is_array($item) || empty($item)) {
                throw new DataException(sprintf(DataException::ERROR_INPUT_DATA, $property->getName()));
            }
            $transformer = new self();
            $array[$key] = $transformer->transform($classname, $item, $keyedBy);
        }

        return $array;
    }
}
