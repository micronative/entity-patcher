<?php

namespace Tests\Factory;

use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Factory\ObjectFactory;
use PHPUnit\Framework\TestCase;
use Tests\Entity\Company;

class ObjectFactoryTest extends TestCase
{
    private ObjectFactory $objectFactory;

    protected function setUp(): void
    {
        $this->objectFactory = new ObjectFactory();
        parent::setUp();
    }

    public function testCreate()
    {
        $company = $this->objectFactory->create(Company::class);
        $this->assertInstanceOf(Company::class, $company);
    }

    public function testCreateThrowsException()
    {
        $this->expectException(ObjectFactoryException::class);
        $this->objectFactory->create('NoneExistingClassname');
    }
}
