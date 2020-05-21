<?php

namespace App\Entity;

use App\Repository\UserResultIndexRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserResultIndexRepository::class)
 */
class UserResultIndex
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private $skillId;

    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $childrenAverage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $childrenHighest;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class)
     * @ORM\JoinColumn(name="skill_id",referencedColumnName="id",nullable=false)
     */
    private $skill;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="indexedResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSkillId(): ?int
    {
        return $this->skillId;
    }

    public function setSkillId(int $skillId): self
    {
        $this->skillId = $skillId;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getChildrenAverage(): ?float
    {
        return $this->childrenAverage;
    }

    public function setChildrenAverage(?float $childrenAverage): self
    {
        $this->childrenAverage = $childrenAverage;

        return $this;
    }

    public function getChildrenHighest(): ?int
    {
        return $this->childrenHighest;
    }

    public function setChildrenHighest(?int $childrenHighest): self
    {
        $this->childrenHighest = $childrenHighest;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }
}
