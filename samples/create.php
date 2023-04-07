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
                ]
            ]
        ]

    ]);
print_r($company);

