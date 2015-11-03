<?php

namespace Visca\Bundle\LicomBundle\Entity;

use DateTime;

/**
 * ChangeLog.
 */
class ChangeLog
{
    /**
     * @var int
     */
    private $changeNumber;

    /**
     * @var string
     */
    private $deltaSet;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime|null
     */
    private $completeDate;

    /**
     * @var string
     */
    private $appliedBy;

    /**
     * @var string
     */
    private $description;

    /**
     * Get change_number.
     *
     * @return int
     */
    public function getChangeNumber()
    {
        return $this->changeNumber;
    }

    /**
     * Set change_number.
     *
     * @param int $changeNumber
     *
     * @return ChangeLog
     */
    public function setChangeNumber($changeNumber)
    {
        $this->changeNumber = $changeNumber;

        return $this;
    }

    /**
     * Get delta_set.
     *
     * @return string
     */
    public function getDeltaSet()
    {
        return $this->deltaSet;
    }

    /**
     * Set delta_set.
     *
     * @param string $deltaSet
     *
     * @return ChangeLog
     */
    public function setDeltaSet($deltaSet)
    {
        $this->deltaSet = $deltaSet;

        return $this;
    }

    /**
     * Get start_dt.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set start_dt.
     *
     * @param DateTime $startDt
     *
     * @return ChangeLog
     */
    public function setStartDate($startDt)
    {
        $this->startDate = $startDt;

        return $this;
    }

    /**
     * Get completeDate.
     *
     * @return DateTime|null
     */
    public function getCompleteDate()
    {
        return $this->completeDate;
    }

    /**
     * Set completeDate.
     *
     * @param DateTime|null $completeDate
     *
     * @return ChangeLog
     */
    public function setCompleteDate(DateTime $completeDate = null)
    {
        $this->completeDate = $completeDate;

        return $this;
    }

    /**
     * Get applied_by.
     *
     * @return string
     */
    public function getAppliedBy()
    {
        return $this->appliedBy;
    }

    /**
     * Set applied_by.
     *
     * @param string $appliedBy
     *
     * @return ChangeLog
     */
    public function setAppliedBy($appliedBy)
    {
        $this->appliedBy = $appliedBy;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return ChangeLog
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
