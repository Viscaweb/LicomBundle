<?php

namespace Visca\Bundle\LicomBundle\Listener;

use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Visca\Bundle\LicomBundle\Alterer\UTCDateAlterer;
use Visca\Bundle\LicomBundle\Cache\UTCDateFieldsWarmer;

/**
 * Class TranslationInjectorListener.
 */
class DateTimeAltererListener
{
    /**
     * @var \Visca\Bundle\DoctrineBundle\Alterer\UTCDateAlterer Date Time Alterer
     */
    private $dateTimeAlterer;

    /**
     * @var string Cache directory
     */
    private $cacheDirectory;

    /**
     * DateTimeAltererListener constructor.
     *
     * @param \Visca\Bundle\LicomBundle\Alterer\UTCDateAlterer $dateTimeAlterer Date Alterer
     * @param string                                           $cacheDirectory  Cache Directory
     */
    public function __construct(
        UTCDateAlterer $dateTimeAlterer,
        $cacheDirectory
    ) {
        $this->dateTimeAlterer = $dateTimeAlterer;
        $this->cacheDirectory = $cacheDirectory;
    }

    /**
     * @param LifecycleEventArgs $args Event
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        /*
         * Get date fields to alter
         */
        $dateProperties = $this->getDateProperties($entity);
        foreach ($dateProperties as $property) {
            $propertyGetter = $this->findGetter($entity, $property);
            if ($propertyGetter !== false) {
                $dateField = $entity->$propertyGetter();

                /*
                 * We need to check if the given value is a DateTime.
                 * It can be null if no data is provided.
                 */
                if ($dateField instanceof DateTime) {
                    $this->dateTimeAlterer->alterDateFromUtc($dateField);
                }
            }
        }
    }

    /**
     * @param $object
     *
     * @return array
     */
    private function getDateProperties($object)
    {
        $cacheFile = $this->cacheDirectory.'/'.UTCDateFieldsWarmer::FILENAME;

        if (!is_file($cacheFile)) {
            return [];
        }

        $objectName = $this->getObjectName($object);
        if ($objectName === false) {
            return [];
        }

        $utcDateFields = require $cacheFile;
        if (!isset($utcDateFields[$objectName])) {
            return [];
        }

        return $utcDateFields[$objectName];
    }

    /**
     * @param object $object Object
     *
     * @return string|bool
     */
    private function getObjectName($object)
    {
        $objectNamespace = get_class($object);

        $objectNameParts = explode('\\', $objectNamespace);
        $objectName = end($objectNameParts);

        return is_string($objectName) ? $objectName : false;
    }

    /**
     * @param mixed  $object
     * @param string $property
     *
     * @return bool|string
     */
    private function findGetter($object, $property)
    {
        $setterSupposedName = 'get'.ucfirst($property);

        return is_callable(
            [$object, $setterSupposedName]
        ) ? $setterSupposedName : false;
    }
}
