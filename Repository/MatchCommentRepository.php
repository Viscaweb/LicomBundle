<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\MatchComment;

/**
 * Class MatchCommentRepository.
 */
class MatchCommentRepository extends AbstractEntityRepository
{
    /**
     * @param int $matchId             match id
     * @param int $localizationProfile localization profile id
     *
     * @return MatchComment[]
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByMatchAndLocalizationProfile($matchId, $localizationProfile)
    {
        return $this
            ->createQueryBuilder('mc')
            ->where('mc.match = :matchId')
            ->andWhere('mc.localization = :localizationProfile')
            ->andWhere('mc.del = :del')
            ->setParameters(
                [
                    'matchId' => $matchId,
                    'localizationProfile' => $localizationProfile,
                    'del' => 'no',
                ]
            )
            ->addOrderBy('mc.timeElapsed', 'DESC')
            ->addOrderBy('mc.timeElapsedExtra', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
