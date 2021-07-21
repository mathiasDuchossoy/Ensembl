<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MapRepository::class)
 */
class Map
{
    public const SQUARES_NUMBER = 21;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=Target::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Target $target;

    public function __construct(Target $target)
    {
        $this->target = $target;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): Target
    {
        return $this->target;
    }
}
