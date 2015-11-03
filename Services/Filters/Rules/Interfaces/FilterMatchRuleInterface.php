<?php
namespace Visca\Bundle\LicomBundle\Services\Filters\Rules\Interfaces;

use Visca\Bundle\LicomBundle\Entity\Match;

/**
 * Interface FilterMatchRuleInterface
 */
interface FilterMatchRuleInterface
{
    /**
     * @param Match[] $matches Match collections to apply some custom filters
     *
     * @return mixed
     */
    public function setMatchesCollection($matches);

    /**
     * @param Match $match Match
     *
     * @return bool
     */
    public function matchApplyRule(Match $match);
}
