<?php

namespace Tests\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role
{
    /**
     * @var int
     * @ORM\Column(name="role_id")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="role_type")
     */
    private string $type;

    /**
     * User has many Roles
     * Role belongs to many Users
     * @var User[]
     * @ORM\ManyToMany(targetEntity="Tests\Entity\User", mappedBy="roles")
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
     * @return Role
     */
    public function setId(int $id): Role
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Role
     */
    public function setType(string $type): Role
    {
        $this->type = $type;
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
     * @return Role
     */
    public function setUsers(array $users): Role
    {
        $this->users = $users;
        return $this;
    }
}
