<?php

namespace Visca\Bundle\LicomBundle\Repository\Traits;

use DateTime;
use Visca\Bundle\LicomBundle\Alterer\UTCDateAlterer;

/**
 * Class UTCAltererTrait.
 */
trait UTCAltererTrait
{
    /**
     * @var UTCDateAlterer
     */
    private $utcDateAlterer;

    /**
     * @param UTCDateAlterer $utcDateAlterer UTC Date Alterer
     */
    public function setUtcDateAlterer($utcDateAlterer)
    {
        $this->utcDateAlterer = $utcDateAlterer;
    }

    /**
     * Alter given date objects.
     */
    protected function alterDateObjects()
    {
        if ($this->utcDateAlterer instanceof UTCDateAlterer) {
            /** @var DateTime[] $dateObjects */
            $dateObjects = func_get_args();

            foreach ($dateObjects as $dateObject) {
                $this->utcDateAlterer->alterDateToUtc($dateObject);
            }
        }
    }
}
