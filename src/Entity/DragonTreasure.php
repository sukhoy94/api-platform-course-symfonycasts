<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DragonTreasureRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DragonTreasureRepository::class)]
#[ApiResource(
    shortName: 'treasure',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
    ],
    normalizationContext: [
        'groups' => [
            'treasure:read',
        ]
    ],

    denormalizationContext: [
        'groups' => [
            'treasure:write',
        ]
    ]
)]
class DragonTreasure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['treasure:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['treasure:read', 'treasure:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['treasure:read', 'treasure:write'])]
    private ?int $value = null;

    #[ORM\Column]
    #[Groups(['treasure:read', 'treasure:write'])]
    private ?int $coolFactor = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $plunderedAt = null;

    #[ORM\Column]
    #[Groups(['treasure:read'])]
    private ?bool $isPublished = false;

    public function __construct()
    {
        $this->plunderedAt = new \DateTimeImmutable("now", new \DateTimeZone("GMT+02:00"));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getCoolFactor(): ?int
    {
        return $this->coolFactor;
    }

    public function setCoolFactor(int $coolFactor): static
    {
        $this->coolFactor = $coolFactor;

        return $this;
    }

    public function getPlunderedAt(): ?\DateTimeImmutable
    {
        return $this->plunderedAt;
    }

    #[Groups(['treasure:read'])]
    public function getPlunderedAtAgo(): string
    {
        return Carbon::instance($this->plunderedAt)->diffForHumans();
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
