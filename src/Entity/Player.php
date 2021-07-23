<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    public const UP = 'up';
    public const DOWN = 'down';
    public const LEFT = 'left';
    public const RIGHT = 'right';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=Position::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Position $position;

    public function __construct(Position $position)
    {
        $this->position = $position;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}
