<?php

namespace App\Entity;

use App\Repository\SkillResultIndexRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillResultIndexRepository::class)
 */
class SkillResultIndex
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
    private $skillId;

    /**
     * @ORM\Column(type="float")
     */
    private $average;

    /**
     * @ORM\Column(type="float")
     */
    private $childrenAverage;

    /**
     * @ORM\Column(type="integer")
     */
    private $childrenHighest;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxResult;

    /**
     * @ORM\ManyToMany(targetEntity=User::class,orphanRemoval=false)
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Skill")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    private $skill;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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

    public function getAverage(): ?float
    {
        return $this->average;
    }

    public function setAverage(float $average): self
    {
        $this->average = $average;

        return $this;
    }

    public function getChildrenAverage(): ?float
    {
        return $this->childrenAverage;
    }

    public function setChildrenAverage(float $childrenAverage): self
    {
        $this->childrenAverage = $childrenAverage;

        return $this;
    }

    public function getChildrenHighest(): ?int
    {
        return $this->childrenHighest;
    }

    public function setChildrenHighest(int $childrenHighest): self
    {
        $this->childrenHighest = $childrenHighest;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getMaxResult(): ?int
    {
        return $this->maxResult;
    }

    public function setMaxResult(int $maxResult): self
    {
        $this->maxResult = $maxResult;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        // set (or unset) the owning side of the relation if necessary
        $newSkillResultIndex = null === $skill ? null : $this;
        if ($skill->getSkillResultIndex() !== $newSkillResultIndex) {
            $skill->setSkillResultIndex($newSkillResultIndex);
        }

        return $this;
    }
}
