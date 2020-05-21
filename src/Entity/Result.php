<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResultRepository::class)
 */
class Result
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
    private $questionId;

    /**
     * @ORM\Column(type="integer")
     */
    private $skillId;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $learn;

    /**
     * @ORM\OneToOne(targetEntity=Question::class)
     * @ORM\JoinColumn(name="question_id",referencedColumnName="id",nullable=false)
     */
    private $question;

    /**
     * **
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill", inversedBy="results")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     */
    private $skill;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="results")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id",nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionId(): ?int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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

    public function getLearn(): ?bool
    {
        return $this->learn;
    }

    public function setLearn(?bool $learn): self
    {
        $this->learn = $learn;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
