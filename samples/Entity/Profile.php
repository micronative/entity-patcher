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
     * @ORM\Column(name="id", type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(name="description", type="string")
     */
    private string $description;

    /**
     * User has many Profiles
     * Profile belongs to one User
     * @var User
     * @ORM\ManyToOne(targetEntity="Samples\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private User $user;

}