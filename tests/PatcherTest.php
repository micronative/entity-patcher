<?php

namespace Tests;

use Micronative\EntityPatcher\Exception\DataException;
use Micronative\EntityPatcher\Exception\ObjectFactoryException;
use Micronative\EntityPatcher\Exception\PatcherException;
use Micronative\EntityPatcher\Patcher;
use PHPUnit\Framework\TestCase;
use Tests\Entity\Company;
use Tests\Entity\Profile;
use Tests\Entity\Role;
use Tests\Entity\User;

class PatcherTest extends TestCase
{
    private Patcher $patcher;

    protected function setUp(): void
    {
        $this->patcher = new Patcher();
        parent::setUp();
    }

    /**
     * @dataProvider getValidData
     * @param array $data
     * @return void
     * @throws DataException|ObjectFactoryException|PatcherException
     */
    public function testCreate(array $data)
    {
        /** @var Company $company */
        $company = $this->patcher->create(Company::class, $data);
        $this->assertCompany($company);
    }

    /**
     * @dataProvider getInvalidData
     * @param array $data
     * @return void
     * @throws DataException|ObjectFactoryException|PatcherException
     */
    public function testCreateThrowsException(array $data)
    {
        $this->expectException(DataException::class);
        $this->expectExceptionMessage('The property "users" is an array. Please check input data.');
        $this->patcher->create(Company::class, $data);
    }

    /**
     * @dataProvider getValidData
     * @param array $data
     * @return void
     * @throws DataException|ObjectFactoryException|PatcherException
     */
    public function testPatch(array $data)
    {
        $company = new Company();
        $this->patcher->patch($company, $data);
        $this->assertCompany($company);
    }

    /**
     * @dataProvider getInvalidData
     * @param array $data
     * @return void
     * @throws DataException|ObjectFactoryException|PatcherException
     */
    public function testPatchThrowsException(array $data)
    {
        $this->expectException(DataException::class);
        $this->expectExceptionMessage('The property "users" is an array. Please check input data.');
        $this->patcher->create(Company::class, $data);
    }

    /**
     * @dataProvider getValidData
     * @param array $data
     * @return void
     * @throws DataException|ObjectFactoryException|PatcherException
     */
    public function testSerialise(array $data)
    {
        $company = $this->patcher->create(Company::class, $data);
        $array = $this->patcher->serialise($company);
        $this->assertEquals($data, $array);
    }

    private function assertCompany(Company $company)
    {
        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals(1, $company->getId());
        $this->assertEquals('Micronative', $company->getName());
        $this->assertIsArray($company->getUsers());
        $this->assertUser($company->getUsers()[0]);
    }

    private function assertUser(User $user)
    {
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(100, $user->getId());
        $this->assertEquals('Ken', $user->getFirstName());
        $this->assertEquals('Ngo', $user->getLastName());
        $this->assertEquals('ken.ngo@micronative.com', $user->getEmail());
        $this->assertIsArray($user->getRoles());
        $this->assertRole($user->getRoles()[0]);
        $this->assertIsArray($user->getProfiles());
        $this->assertProfile($user->getProfiles()[0]);
    }

    private function assertRole(Role $role)
    {
        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals(1000, $role->getId());
        $this->assertEquals('Admin', $role->getType());
    }

    private function assertProfile(Profile $profile)
    {
        $this->assertInstanceOf(Profile::class, $profile);
        $this->assertEquals(10000, $profile->getId());
        $this->assertEquals('Admin Profile', $profile->getDescription());
    }

    public function getValidData(): array
    {
        return
            [
                [
                    [
                        'id' => 1,
                        'name' => 'Micronative',
                        'users' => [
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
                ]
            ];
    }

    public function getInvalidData(): array
    {
        return
            [
                [
                    [
                        'id' => 1,
                        'name' => 'Micronative',
                        'users' => [
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
                            ]
                        ]
                    ]
                ]
            ];
    }
}
