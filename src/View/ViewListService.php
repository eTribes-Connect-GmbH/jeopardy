<?php declare(strict_types = 1);

namespace App\View;

use Doctrine\DBAL\Connection;
use function Doctrine\DBAL\Query\QueryBuilder;

class ViewListService implements ViewListServiceInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * ViewListService constructor.
     *
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getSkillListView(?int $id = 0): array
    {
        $skillResultList = $this->getSkillResultByIdList([$id]);
        $skillResult = reset($skillResultList);
        $childIdList = $this->getChildIdList($id);
        $childSkillResult = $this->getSkillResultByIdList($childIdList);
        $userSkillResultsByIdList = $this->getUserSkillResultsByIdList([$id]);
        $userChildSkillResultsByIdList = $this->getUserSkillResultsByIdList($childIdList);


        foreach ($childSkillResult as &$result){
            $userSkill = $userChildSkillResultsByIdList[$result['skill_id']];
            $result['userChildResults'] = $userSkill;
        }

        $skillResult['userResults'] = reset($userSkillResultsByIdList);
        $skillResult['userSkillResult'] = $childSkillResult;
        $skillResult['users'] = array_keys(reset($childSkillResult)['userChildResults']);
        return $skillResult;
    }

    /**
     * @param array $idList
     *
     * @return array
     */
    protected function getUserSkillResultsByIdList(array $idList): array
    {
        $query = $this->connection->createQueryBuilder();

        $subQuery = $this->createSkillChildCountSubQuery();

        $query->select([
            'user_result_index.skill_id as id',
            'skill.name',
            'user.email',
            'skill.description',
            'user_result_index.result',
            'user_result_index.children_average',
            'user_result_index.children_highest',
            '(' . $subQuery->getSQL() . ') as childCount'
        ]);

        $query->from('user_result_index', 'user_result_index');
        $query->join('user_result_index', 'skill', 'skill',
            $query->expr()->eq('user_result_index.skill_id', 'skill.id')
        );
        $query->join('user_result_index', 'user', 'user',
            $query->expr()->eq('user_result_index.user_id', 'user.id')
        );
        $query->where($query->expr()->in('skill.id', ':idList'));
        $query->setParameter('idList', $idList, Connection::PARAM_INT_ARRAY);

        $query->addOrderBy('id', 'ASC');

        $collection = [];
        foreach ($query->execute()->fetchAll() as $userSkill) {
            $collection[$userSkill['id']][$userSkill['email']] = $userSkill;
        }
        return $collection;
    }

    /**
     * @param array $idList
     *
     * @return array
     */
    protected function getSkillResultByIdList(array $idList): array
    {
        $query = $this->connection->createQueryBuilder();
        $subQuery = $this->createSkillChildCountSubQuery();

        $query = $query->getConnection()->createQueryBuilder();
        $query->select([
            'skill_result_index.skill_id',
            'skill_result_index.average',
            'skill_result_index.max_result as highest',
            'skill_result_index.children_average',
            'skill_result_index.children_highest',
            'skill.name',
            'skill.description',
            '(' . $subQuery->getSQL() . ') as childCount'
        ]);
        $query->from('skill_result_index', 'skill_result_index');
        $query->join('skill_result_index', 'skill', 'skill',
            $query->expr()->eq('skill_result_index.skill_id', 'skill.id')
        );
        $query->where($query->expr()->in('skill_result_index.skill_id', ':skillId'));
        $query->setParameter(':skillId', $idList, Connection::PARAM_INT_ARRAY);

        $query->addOrderBy('skill_id', 'ASC');

        return $query->execute()->fetchAll();
    }

    /**
     * @param int|null $id
     *
     * @return array
     */
    protected function getChildIdList(?int $id): array
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('id');
        $query->from('skill', 'skill');
        $query->where($query->expr()->eq('skill.parent_id', ':parentId'));
        $query->setParameter('parentId', $id);

        $resultList = $query->execute()->fetchAll();

        return array_column($resultList, 'id');
    }

    /**
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    protected function createSkillChildCountSubQuery(): \Doctrine\DBAL\Query\QueryBuilder
    {
        $subQuery = $this->connection->createQueryBuilder();
        $subQuery->select('COUNT(sub_skill.id)');
        $subQuery->from('skill', 'sub_skill');
        $subQuery->where($subQuery->expr()->eq('sub_skill.parent_id', 'skill.id'));
        return $subQuery;
    }


}