<?php

namespace Samples\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="profle")
 */
class Profile
{
    /**
     * @var int
     * @ORM\Column(name="profile_id", type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="profile_description", type="string")
     */
    private string $description;

    /**
     * User has many Profiles
     * Profile belongs to one User
     * @var User
     * @ORM\ManyToOne(targetEntity="Tests\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Profile
     */
    public function setId(int $id): Profile
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Profile
     */
    public function setDescription(string $description): Profile
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Profile
     */
    public function setUser(User $user): Profile
    {
        $this->user = $user;
        return $this;
    }
}
