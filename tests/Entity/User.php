<?php

namespace Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var int
     * @ORM\Column(name="user_id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="user_first_name")
     */
    private string $firstName;

    /**
     * @var string
     * @ORM\Column(name="user_last_name")
     */
    private string $lastName;

    /**
     * @var string
     * @ORM\Column(name="user_email")
     */
    private string $email;

    /**
     * User belongs to a Company
     * @var Company
     * @ORM\ManyToOne(targetEntity="Tests\Entity\Company", inversedBy="users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected Company $company;

    /**
     * User has many Roles
     * Role belongs to many Users
     * @var Role[]
     * @ORM\ManyToMany(targetEntity="Tests\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="user_role")
     */
    private array $roles;

    /**
     * User has many Profiles
     * @var Profile[]
     * @ORM\OneToMany(targetEntity="Tests\Entity\Profile", mappedBy="user", cascade={"persist"})
     */
    private array $profiles;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     * @return User
     */
    public function setCompany(Company $company): User
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return array
     */
    public function getProfiles(): array
    {
        return $this->profiles;
    }

    /**
     * @param array $profiles
     * @return User
     */
    public function setProfiles(array $profiles): User
    {
        $this->profiles = $profiles;
        return $this;
    }
}
