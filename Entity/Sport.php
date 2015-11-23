<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\SportFactory;
use Doctrine\Common\Collections\Collection;

/**
 * Sport.
 *
 * This model contains all the Sports we take care of.
 *
 * Quantity of data: This model contains a static number of rows.
 *
 * @example Football
 * @example Basket
 */
class Sport
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
    private $competitionCategory;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionCategory = new ArrayCollection();
    }

    /**
     * @return Sport
     */
    public static function create()
    {
        $factory = new SportFactory();

        return $factory->create();
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Sport
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add competitionCategory.
     *
     * @param CompetitionCategory $competitionCategory
     *
     * @return Sport
     */
    public function addCompetitionCategory(
        CompetitionCategory $competitionCategory
    ) {
        $this->competitionCategory[] = $competitionCategory;

        return $this;
    }

    /**
     * Remove competitionCategory.
     *
     * @param CompetitionCategory $competitionCategory
     */
    public function removeCompetitionCategory(
        CompetitionCategory $competitionCategory
    ) {
        $this->competitionCategory->removeElement($competitionCategory);
    }

    /**
     * Get competitionCategory.
     *
     * @return Collection
     */
    public function getCompetitionCategory()
    {
        return $this->competitionCategory;
    }
}
