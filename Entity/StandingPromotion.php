<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;

/**
 * StandingPromotion.
 *
 * The StandingPromotion defines some extra information related to the given Standing.
 * They help the user to understand the way the ranking will affect the teams.
 *
 * To get more information about this model and how it operates, take a look on the Standing model.
 */
class StandingPromotion
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
     * @var StandingPromotionType
     */
    private $StandingPromotionType;

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
     * @return StandingPromotion
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
     * @return StandingPromotion
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
     * @return StandingPromotion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get standingPromotionType.
     *
     * @return StandingPromotionType
     */
    public function getStandingPromotionType()
    {
        return $this->StandingPromotionType;
    }

    /**
     * Set standingPromotionType.
     *
     * @param StandingPromotionType $standingPromotionType
     *
     * @return StandingPromotion
     */
    public function setStandingPromotionType(
        StandingPromotionType $standingPromotionType
    ) {
        $this->StandingPromotionType = $standingPromotionType;

        return $this;
    }
}
