<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class SportRepository.
 */
class SportRepository extends AbstractEntityRepository
{
    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('s')->select('s.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @param $id
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return Sport
     */
    public function findSportByCompetitionSeasonStageId($id)
    {
        return $this->createQueryBuilder('sport')
            ->join('sport.competitionCategory', 'cc')
            ->join('cc.competition', 'c')
            ->join('c.competitionSeason', 'cs')
            ->join('cs.competitionSeasonStage', 'css')
            ->where('css.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param $id
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return Sport
     */
    public function findSportByMatchId($id)
    {
        return $this->createQueryBuilder('sport')
            ->join(Match::class, 'match', Join::WITH, 'match.Sport = sport.id')
            ->where('match.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }


//    protected function setCacheStrategy($query)
//    {
//        parent::setCacheStrategy($query); // TODO: Change the autogenerated stub
//    }
}
