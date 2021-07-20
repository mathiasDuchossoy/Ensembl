<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 * @ApiResource(
 *      collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "route_name"="game_start",
 *              "read"=false,
 *              "output"=false,
 *              "normalization_context"={"groups"={}},
 *              "denormalization_context"={"groups"={}},
 *          },
 *      },
 *      itemOperations={},
 * )
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=Map::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Map $map;

    /**
     * @ORM\OneToOne(targetEntity=Player::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Player $player;

    public function __construct(Map $map, Player $player)
    {
        $this->map = $map;
        $this->player = $player;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMap(): ?Map
    {
        return $this->map;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }
}
