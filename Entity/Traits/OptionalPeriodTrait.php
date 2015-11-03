<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use DateTime;

/**
 * Class OptionalPeriodTrait.
 */
trait OptionalPeriodTrait
{
    /**
     * @var DateTime|null
     */
    private $start;

    /**
     * @var DateTime|null
     */
    private $end;

    /**
     * Get start.
     *
     * @return DateTime|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set start.
     *
     * @param DateTime|null $start
     *
     * @return $this
     */
    public function setStart(DateTime $start = null)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get end.
     *
     * @return DateTime|null
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set end.
     *
     * @param DateTime|null $end
     *
     * @return $this
     */
    public function setEnd(DateTime $end = null)
    {
        $this->end = $end;

        return $this;
    }
}
