<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\LicomBundle\Entity\Traits\GraphLabelTrait;

/**
 * Class BettingOfferProviderGraphLabel.
 */
class BettingOfferProviderGraphLabel
{
    use GraphLabelTrait;

    /**
     * @var int
     */
    private $id;

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
     * @return BettingOfferProviderGraphLabel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
