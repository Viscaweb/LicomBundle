<?php

namespace Visca\Bundle\LicomBundle\Entity\Traits;

use Doctrine\Common\Collections\Collection;
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
}
