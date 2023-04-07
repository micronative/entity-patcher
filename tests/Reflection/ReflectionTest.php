<?php

namespace Tests\Reflection;

use Micronative\EntityPatcher\Reflection\Reflection;
use PHPUnit\Framework\TestCase;
use Tests\Entity\Company;

class ReflectionTest extends TestCase
{
    public function testReflect()
    {
        $company = new Company();
        $reflection = (new Reflection())->reflect($company);
        $this->assertInstanceOf(\ReflectionClass::class, $reflection);
    }
}
