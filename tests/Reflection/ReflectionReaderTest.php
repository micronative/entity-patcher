<?php

namespace Tests\Reflection;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Tests\Entity\Company;

class ReflectionReaderTest extends TestCase
{
    private ReflectionReader $reflectionReader;

    protected function setUp(): void
    {
        $this->reflectionReader = new ReflectionReader();
        parent::setUp();
    }

    public function testGetProperties()
    {
        $company = new Company();
        $properties = $this->reflectionReader->getProperties($company);
        $this->assertIsArray($properties);
        $this->assertInstanceOf(ReflectionProperty::class, $properties[0]);
    }

    public function testGetProperty()
    {
        $company = new Company();
        $property = $this->reflectionReader->getProperty($company, 'id');
        $this->assertInstanceOf(ReflectionProperty::class, $property);
    }

    public function testGetPropertyValue()
    {
        $company = new Company();
        $company->setId(1);
        $property = $this->reflectionReader->getProperty($company, 'id');
        $value = $this->reflectionReader->getPropertyValue($company, $property);
        $this->assertEquals(1, $value);
    }

    public function testSetPropertyValue()
    {
        $company = new Company();
        $company->setId(1);
        $property = $this->reflectionReader->getProperty($company, 'id');
        $this->reflectionReader->setPropertyValue($company, $property, 2);
        $this->assertEquals(2, $company->getId());
    }

    public function testGetKey()
    {
        $company = new Company();
        $company->setId(1);
        $property = $this->reflectionReader->getProperty($company, 'id');
        $annotation = new Column('company_id');
        $key = $this->reflectionReader->getKey($property, $annotation, Patcher::KEYED_BY_COLUMN);
        $this->assertEquals('company_id', $key);

        $key = $this->reflectionReader->getKey($property, $annotation, Patcher::KEYED_BY_PROPERTY);
        $this->assertEquals($property->getName(), $key);

        $annotation = new OneToMany();
        $key = $this->reflectionReader->getKey($property, $annotation, Patcher::KEYED_BY_PROPERTY);
        $this->assertEquals($property->getName(), $key);
    }
}
