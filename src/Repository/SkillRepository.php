<?php

namespace App\Repository;

use App\Entity\Result;
use App\Entity\Skill;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    public function getResultsById(int $id)
    {
        $query = $this->createResultBaseQuery();
        $query->where($query->expr()->eq('skill.id', ':id'));
        $query->setParameter('id', $id);

        return $query->execute()->fetch();
    }

    public function getResultsByParentId(int $parentId)
    {
        $query = $this->createResultBaseQuery();
        $query->where($query->expr()->eq('skill.parent_id', ':parentId'));
        $query->setParameter('parentId', $parentId);

        return $query->execute()->fetch();
    }

    public function getRootSkills()
    {
        $query = $this->createQueryBuilder('skill');
        $query->where($query->expr()->eq('skill.parentId', ':parentId'));
        $query->setParameter('parentId', (int)Skill::ROOT_SKILL);

        return $query->getQuery()->getResult();
    }

    public function getResultsByParentIdAndUserId(int $parentId, int $userId)
    {
        $query = $this->createResultBaseQuery();
        $query->where($query->expr()->eq('skill.parent_id', ':parentId'));
        $query->setParameter('parentId', $parentId);
        $query->andWhere($query->expr()->eq('result.user_id', ':userId'));
        $query->setParameter('userId', $userId);

        return $query->execute()->fetch();
    }

    public function getTree(?int $parentId = 0)
    {
        $query = $this->createQueryBuilder('skill');
        $query->select(['skill', 'results', 'users']);
        $query->leftJoin(
            'skill.results',
            'results'
        );
        $query->leftJoin('skill.users', 'users');
        $query->orderBy('skill.id', 'ASC');

        $result = $query->getQuery()->getArrayResult();

        $collection = $this->prepareResultsCollection($result);

        return $this->buildTree($collection, $parentId);
    }

    public function getTreeByUser(User $user)
    {
        $query = $this->createQueryBuilder('skill');
        $query->select(['skill', 'results']);
        $query->leftJoin(
            'skill.results',
            'results',
            'WITH',
            $query->expr()->andX(
                $query->expr()->eq('skill.id', 'results.skillId'),
                $query->expr()->eq('results.userId', ':userId')
            )
        );
        $query->setParameter('userId', $user->getId());
        $query->orderBy('skill.id', 'ASC');

        $result = $query->getQuery()->getArrayResult();

        $collection = $this->prepareResultsCollectionForSingleUser($result);

        return $this->buildTreeForUser($collection, $user->getRootSkillId());
    }

    function buildTree(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parentId'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                $element['hasChildren'] = false;
                if ($children) {
                    $element['children'] = $children;
                    $element['hasChildren'] = true;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }

        return $branch;
    }

    function buildTreeForUser(array &$elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parentId'] == $parentId) {
                $children = $this->buildTreeForUser($elements, $element['id']);
                $element['hasChildren'] = false;
                if ($children) {
                    $element['children'] = $children;
                    $element['childrenAverage'] = $this->getChildrenAverage($children);
                    $element['childrenMax'] = $this->getChildrenMax($children);
                    $element['hasChildren'] = true;
                }
                $branch[$element['id']] = $element;
                unset($elements[$element['id']]);
            }
        }

        return $branch;
    }

    protected function getChildrenAverage(array $children)
    {
        $sum = 0;
        $count = 0;

        foreach ($children as $child) {
            if ($child['hasResults']) {
                $sum += $child['results']['result'];
                $count++;
            }
        }

        if ($sum === 0) {
            return 0;
        }

        return (int)number_format($sum / $count, 0);
    }

    protected function getChildrenMax(array $children)
    {
        $max = 0;

        foreach ($children as $child) {
            if ($child['hasResults'] && $child['results']['result'] > $max) {
                $max = $child['results']['result'];
            }
        }

        return $max;
    }

    /**
     * @param $result
     *
     * @return array
     */
    protected function prepareResultsCollectionForSingleUser($result): array
    {
        $collection = [];
        foreach ($result as $value) {
            $value['hasResults'] = count($value['results']) > 0;
            if ($value['hasResults']) {
                $value['results'] = reset($value['results']);
            }
            $collection[$value['id']] = $value;
        }
        return $collection;
    }

    /**
     * @param $result
     *
     * @return array
     */
    protected function prepareResultsCollection($result): array
    {
        $collection = [];
        foreach ($result as $value) {
            $value['hasResults'] = count($value['results']) > 0;
            $collection[$value['id']] = $value;
        }
        return $collection;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    protected function createResultBaseQuery(): \Doctrine\DBAL\Query\QueryBuilder
    {
        /** @var QueryBuilder $query */
        $query = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $query->select([
            'COUNT(result.result) as countResult',
            'MAX(result.result) as maxResult',
            'SUM(result.result) / COUNT(result.result) as averageResult '
        ]);
        $query->from('skill', 'skill');
        $query->innerJoin(
            'skill',
            'result',
            'result',
            $query->expr()->eq('skill.id', 'result.skill_Id')
        );
        return $query;
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    protected function createDbalQueryBuilder(): \Doctrine\DBAL\Query\QueryBuilder
    {
        return $this->getEntityManager()->getConnection()->createQueryBuilder();
    }
}
