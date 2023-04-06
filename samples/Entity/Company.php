<?php

namespace Samples\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company")
 */
class Company
{
    /**
     * @var int
     * @ORM\Column(name="company_id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="company_name")
     */
    private string $name;

    /**
     * Company has many Users
     * @var User[]
     * @ORM\OneToMany(targetEntity="Samples\Entity\User", mappedBy="company", cascade={"persist"})
     */
    private array $users;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Company
     */
    public function setId(int $id): Company
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Company
     */
    public function setName(string $name): Company
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param array $users
     * @return Company
     */
    public function setUsers(array $users): Company
    {
        $this->users = $users;
        return $this;
    }
}
