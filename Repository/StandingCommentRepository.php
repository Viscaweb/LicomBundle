<?php


namespace Visca\Bundle\LicomBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\StandingCommentGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\StandingComment;
use Visca\Bundle\LicomBundle\Entity\StandingRow;

/**
 * Class StandingCommentRepository
 */
class StandingCommentRepository extends AbstractEntityRepository
{
    /**
     * @param StandingRow $standingRow StandingRow
     *
     * @return StandingComment
     */
    public function findByStandingRow(StandingRow $standingRow)
    {
        return $this->createQueryBuilder('sc')
            ->join('ViscaLicomBundle:StandingCommentGraph', 'scg', Join::WITH, 'sc.id = scg.standingComment')
            ->where('scg.standingRow = :standingRow')
            ->andWhere('scg.label = :label')
            ->setParameters([
                'standingRow' => $standingRow,
                'label' => StandingCommentGraphLabelCode::DEFAULT_CODE
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
