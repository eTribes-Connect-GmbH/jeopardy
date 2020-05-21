<?php

namespace App\Repository;

use App\Entity\UserResultIndex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserResultIndex|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserResultIndex|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserResultIndex[]    findAll()
 * @method UserResultIndex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserResultIndexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserResultIndex::class);
    }

    public function empty()
    {
        $this->getDbalConnection()->beginTransaction();
        $this->getDbalConnection()->exec('SET FOREIGN_KEY_CHECKS = 0;');
        $this->getDbalConnection()->exec('Truncate table user_result_index;');
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
