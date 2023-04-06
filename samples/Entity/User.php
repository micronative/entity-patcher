<?php

namespace Samples\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var int
     * @ORM\Column(name="id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="first_name")
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name")
     */
    private string $lastName;

    /**
     * @var string
     * @ORM\Column(name="email")
     */
    private string $email;

    /**
     * User belongs to a Company
     * @var Company
     * @ORM\ManyToOne(targetEntity="Samples\Entity\Company", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected Company $company;

    /**
     * User has many Roles
     * Role belongs to many Users
     * @var Role[]
     * @ORM\ManyToMany(targetEntity="Samples\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="user_role")
     */
    private array $roles;

    /**
     * User has many Profiles
     * @var Profile[]
     * @ORM\OneToMany(targetEntity="Samples\Entity\Profile", mappedBy="user", cascade={"persist"})
     */
    private array $profiles;
}