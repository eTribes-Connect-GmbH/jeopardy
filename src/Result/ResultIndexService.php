<?php declare(strict_types = 1);

namespace App\Result;

use App\Entity\Result;
use App\Entity\Skill;
use App\Entity\SkillResultIndex;
use App\Entity\User;
use App\Entity\UserResultIndex;
use App\Repository\ResultRepository;
use App\Repository\SkillRepository;
use App\Repository\SkillResultIndexRepository;
use App\Repository\UserRepository;
use App\Repository\UserResultIndexRepository;

class ResultIndexService implements ResultIndexServiceInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * ResultIndexService constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildIndices(): void
    {
        $this->deleteIndex();
        $this->buildSkillIndex();
        $this->buildUserIndex();

        $this->em->flush();
    }

    protected function buildSkillIndex(): void
    {
        $query = $this->getSkillRepository()->createQueryBuilder('skill');

        /** @var Skill $skill */
        foreach ($query->getQuery()->getResult() as $skill) {
            $resultIndex = new SkillResultIndex();
            $this->em->persist($resultIndex);
            $resultIndex->setSkill($skill);

            $users = $this->getUserRepository()->findAll();

            foreach ($users as $user) {
                $resultIndex->addUser($user);
            }

            $result = $this->getSkillRepository()->getResultsById($skill->getId());

            if ($result) {
                $resultIndex->setAverage((float)$result['averageResult']);
                $resultIndex->setMaxResult((int)$result['maxResult']);
            }

            $childResults = $this->getSkillRepository()->getResultsByParentId($skill->getId());

            if ($childResults) {
                $resultIndex->setChildrenAverage((float)$childResults['averageResult']);
                $resultIndex->setChildrenHighest((int)$childResults['maxResult']);
            }
        }
    }

    protected function buildUserIndex(): void
    {
        foreach ($this->getUserRepository()->findAll() as $user) {
            foreach ($this->getResultRepository()->findBy(['user' => $user]) as $result) {
                $userIndex = new UserResultIndex();
                $userIndex->setUser($user);
                $userIndex->setSkill($result->getSkill());
                $userIndex->setResult($result->getResult());

                $childrenResult = $this->getSkillRepository()->getResultsByParentIdAndUserId($result->getSkillId(), $user->getId());
                if ($childrenResult) {
                    $userIndex->setChildrenHighest((int)$childrenResult['maxResult']);
                    $userIndex->setChildrenAverage((float)$childrenResult['averageResult']);
                }
                $this->em->persist($userIndex);
            }
        }
    }

    /**
     * @return \App\Repository\SkillRepository
     */
    protected function getSkillRepository(): SkillRepository
    {
        return $this->em->getRepository(Skill::class);
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    protected function createDbalQueryBuilder(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return $this->em->getConnection()->createQueryBuilder();
    }

    /**
     * @return \App\Repository\UserRepository
     */
    protected function getUserRepository(): UserRepository
    {
        return $this->em->getRepository(User::class);
    }

    /**
     * @return \App\Repository\SkillResultIndexRepository
     */
    protected function getSkillResultRepository(): SkillResultIndexRepository
    {
        return $this->em->getRepository(SkillResultIndex::class);
    }

    /**
     * @return \App\Repository\ResultRepository
     */
    protected function getResultRepository(): ResultRepository
    {
        return $this->em->getRepository(Result::class);
    }

    /**
     * @return \App\Repository\UserResultIndexRepository
     */
    protected function getUserResultIndexRepository(): UserResultIndexRepository
    {
        return $this->em->getRepository(UserResultIndex::class);
    }

    protected function deleteIndex(): void
    {
        $this->getSkillResultRepository()->empty();
        $this->getUserResultIndexRepository()->empty();
    }
}