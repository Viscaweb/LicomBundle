<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Image;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomViewBundle\Provider\Image\Abstracts\AbstractImageProvider;

/**
 * CompetitionImageProvider.
 */
class CompetitionImageProvider extends AbstractImageProvider
{
    const ENTITY_NAME = 'competition';

    /**
     * @var Competition Competition entity
     */
    protected $competition;

    /**
     * @param Competition $competition Competition object
     *
     * @return $this
     */
    public function setCompetition(Competition $competition)
    {
        $this->competition = $competition;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->competition->getName();
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->competition->getId();
    }
}
