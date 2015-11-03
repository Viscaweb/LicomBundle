<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Image;

use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomViewBundle\Provider\Image\Abstracts\AbstractImageProvider;

/**
 * SportImageProvider.
 */
class SportImageProvider extends AbstractImageProvider
{
    const ENTITY_NAME = 'sport';

    /**
     * @var Sport Sport entity
     */
    protected $sport;

    /**
     * @param Sport $sport Sport object
     *
     * @return $this
     */
    public function setSport(Sport $sport)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->sport->getName();
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return (string) $this->sport->getId();
    }
}
