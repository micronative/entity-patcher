# Entity Patcher
[![Software license][ico-license]](README.md)
[![Build][ico-build-7.4]][link-build]
[![Build][ico-build-8.0]][link-build]
[![Coverage][ico-codecov]][link-codecov]

[ico-license]: https://img.shields.io/github/license/nrk/predis.svg?style=flat-square
[ico-build-7.4]: https://github.com/micronative/entity-patcher/actions/workflows/php-7.4.yml/badge.svg
[ico-build-8.0]: https://github.com/micronative/entity-patcher/actions/workflows/php-8.0.yml/badge.svg
[ico-codecov]: https://codecov.io/gh/micronative/entity-patcher/branch/master/graph/badge.svg

[link-build]: https://github.com/micronative/entity-patcher/actions
[link-codecov]: https://codecov.io/gh/micronative/entity-patcher


Entity Patcher

## Installation
composer.json
<pre>
"require": {
        "micronative/entity-patcher": "^1.0.0"
},
"repositories": [
    { "type": "vcs", "url": "https://github.com/micronative/entity-patcher" }
],
</pre>

Run 
<pre>
composer require micronative/entity-patcher:1.0.0
</pre>

## Samples
### Create
```php
$patcher = new Patcher();
$company = $patcher->create(
    Company::class,
    [
        'id' => 1,
        'name' => 'Micronative',
        'users' => [
            [
                'id' => '100',
                'firstName' => 'Ken',
                'lastName' => 'Ngo',
                'email' => 'ken.ngo@micronative.com',
                'roles' => [
                    [
                        'id' => '1000',
                        'type' => 'Admin'
                    ],
                    [
                        'id' => '1100',
                        'type' => 'Manager'
                    ],
                ],
                'profiles' => [
                    [
                        'id' => '10000',
                        'description' => 'Admin Profile'
                    ],
                    [
                        'id' => '10001',
                        'description' => 'Manager Profile'
                    ],
                ]
            ],
            [
                'id' => '200',
                'firstName' => 'May',
                'lastName' => 'Ngo',
                'email' => 'may.ngo@micronative.com',
                'roles' => [
                    [
                        'id' => '1100',
                        'type' => 'Student'
                    ],
                    [
                        'id' => '1200',
                        'type' => 'Daughter'
                    ],
                ],
                'profiles' => [
                    [
                        'id' => '10003',
                        'description' => 'Student Profile'
                    ],
                    [
                        'id' => '10004',
                        'description' => 'Daughter Profile'
                    ],
                ]
            ]
        ]

    ]);
print_r($company);
# Output

Samples\Entity\Company Object
(
    [id:Samples\Entity\Company:private] => 1
    [name:Samples\Entity\Company:private] => Micronative
    [users:Samples\Entity\Company:private] => Array
        (
            [0] => Tests\Entity\User Object
                (
                    [id:Tests\Entity\User:private] => 100
                    [firstName:Tests\Entity\User:private] => Ken
                    [lastName:Tests\Entity\User:private] => Ngo
                    [email:Tests\Entity\User:private] => ken.ngo@micronative.com
                    [roles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1000
                                    [type:Tests\Entity\Role:private] => Admin
                                )

                            [1] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1100
                                    [type:Tests\Entity\Role:private] => Manager
                                )

                        )

                    [profiles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10000
                                    [description:Tests\Entity\Profile:private] => Admin Profile
                                )

                            [1] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10001
                                    [description:Tests\Entity\Profile:private] => Manager Profile
                                )

                        )

                )

            [1] => Tests\Entity\User Object
                (
                    [id:Tests\Entity\User:private] => 200
                    [firstName:Tests\Entity\User:private] => May
                    [lastName:Tests\Entity\User:private] => Ngo
                    [email:Tests\Entity\User:private] => may.ngo@micronative.com
                    [roles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1100
                                    [type:Tests\Entity\Role:private] => Student
                                )

                            [1] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1200
                                    [type:Tests\Entity\Role:private] => Daughter
                                )

                        )

                    [profiles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10003
                                    [description:Tests\Entity\Profile:private] => Student Profile
                                )

                            [1] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10004
                                    [description:Tests\Entity\Profile:private] => Daughter Profile
                                )

                        )

                )

        )

)
```
@see: [samples/create.php](samples/create.php)

