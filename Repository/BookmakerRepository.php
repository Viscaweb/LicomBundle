<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Bookmaker;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class BookmakerRepository.
 */
class BookmakerRepository extends AbstractEntityRepository
{
    /**
     * @return null|Bookmaker
     */
    public function getMain()
    {
        return $this->createQueryBuilder('bookmaker')
            ->select('bookmaker')
            ->orderBy('bookmaker.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
