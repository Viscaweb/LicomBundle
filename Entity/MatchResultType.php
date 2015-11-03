<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Visca\Bundle\CoreBundle\Entity\Traits\OptionalDateTimeTrait;
use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;

/**
 * MatchResultType.
 */
class MatchResultType
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
     * @var Collection
     */
    private $matchResult;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->matchResult = new ArrayCollection();
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
     * @return MatchResultType
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
     * @return MatchResultType
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
     * @return MatchResultType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Add matchResult.
     *
     * @param MatchResult $matchResult
     *
     * @return MatchResultType
     */
    public function addMatchResult(
        MatchResult $matchResult
    ) {
        $this->matchResult[] = $matchResult;

        return $this;
    }

    /**
     * Remove matchResult.
     *
     * @param MatchResult $matchResult
     */
    public function removeMatchResult(
        MatchResult $matchResult
    ) {
        $this->matchResult->removeElement($matchResult);
    }

    /**
     * Get matchResult.
     *
     * @return Collection
     */
    public function getMatchResult()
    {
        return $this->matchResult;
    }
}
