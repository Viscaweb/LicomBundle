<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
use Visca\Bundle\LicomBundle\Entity\Code\MatchResultTypeCode;
use Visca\Bundle\LicomBundle\Entity\MatchResult;

/**
 * Class MatchResultByKeyTrait.
 */
trait MatchResultByKeyTrait
{
    /**
     * @param int  $key     The id for the aux required.
     * @param null $default The default value if the aux is not found.
     *
     * @return mixed
     */
    public function getMatchResultValueByKey($key, $default = null)
    {
        $resultCollection = $this->getMatchResult();

        foreach ($resultCollection as $matchResult) {
            /** @var MatchResult $matchResult */
            if ($matchResult->getMatchResultType()->getId() == $key) {
                return $matchResult->getValue();
            }
        }

        return $default;
    }

    /**
     * @return Collection
     */
    abstract public function getMatchResult();

    /**
     * Will return the Extra time + The ordinary time results.
     *
     * @return null|string
     */
    public function getRunningExtraTimeResult()
    {
        $resultCollection = $this->getMatchResult();
        $ordinaryTimeResult = $extraTimeResult = null;
        // Search for the results
        foreach ($resultCollection as $matchResult) {
            /** @var MatchResult $matchResult */
            if ($matchResult->getMatchResultType()->getId() == MatchResultTypeCode::ORDINARY_TIME_CODE) {
                $ordinaryTimeResult = $matchResult->getValue();
            }
            if ($matchResult->getMatchResultType()->getId() == MatchResultTypeCode::EXTRA_TIME_CODE) {
                $extraTimeResult = $matchResult->getValue();
            }
        }

        // Sum the two results and return it
        if (!is_null($ordinaryTimeResult) && !is_null($extraTimeResult)) {
            return $ordinaryTimeResult + $extraTimeResult;
        }

        // If one of them is null, or both, return ordinary time if not null.
        // If extra time is null, will return null

        return !is_null($ordinaryTimeResult) ? $ordinaryTimeResult : $extraTimeResult;
    }
}
