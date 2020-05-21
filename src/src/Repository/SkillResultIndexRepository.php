<?php

namespace App\Repository;

use App\Entity\SkillResultIndex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method SkillResultIndex|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillResultIndex|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillResultIndex[]    findAll()
 * @method SkillResultIndex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillResultIndexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillResultIndex::class);
    }

    public function getResultIndexWithUsers(?int $skillId):SkillResultIndex
    {
        $query = $this->createQueryBuilder('skill_result_index');
        $query->addSelect('users');
        $query->addSelect('indexedResults');
        $query->addSelect('skill');
        $query->addSelect('resultSkill');
//        $query->addSelect('skillResultIndex');
        $query->join('skill_result_index.users','users');
        $query->join('skill_result_index.skill','skill');
        $query->join('users.indexedResults','indexedResults');
        $query->join('indexedResults.skill','resultSkill');
//        $query->join('skill.skillResultIndex','skillResultIndex');
        if($skillId){
            $query->where($query->expr()->eq('skill_result_index.skillId',':skillId'));
            $query->setParameter('skillId',$skillId);
        }

        return $query->getQuery()->getSingleResult();
    }

    public function empty()
    {
        $this->getDbalConnection()->beginTransaction();
        $this->getDbalConnection()->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $this->getDbalConnection()->exec('Truncate table skill_result_index;');
        $this->getDbalConnection()->exec('Truncate table skill_result_index_user;');
        $this->getDbalConnection()->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $this->getDbalConnection()->commit();
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    protected function getDbalConnection(): \Doctrine\DBAL\Connection
    {
        return $this->getEntityManager()->getConnection();
    }
}
