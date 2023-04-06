<?php

namespace Samples\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
{
    /**
     * @var int
     * @ORM\Column(name="id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="type")
     */
    private string $type;

    /**
     * User has many Roles
     * Role belongs to many Users
     * @var User[]
     * @ORM\ManyToMany(targetEntity="Samples\Entity\User", mappedBy="roles")
     */
    private array $users;
}