<?php
namespace Visca\Bundle\LicomBundle\Services\Filters\Rules;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\Interfaces\FilterMatchRuleInterface;

/**
 * Class MatchInProgressRule
 */
class MatchInProgressRule implements FilterMatchRuleInterface
{
    /**
     * @param Match[] $matches Match collections to apply some custom filters
     *
     * @return mixed
     */
    public function setMatchesCollection($matches)
    {
    }

    /**
     * @param Match $match Match
     *
     * @return bool
     */
    public function matchApplyRule(Match $match)
    {
        return $match->isLive();
    }
}
