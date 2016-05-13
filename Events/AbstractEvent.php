<?php
namespace Visca\Bundle\LicomBundle\Events;

abstract class AbstractEvent implements Event
{
    /**
     * @return string
     */
    abstract public function getEventObject();

    private static $scope;

    /**
     * @return string
     */
    public function getScope()
    {
        return self::$scope;
    }
    /**
     * @param mixed $scope
     */
    public static function setScope($scope)
    {
        self::$scope = $scope;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getEventObject().'@'.$this->getScope();
    }

    /**
     * @param $scopeName
     *
     * @return static
     */
    protected static function createSelfByScope($scopeName){
        $event = new static();
        $event->setScope($scopeName);

        return $event;
    }

}