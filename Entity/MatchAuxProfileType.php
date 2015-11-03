<?php

namespace Visca\Bundle\LicomBundle\Entity;

use Visca\Bundle\CoreBundle\Entity\Traits\DeletableTrait;
use Visca\Bundle\LicomBundle\Factory\MatchAuxProfileTypeFactory;

/**
 * MatchAuxProfileType.
 */
class MatchAuxProfileType
{
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
     * @return MatchAuxProfileType
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
     * @return MatchAuxProfileType
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
     * @return MatchAuxProfileType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return MatchAuxProfileType
     */
    public static function create()
    {
        $factory = new MatchAuxProfileTypeFactory();

        return $factory->create();
    }
}
