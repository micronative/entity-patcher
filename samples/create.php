<?php
require_once('./vendor/autoload.php');

use Micronative\EntityPatcher\Patcher;
use Samples\Entity\Company;

$patcher = new Patcher();
# create entity with data KEYED_BY_PROPERTY
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

    ],
    Patcher::KEYED_BY_PROPERTY);
print_r($company);

# create entity with data KEYED_BY_COLUMN
$company = $patcher->create(
    Company::class,
    [
        'company_id' => 1,
        'company_name' => 'Micronative',
        'users' => [
            [
                'user_id' => '100',
                'user_firstName' => 'Ken',
                'user_lastName' => 'Ngo',
                'user_email' => 'ken.ngo@micronative.com',
                'roles' => [
                    [
                        'role_id' => '1000',
                        'role_type' => 'Admin'
                    ],
                    [
                        'role_id' => '1100',
                        'role_type' => 'Manager'
                    ],
                ],
                'profiles' => [
                    [
                        'profile_id' => '10000',
                        'profile_description' => 'Admin Profile'
                    ],
                    [
                        'profile_id' => '10001',
                        'profile_description' => 'Manager Profile'
                    ],
                ]
            ],
            [
                'user_id' => '200',
                'user_firstName' => 'May',
                'user_lastName' => 'Ngo',
                'user_email' => 'may.ngo@micronative.com',
                'roles' => [
                    [
                        'role_id' => '1100',
                        'role_type' => 'Student'
                    ],
                    [
                        'role_id' => '1200',
                        'role_type' => 'Daughter'
                    ],
                ],
                'profiles' => [
                    [
                        'profile_id' => '10003',
                        'profile_description' => 'Student Profile'
                    ],
                    [
                        'profile_id' => '10004',
                        'profile_description' => 'Daughter Profile'
                    ],
                ]
            ]
        ]

    ],
    Patcher::KEYED_BY_COLUMN);
print_r($company);
