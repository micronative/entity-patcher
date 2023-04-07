<?php

namespace Tests\Transformers;

use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Patcher;
use Micronative\EntityPatcher\Reflection\ReflectionReader;
use Micronative\EntityPatcher\Transformers\ArrayToCollectionTransformer;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Tests\Entity\Company;
use Tests\Entity\User;

class ArrayToCollectionTransformerTest extends TestCase
{
    private ArrayToCollectionTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new ArrayToCollectionTransformer();
        parent::setUp();
    }


    /**
     * @dataProvider getData()
     * @return void
     * @throws DataException
     * @throws ObjectFactoryException
     */
    public function testtransformCollection(array $data)
    {
        $company = new Company();
        $property = (new ReflectionReader())->getProperty($company, 'users');
        $this->assertInstanceOf(ReflectionProperty::class, $property);
        $collection = $this->transformer->transform($property, User::class, $data, Patcher::KEYED_BY_PROPERTY);
        $this->assertIsArray($collection);
        $user = $collection[0];
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Ken', $user->getFirstName());
    }

    public function getData()
    {
        return [
            [
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
            ]
        ];
    }
}