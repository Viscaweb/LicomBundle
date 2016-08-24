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
        return $this->getEventObject().'@'.$this->getScope();
    }
}
