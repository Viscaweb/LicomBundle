<?php

namespace Visca\Bundle\LicomBundle\Entity;

/**
 * LibeSequence.
 */
class LibeSequence
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $cnt;

    /**
     * @var int|null
     */
    private $inc;

    /**
     * @var string|null
     */
    private $obs;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param string $id
     *
     * @return LibeSequence
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get cnt.
     *
     * @return int
     */
    public function getCnt()
    {
        return $this->cnt;
    }

    /**
     * Set cnt.
     *
     * @param int $cnt
     *
     * @return LibeSequence
     */
    public function setCnt($cnt)
    {
        $this->cnt = $cnt;

        return $this;
    }

    /**
     * Get inc.
     *
     * @return int|null
     */
    public function getInc()
    {
        return $this->inc;
    }

    /**
     * Set inc.
     *
     * @param int|null $inc
     *
     * @return LibeSequence
     */
    public function setInc($inc)
    {
        $this->inc = $inc;

        return $this;
    }

    /**
     * Get obs.
     *
     * @return string|null
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set obs.
     *
     * @param string|null $obs
     *
     * @return LibeSequence
     */
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }
}
