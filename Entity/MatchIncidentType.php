<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchIncidentType.
 */
class MatchIncidentType
{
    use OptionalDateTimeTrait;
    use DeletableTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var Sport
     */
    private $sport;

    /**
     * @var MatchIncident
     */
    private $matchIncident;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return MatchIncidentType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return MatchIncidentType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return MatchIncidentType
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get Sport.
     *
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set Sport.
     *
     * @param Sport $sport
     *
     * @return MatchIncidentType
     */
    public function setSport(Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get matchIncident.
     *
     * @return MatchIncident
     */
    public function getMatchIncident()
    {
        return $this->matchIncident;
    }

    /**
     * Set matchIncident.
     *
     * @param MatchIncident $matchIncident
     *
     * @return MatchIncidentType
     */
    public function setMatchIncident(
        MatchIncident $matchIncident = null
    ) {
        $this->matchIncident = $matchIncident;

        return $this;
    }

    /**
     * Method to know if this incident type is a red card.
     */
    public function isRedCard()
    {
        return (in_array($this->getCode(), array('RedCard', 'YellowCard2')));
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return MatchIncidentType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}
