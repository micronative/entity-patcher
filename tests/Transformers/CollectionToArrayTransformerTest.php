<?php

namespace Tests\Transformers;

use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Transformers\CollectionToArrayTransformer;
use PHPUnit\Framework\TestCase;
use Tests\Entity\Company;

class CollectionToArrayTransformerTest extends TestCase
{
    private CollectionToArrayTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new CollectionToArrayTransformer();
        parent::setUp();
    }

    public function testTransform()
    {
        $company = new Company();
        $company
            ->setId(1)
            ->setName('Ken');
        $array = $this->transformer->transform([$company, $company], Patcher::KEYED_BY_PROPERTY);
        $this->assertIsArray($array);
        $this->assertEquals([
            ['id' => 1, 'name' => 'Ken'],
            ['id' => 1, 'name' => 'Ken'],
        ], $array);
    }
}
