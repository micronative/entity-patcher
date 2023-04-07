<?php
require_once('./vendor/autoload.php');

use Micronative\EntityPatcher\Patcher;
use Samples\Entity\Company;
use Samples\Entity\Role;
use Samples\Entity\User;

$patcher = new Patcher();
$company = new Company();
$company
    ->setId(1)
    ->setName('Micronative');
$arrayByColumn = $patcher->serialise($company, Patcher::KEYED_BY_COLUMN);
print_r($arrayByColumn);

$arrayByProperty = $patcher->serialise($company, Patcher::KEYED_BY_PROPERTY);
print_r($arrayByProperty);

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

$role1Array = $patcher->serialise($role1);
print_r($role1Array);

$userArray = $patcher->serialise($user1);
print_r($userArray);

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

$rolesArray = $patcher->serialiseCollection([$role1, $role2]);
print_r($rolesArray);

