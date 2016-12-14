<?php

namespace Visca\Bundle\LicomBundle\Events;

abstract class AbstractEvent implements Event
{
    /**
     * @return string
     */
    abstract public function getEventObject();

    /** @var string */
    private $scope;

    /** @var null|string */
    static $name = null;

    /**
     * AbstractEvent constructor.
     *
     * @param string $scope
     */
    protected function __construct($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    protected function getScope()
    {
        return $this->scope;
    }
    /**
     * @return string
     */
    public function getName()
    {
        if (self::$name !== null) {
            return self::$name;
        }

        return self::$name = $this->getEventObject().'@'.$this->getScope();
    }
}
