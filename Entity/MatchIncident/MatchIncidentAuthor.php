<?php

namespace Visca\Bundle\LicomBundle\Entity\MatchIncident;

use Visca\Bundle\LicomBundle\Entity\MatchIncident\Interfaces\MatchIncidentAuthorInterface;

/**
 * Class MatchIncidentAuthor.
 */
class MatchIncidentAuthor implements MatchIncidentAuthorInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set athlete name.
     *
     * @param string $name Athlete's name.
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
