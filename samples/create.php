<?php
require_once('./vendor/autoload.php');

use Micronative\EntityPatcher\Patcher;
use Samples\Entity\Company;

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

