<?php

namespace Visca\Bundle\LicomBundle\Services\Filters\Rules;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\Interfaces\FilterMatchRuleInterface;

/**
 * This service ensure that the given Match is the first next match
 * that will be played in the given Match collection.
 *
 * Class MatchNextToComeRule
 */
class MatchNextToComeRule implements FilterMatchRuleInterface
{
    /**
     * @var \DateTime Current Time
     */
    protected $currentTime;

    /**
     * @var Match
     */
    protected $nextMatch;

    /**
     * MatchLastPlayedRule constructor.
     */
    public function __construct()
    {
        $this->currentTime = new \DateTime();
    }

    /**
     * @param Match[] $matches Match collections to apply some custom filters
     *
     * @return mixed
     */
    public function setMatchesCollection($matches)
    {
        /*
         * Keep only the future matches
         */
        $futureMatches = [];
        foreach ($matches as $i => $match) {
            $matchFinished = $match->isFinished();
            $matchFuture = $this->isInTheFuture($match);
            if (!$matchFinished && $matchFuture) {
                $futureMatches[] = $match;
            }
        }
        if (!empty($futureMatches)) {
            /*
             * Sort the matches
             */
            usort($futureMatches, [$this, 'sortMatchesByDate']);

            /*
             * Keep only the next match to come
             */
            $this->nextMatch = $futureMatches[0];
        }
    }

    /**
     * @param Match $matchA First match to compare
     * @param Match $matchB Second match to compare
     *
     * @return int
     */
    protected function sortMatchesByDate($matchA, $matchB)
    {
        $dateMatchA = $matchA->getStartDate();
        $dateMatchB = $matchB->getStartDate();

        if ($dateMatchA == $dateMatchB) {
            return 0;
        }

        return $dateMatchA > $dateMatchB ? 1 : -1;
    }

    /**
     * @param Match $match Match
     *
     * @return bool
     */
    public function matchApplyRule(Match $match)
    {
        if (!($this->nextMatch instanceof Match)) {
            return false;
        }

        return ($this->nextMatch->getId() == $match->getId());
    }

    /**
     * @param Match $match
     *
     * @return bool
     */
    private function isInTheFuture(Match $match)
    {
        $matchTimeDiff = $this->currentTime->diff($match->getStartDate());

        return ($matchTimeDiff->invert === 0);
    }
}
