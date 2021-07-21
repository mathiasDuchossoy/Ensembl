<?php

namespace App\Entity;

use App\Repository\TargetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TargetRepository::class)
 */
class Target
{
    public const STATE_TOUCH = 'touch';
    public const STATE_MISS = 'miss';
    public const STATE_KILL = 'kill';

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

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $touchCount;

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

    public function getTouchCount(): ?int
    {
        return $this->touchCount;
    }

    public function incrementTouchCount(): void
    {
        $this->touchCount++;
    }
}
