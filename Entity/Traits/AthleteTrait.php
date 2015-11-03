<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Visca\Bundle\LicomBundle\Entity\Code\ParticipantAuxTypeCode;

/**
 * Class AthleteTrait.
 */
trait AthleteTrait
{
    /**
     * @param int  $key     Key
     * @param null $default Default
     *
     * @return string
     */
    abstract public function getAuxByKey($key, $default = null);

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getAuxByKey(ParticipantAuxTypeCode::FIRST_NAME_CODE);
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getAuxByKey(ParticipantAuxTypeCode::LAST_NAME_CODE);
    }

    /**
     * @return \Datetime | null
     */
    public function getBirthday()
    {
        $date = $this->getAuxByKey(ParticipantAuxTypeCode::DATE_OF_BIRTH_CODE);

        if (!$date) {
            return;
        }

        $convertedDate = \DateTime::createFromFormat('Y-m-d', $date);

        if (!$convertedDate instanceof \DateTime) {
            throw new \RuntimeException(
                'Unable to convert the date provided in by ParticipantAuxTypeCode'
            );
        }
        $convertedDate->setTime(0, 0, 0);

        return $convertedDate;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->getAuxByKey(ParticipantAuxTypeCode::HEIGHT_CODE);
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->getAuxByKey(ParticipantAuxTypeCode::WEIGHT_CODE);
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->getAuxByKey(ParticipantAuxTypeCode::POSITION_CODE);
    }
}
