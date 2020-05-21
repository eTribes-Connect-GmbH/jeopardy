<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    public const ROLES = [
        'ROLE_USER' => 'ROLE_USER',
        'ROLE_CONTENT' => 'ROLE_CONTENT',
        'ROLE_ADMIN' => 'ROLE_ADMIN',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $rootSkillId;

    /**
     * **
     * @ORM\ManyToOne(targetEntity="App\Entity\Skill", inversedBy="users")
     * @ORM\JoinColumn(name="root_skill_id", referencedColumnName="id")
     */
    private $rootSkill;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="user", orphanRemoval=true)
     */
    private $results;

    /**
     * @ORM\OneToMany(targetEntity=UserResultIndex::class, mappedBy="user")
     */
    private $indexedResults;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->indexedResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getRootSkillId()
    {
        return $this->rootSkillId;
    }

    /**
     * @param mixed $rootSkillId
     */
    public function setRootSkillId($rootSkillId): void
    {
        $this->rootSkillId = $rootSkillId;
    }

    /**
     * @return mixed
     */
    public function getRootSkill()
    {
        return $this->rootSkill;
    }

    /**
     * @param mixed $rootSkill
     */
    public function setRootSkill($rootSkill): void
    {
        $this->rootSkill = $rootSkill;
    }

    /**
     * @return Collection|Result[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setUser($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getUser() === $this) {
                $result->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserResultIndex[]
     */
    public function getIndexedResults(): Collection
    {
        return $this->indexedResults;
    }

    public function addIndexedResult(UserResultIndex $indexedResult): self
    {
        if (!$this->indexedResults->contains($indexedResult)) {
            $this->indexedResults[] = $indexedResult;
            $indexedResult->setUser($this);
        }

        return $this;
    }

    public function removeIndexedResult(UserResultIndex $indexedResult): self
    {
        if ($this->indexedResults->contains($indexedResult)) {
            $this->indexedResults->removeElement($indexedResult);
            // set the owning side to null (unless already changed)
            if ($indexedResult->getUser() === $this) {
                $indexedResult->setUser(null);
            }
        }

        return $this;
    }
}
