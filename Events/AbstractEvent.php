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
     * @return string
     */
    protected function getScope()
    {
        return $this->scope;
    }
    /**
     * @param mixed $scope
     */
    protected function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getEventObject().'@'.$this->getScope();
    }

}