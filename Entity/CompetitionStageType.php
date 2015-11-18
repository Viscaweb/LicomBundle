<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Entity\Traits\ToStringNameAndIdTrait;
use Visca\Bundle\LicomBundle\Factory\CompetitionStageTypeFactory;
use Doctrine\Common\Collections\Collection;

/**
 * CompetitionStageType.
 */
class CompetitionStageType
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
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Collection
     */
    private $competitionStage;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->competitionStage = new ArrayCollection();
    }

    /**
     * @return CompetitionStageType
     */
    public static function create()
    {
        $factory = new CompetitionStageTypeFactory();

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
     * @return CompetitionStageType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return CompetitionStageType
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return CompetitionStageType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add competitionStage.
     *
     * @param CompetitionStage $competitionStage
     *
     * @return CompetitionStageType
     */
    public function addCompetitionStage(CompetitionStage $competitionStage)
    {
        $this->competitionStage[] = $competitionStage;

        return $this;
    }

    /**
     * Remove competitionStage.
     *
     * @param CompetitionStage $competitionStage
     */
    public function removeCompetitionStage(CompetitionStage $competitionStage)
    {
        $this->competitionStage->removeElement($competitionStage);
    }

    /**
     * Get competitionStage.
     *
     * @return Collection
     */
    public function getCompetitionStage()
    {
        return $this->competitionStage;
    }
}
