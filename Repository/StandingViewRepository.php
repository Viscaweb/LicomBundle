<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\StandingView;

/**
 * Class StandingViewRepository.
 */
class StandingViewRepository extends AbstractEntityRepository
{
    const LABEL_TOP_COUNTRIES = 17;

    /**
     * @var int Profile ID
     */
    protected $contextProfileId;

    /**
     * @param int $profileId Profile ID
     */
    public function setProfileId($profileId)
    {
        $this->setContextProfileId($profileId);
    }

    /**
     * @return int
     */
    public function getContextProfileId()
    {
        return $this->contextProfileId;
    }

    /**
     * @param int $contextProfileId
     *
     * @return StandingViewRepository
     */
    public function setContextProfileId($contextProfileId)
    {
        $this->contextProfileId = $contextProfileId;

        return $this;
    }

    /**
     * @return StandingView[]
     */
    public function findTopCountries()
    {
        return $this->findBy(
            [
                'label' => self::LABEL_TOP_COUNTRIES,
                'profile' => $this->getContextProfileId(),
            ]
        );
    }
}
