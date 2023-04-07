<?php

namespace Tests\Transformers;

use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Transformers\ArrayToObjectTransformer;
use Micronative\EntityPatcher\Transformers\ObjectToArrayTransformer;
use PHPUnit\Framework\TestCase;
use Tests\Entity\User;

class ObjectToArrayTransformTest extends TestCase
{
    private ObjectToArrayTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ObjectToArrayTransformer();
        parent::setUp();
    }

    /**
     * @dataProvider getData
     * @param array $data
     * @return void
     * @throws DataException
     * @throws ObjectFactoryException
     */
    public function testTransform(array $data)
    {
        $object = (new ArrayToObjectTransformer())->transform(User::class, $data, Patcher::KEYED_BY_PROPERTY);
        $arrayByProperty = $this->transformer->transform($object, Patcher::KEYED_BY_PROPERTY);
        $this->assertIsArray($arrayByProperty);
        $this->assertEquals($data, $arrayByProperty);

        $arrayByColumn = $this->transformer->transform($object, Patcher::KEYED_BY_COLUMN);
        $this->assertIsArray($arrayByColumn);
        $this->assertEquals($data['id'], $arrayByColumn['user_id']);
        $this->assertEquals($data['firstName'], $arrayByColumn['user_first_name']);
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