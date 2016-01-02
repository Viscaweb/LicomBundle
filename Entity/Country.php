<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\CountryFactory;

/**
 * Country.
 *
 * The Country model is NOT the CompetitionCategory and vice-versa.
 * I invite you to open the CompetitionCategory model to get more information about it.
 *
 * Quantity of data: This model contains a static number of rows.
 *
 * @example France
 * @example Canada
 */
class Country
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
     * @var string
     */
    private $code;

    /**
     * @var Collection
     */
    private $competitionCategory;

    /**
     * @var string
     */
    private $alpha2Code;

    /**
     * @var string
     */
    private $alpha3Code;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionCategory = new ArrayCollection();
    }

    /**
     * @return Country
     */
    public static function create()
    {
        $factory = new CountryFactory();

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
     * Set id.
     *
     * @param int $id
     *
     * @return Country
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
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Add competitionCategory.
     *
     * @param CompetitionCategory $competitionCategory
     *
     * @return Country
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
     * @return CompetitionCategory[]
     */
    public function getCompetitionCategory()
    {
        return $this->competitionCategory;
    }

    /**
     * @return string
     */
    public function getAlpha2Code()
    {
        return $this->alpha2Code;
    }

    /**
     * @param string $alpha2Code
     *
     * @return $this
     */
    public function setAlpha2Code($alpha2Code)
    {
        $this->alpha2Code = $alpha2Code;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlpha3Code()
    {
        return $this->alpha3Code;
    }

    /**
     * @param string $alpha3Code
     *
     * @return $this
     */
    public function setAlpha3Code($alpha3Code)
    {
        $this->alpha3Code = $alpha3Code;

        return $this;
    }
}
