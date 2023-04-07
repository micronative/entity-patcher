<?php

namespace Micronative\EntityPatcher\Factory;

use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Throwable;

class ObjectFactory
{
    /**
     * @param string $class
     * @return mixed
     * @throws ObjectFactoryException
     */
    public function object(string $class)
    {
        try {
            $object = new $class();
        } catch (Throwable $exception) {
            throw new ObjectFactoryException(ObjectFactoryException::ERROR_INVALID_CLASS_NAME . $class);
        }

        return $object;
    }
}
