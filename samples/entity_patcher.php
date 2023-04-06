<?php
require_once('./vendor/autoload.php');

use Micronative\EntityPatcher\Patcher;
use Samples\Entity\Company;

$patcher = new Patcher();
$company = new Company();
$company->setId(1)->setName('Micronative');
$arrayByColumn = $patcher->serialise($company, Patcher::KEYED_BY_COLUMN);
var_dump($arrayByColumn);

$arrayByProperty = $patcher->serialise($company, Patcher::KEYED_BY_PROPERTY);
var_dump($arrayByProperty);