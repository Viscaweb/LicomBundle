<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraphLabel;
use Visca\Bundle\LicomBundle\Entity\Sport;

/**
 * Class ProfileEntityGraphRepository.
 */
class ProfileEntityGraphRepository extends AbstractEntityRepository
{
    /**
     * @var int App's profile ID
     */
    protected $licomProfileId;

    /**
     * @param int $licomProfileId Licom Profile ID
     *
     * @return ProfileEntityGraphRepository
     */
    public function setLicomProfileId($licomProfileId)
    {
        $this->licomProfileId = $licomProfileId;

        return $this;
    }

    /**
     * @var ProfileEntityGraphLabelRepository Label Repository
     */
    protected $repositoryLabel;

    /**
     * @param ProfileEntityGraphLabelRepository $repositoryLabelRepository Repository
     */
    public function setRepositoryLabel(
        ProfileEntityGraphLabelRepository $repositoryLabelRepository
    ) {
        $this->repositoryLabel = $repositoryLabelRepository;
    }

    /**
     * @return ProfileEntityGraphLabelRepository
     */
    public function getRepositoryLabel()
    {
        return $this->repositoryLabel;
    }

    /**
     * @param Sport    $sport    Sport
     * @param string   $code     Code
     * @param bool     $arrayIds ArrayIDs
     * @param int|null $limit    Limit of results
     *
     * @return \Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph[]
     */
    public function findByLabel(Sport $sport, $code, $arrayIds = false, $limit = null)
    {
        $repositoryGraphLabel = $this->getRepositoryLabel();
        $labelData = $repositoryGraphLabel->findOneBy(
            [
                'code' => $code,
                'entity' => EntityCode::SPORT_CODE,
                'entityId' => $sport->getId(),
            ]
        );
        if (!($labelData instanceof ProfileEntityGraphLabel)) {
            return [];
        }

        $queryBuilder = $this->createQueryBuilder('pe');
        $queryBuilder
            ->where('pe.label = :label')
            ->andWhere('pe.profile = :profile')
            ->setParameter('label', $labelData->getId())
            ->setParameter('profile', $this->licomProfileId)
            ->orderBy('pe.position', 'asc');

        if (is_numeric($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($arrayIds) {
            $queryBuilder->select('pe.entityId');
        }

        $query = $queryBuilder->getQuery();
        $this->setCacheStrategy($query);

        return $query->getResult();
    }
}