## Patch
```php
$patcher = new Patcher();
$company = new Company();
$patcher->patch(
    $company,
    [
        'id' => 1,
        'name' => 'Micronative',
        'users' => [
            [
                'id' => '100',
                'firstName' => 'Ken',
                'lastName' => 'Ngo',
                'email' => 'ken.ngo@micronative.com',
                'roles' => [
                    [
                        'id' => '1000',
                        'type' => 'Admin'
                    ],
                    [
                        'id' => '1100',
                        'type' => 'Manager'
                    ],
                ],
                'profiles' => [
                    [
                        'id' => '10000',
                        'description' => 'Admin Profile'
                    ],
                    [
                        'id' => '10001',
                        'description' => 'Manager Profile'
                    ],
                ]
            ],
            [
                'id' => '200',
                'firstName' => 'May',
                'lastName' => 'Ngo',
                'email' => 'may.ngo@micronative.com',
                'roles' => [
                    [
                        'id' => '1100',
                        'type' => 'Student'
                    ],
                    [
                        'id' => '1200',
                        'type' => 'Daughter'
                    ],
                ],
                'profiles' => [
                    [
                        'id' => '10003',
                        'description' => 'Student Profile'
                    ],
                    [
                        'id' => '10004',
                        'description' => 'Daughter Profile'
                    ],
                ]
            ]
        ]

    ]);
print_r($company);

# Output
Samples\Entity\Company Object
(
    [id:Samples\Entity\Company:private] => 1
    [name:Samples\Entity\Company:private] => Micronative
    [users:Samples\Entity\Company:private] => Array
        (
            [0] => Tests\Entity\User Object
                (
                    [id:Tests\Entity\User:private] => 100
                    [firstName:Tests\Entity\User:private] => Ken
                    [lastName:Tests\Entity\User:private] => Ngo
                    [email:Tests\Entity\User:private] => ken.ngo@micronative.com
                    [roles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1000
                                    [type:Tests\Entity\Role:private] => Admin
                                )

                            [1] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1100
                                    [type:Tests\Entity\Role:private] => Manager
                                )

                        )

                    [profiles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10000
                                    [description:Tests\Entity\Profile:private] => Admin Profile
                                )

                            [1] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10001
                                    [description:Tests\Entity\Profile:private] => Manager Profile
                                )

                        )

                )

            [1] => Tests\Entity\User Object
                (
                    [id:Tests\Entity\User:private] => 200
                    [firstName:Tests\Entity\User:private] => May
                    [lastName:Tests\Entity\User:private] => Ngo
                    [email:Tests\Entity\User:private] => may.ngo@micronative.com
                    [roles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1100
                                    [type:Tests\Entity\Role:private] => Student
                                )

                            [1] => Tests\Entity\Role Object
                                (
                                    [id:Tests\Entity\Role:private] => 1200
                                    [type:Tests\Entity\Role:private] => Daughter
                                )

                        )

                    [profiles:Tests\Entity\User:private] => Array
                        (
                            [0] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10003
                                    [description:Tests\Entity\Profile:private] => Student Profile
                                )

                            [1] => Tests\Entity\Profile Object
                                (
                                    [id:Tests\Entity\Profile:private] => 10004
                                    [description:Tests\Entity\Profile:private] => Daughter Profile
                                )

                        )

                )

        )

)
```
@see: [samples/patch.php](samples/patch.php)

## Serialise
```php
$patcher = new Patcher();
$company = new Company();
$company
    ->setId(1)
    ->setName('Micronative');

$role1 = new Role();
$role1
    ->setId(1)
    ->setType('Admin');
$role2 = new Role();
$role2
    ->setId(21)
    ->setType('Manager');

$user1 = new User();
$user1
    ->setId(2)
    ->setEmail('ken.ngo@micronative.com')
    ->setFirstName('Ken')
    ->setLastName('Ngo')
    ->setCompany($company);
$role1->setUsers([$user1]);
$user1->setRoles([$role1, $role2]);

$user2 = new User();
$user2
    ->setId(3)
    ->setEmail('May.ngo@micronative.com')
    ->setFirstName('May')
    ->setLastName('Ngo')
    ->setCompany($company);
$role2->setUsers([$user2]);
$company->setUsers([$user1, $user2]);
$companyArray = $patcher->serialise($company);
print_r($companyArray);

# Output
Array
(
    [id] => 1
    [name] => Micronative
    [users] => Array
        (
            [0] => Array
                (
                    [id] => 2
                    [firstName] => Ken
                    [lastName] => Ngo
                    [email] => ken.ngo@micronative.com
                    [company] => Array
                        (
                            [id] => 1
                            [name] => Micronative
                        )

                    [roles] => Array
                        (
                            [0] => Array
                                (
                                    [id] => 1
                                    [type] => Admin
                                )

                            [1] => Array
                                (
                                    [id] => 21
                                    [type] => Manager
                                )

                        )

                )

            [1] => Array
                (
                    [id] => 3
                    [firstName] => May
                    [lastName] => Ngo
                    [email] => May.ngo@micronative.com
                    [company] => Array
                        (
                            [id] => 1
                            [name] => Micronative
                        )

                )

        )

)
```
@see: [samples/serialise.php](samples/serialise.php)

## Serialise Collection
```php
$patcher = new Patcher();
$company = new Company();
$company
    ->setId(1)
    ->setName('Micronative');

$role1 = new Role();
$role1
    ->setId(1)
    ->setType('Admin');
$role2 = new Role();
$role2
    ->setId(21)
    ->setType('Manager');

$user1 = new User();
$user1
    ->setId(2)
    ->setEmail('ken.ngo@micronative.com')
    ->setFirstName('Ken')
    ->setLastName('Ngo')
    ->setCompany($company);
$role1->setUsers([$user1]);
$user1->setRoles([$role1, $role2]);

$user2 = new User();
$user2
    ->setId(3)
    ->setEmail('May.ngo@micronative.com')
    ->setFirstName('May')
    ->setLastName('Ngo')
    ->setCompany($company);
$role2->setUsers([$user2]);

$rolesArray = $patcher->serialiseCollection([$role1, $role2]);
print_r($rolesArray);

# Output
Array
(
    [0] => Array
        (
            [id] => 1
            [type] => Admin
            [users] => Array
                (
                    [0] => Array
                        (
                            [id] => 2
                            [firstName] => Ken
                            [lastName] => Ngo
                            [email] => ken.ngo@micronative.com
                            [company] => Array
                                (
                                    [id] => 1
                                    [name] => Micronative
                                )

                        )

                )

        )

    [1] => Array
        (
            [id] => 21
            [type] => Manager
            [users] => Array
                (
                    [0] => Array
                        (
                            [id] => 3
                            [firstName] => May
                            [lastName] => Ngo
                            [email] => May.ngo@micronative.com
                            [company] => Array
                                (
                                    [id] => 1
                                    [name] => Micronative
                                )

                        )

                )

        )

)
```
@see: [samples/serialise_collection.php](samples/serialise_collection.php)