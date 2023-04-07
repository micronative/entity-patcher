<?php

namespace Micronative\EntityPatcher\Reflection;

use ReflectionClass;

class Reflection
{
    /**
     * @param object $object
     * @return ReflectionClass
     */
    public function reflect(object $object): ReflectionClass
    {
        return new ReflectionClass(get_class($object));
    }
}
