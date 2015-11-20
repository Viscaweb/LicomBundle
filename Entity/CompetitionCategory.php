<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionCategoryFactory;
use Doctrine\Common\Collections\Collection;

/**
 * CompetitionCategory.
 *
 * This model wrap many competition into a group similar to the entity Country.
 * However, this is not the Country (which is an other an other entity) and contains different information.
 *
 * Quantity of data: This model contains a static number of rows.
 *
 * @example France
 * @example Canada
 * @example International
 */
class CompetitionCategory
{
    use OptionalDateTimeTrait;
    use DeletableTrait;
    use ToStringNameAndIdTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $competition;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var Sport
     */
    private $sport;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competition = new ArrayCollection();
    }

    /**
     * @return CompetitionCategory
     */
    public static function create()
    {
        $factory = new CompetitionCategoryFactory();

        return $factory->create();
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return CompetitionCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add competition.
     *
     * @param Competition $competition
     *
     * @return CompetitionCategory
     */
    public function addCompetition(Competition $competition)
    {
        $this->competition[] = $competition;

        return $this;
    }

    /**
     * Remove competition.
     *
     * @param Competition $competition
     */
    public function removeCompetition(Competition $competition)
    {
        $this->competition->removeElement($competition);
    }

    /**
     * Get competition.
     *
     * @return Collection
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Get country.
     *
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set country.
     *
     * @param Country $country
     *
     * @return CompetitionCategory
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get sport.
     *
     * @return Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set sport.
     *
     * @param Sport $sport
     *
     * @return CompetitionCategory
     */
    public function setSport(Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }
}
