<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    public const ROOT_SKILL = 0;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=512)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $parentId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill",inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id",nullable=true)
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Result", mappedBy="skill")
     */
    protected $results;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="rootSkill")
     */
    protected $users;

    /**
     * @var @ORM\Column(type="string", length=512)
     */
    private $path;

    /**
     * @ORM\Column(type="integer")
     */
    private $questionId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id",nullable=true)
     */
    private $question;

    /**
     * @ORM\OneToOne(targetEntity=SkillResultIndex::class, mappedBy="skill")
     */
    private $skillResultIndex;

    /**
     * Skill constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
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

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @return \App\Entity\Skill
     */
    public function getParent(): Skill
    {
        return $this->parent;
    }

    /**
     * @param \App\Entity\Skill $parent
     */
    public function setParent(Skill $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren(ArrayCollection $children): void
    {
        $this->children = $children;
    }

    public function addChild(Skill $skill)
    {
        $this->children->add($skill);
    }

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     */
    public function setResults(ArrayCollection $results): void
    {
        $this->results = $results;
    }

    public function addResult(Result $result)
    {
        $this->results->add($result);
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsers(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->users;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $users
     */
    public function setUsers(\Doctrine\Common\Collections\ArrayCollection $users): void
    {
        $this->users = $users;
    }

    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    public function getSkillResultIndex(): ?SkillResultIndex
    {
        return $this->skillResultIndex;
    }

    public function setSkillResultIndex(?SkillResultIndex $skillResultIndex): self
    {
        $this->skillResultIndex = $skillResultIndex;

        return $this;
    }
}
