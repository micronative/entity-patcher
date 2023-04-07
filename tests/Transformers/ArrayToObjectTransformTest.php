<?php

namespace Tests\Transformers;

use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Transformers\ArrayToCollectionTransformer;
use Micronative\EntityPatcher\Transformers\ArrayToObjectTransformer;
use PHPUnit\Framework\TestCase;
use Tests\Entity\User;

class ArrayToObjectTransformTest extends TestCase
{
    private ArrayToObjectTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ArrayToObjectTransformer();
        parent::setUp();
    }

    /**
     * @dataProvider getData()
     * @param array $data
     * @return void
     * @throws DataException
     * @throws ObjectFactoryException
     */
    public function testTransform(array $data)
    {
        $object = $this->transformer->transform(User::class, $data, Patcher::KEYED_BY_PROPERTY);
        $this->assertInstanceOf(User::class, $object);
        $this->assertEquals($data['id'], $object->getId());
        $this->assertEquals($data['firstName'], $object->getFirstName());
    }

    /**
     * @dataProvider getData()
     * @param array $data
     * @return void
     * @throws DataException
     * @throws ObjectFactoryException
     */
    public function testPatch(array $data)
    {
        $user = new User();
        $object = $this->transformer->patch($user, $data, Patcher::KEYED_BY_PROPERTY);
        $this->assertInstanceOf(User::class, $object);
        $this->assertEquals($data['id'], $object->getId());
        $this->assertEquals($data['firstName'], $object->getFirstName());
    }

    public function getData(): array
    {
        return [
            [
                [
                    'id' => 100,
                    'firstName' => 'Ken',
                    'lastName' => 'Ngo',
                    'email' => 'ken.ngo@micronative.com',
                    'roles' => [
                        [
                            'id' => 1000,
                            'type' => 'Admin'
                        ],
                        [
                            'id' => 1100,
                            'type' => 'Manager'
                        ],
                    ],
                    'profiles' => [
                        [
                            'id' => 10000,
                            'description' => 'Admin Profile'
                        ],
                        [
                            'id' => 10001,
                            'description' => 'Manager Profile'
                        ],
                    ]
                ],
                [
                    'id' => 200,
                    'firstName' => 'May',
                    'lastName' => 'Ngo',
                    'email' => 'may.ngo@micronative.com',
                    'roles' => [
                        [
                            'id' => 1100,
                            'type' => 'Student'
                        ],
                        [
                            'id' => 1200,
                            'type' => 'Daughter'
                        ],
                    ],
                    'profiles' => [
                        [
                            'id' => 10003,
                            'description' => 'Student Profile'
                        ],
                        [
                            'id' => 10004,
                            'description' => 'Daughter Profile'
                        ],
                    ]
                ]
            ]
        ];
    }
}