<?php
namespace Visca\Bundle\LicomBundle\Services\Filters\Rules;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\Interfaces\FilterMatchRuleInterface;

/**
 * This service will retrieve the last match played in the last X days.
 *
 * Class MatchLastPlayedRule
 */
class MatchLastPlayedRule implements FilterMatchRuleInterface
{
    /**
     * @var int|null Last played in the last X days
     */
    protected $numbersOfDays;

    /**
     * @var \DateTime Current Time
     */
    protected $currentTime;

    /**
     * @var Match
     */
    protected $lastMatchPlayed;

    /**
     * MatchLastPlayedRule constructor.
     *
     * @param int|null $numbersOfDays Number of days
     */
    public function __construct($numbersOfDays = null)
    {
        $this->numbersOfDays = $numbersOfDays;
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
         * Keep only the finished matches and played in the last X days
         */
        $finishedMatches = [];
        foreach ($matches as $i => $match) {
            $matchFinished = $match->isFinished();
            $matchPlayedRecently = $this->matchPlayedRecently($match);
            if ($matchFinished && $matchPlayedRecently) {
                $finishedMatches[] = $match;
            }
        }
        if (!empty($finishedMatches)) {
            /*
             * Sort the matches
             */
            usort($finishedMatches, [$this, 'sortMatchesByDate']);

            /*
             * Keep only the last played matches
             */
            $this->lastMatchPlayed = $finishedMatches[0];
        }
    }

    /**
     * @param Match $match Match
     *
     * @return bool
     */
    private function matchPlayedRecently(Match $match)
    {
        if ($this->numbersOfDays === null) {
            return true;
        }

        $matchTimeDiff = $this->currentTime->diff($match->getStartDate());
        $matchTimeDiffInDays = $matchTimeDiff->days;
        if ($this->numbersOfDays >= $matchTimeDiffInDays) {
            return true;
        }

        return false;
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

        return $dateMatchA < $dateMatchB ? 1 : -1;
    }

    /**
     * @param Match $match Match
     *
     * @return bool
     */
    public function matchApplyRule(Match $match)
    {
        if (!($this->lastMatchPlayed instanceof Match)) {
            return false;
        }

        return ($this->lastMatchPlayed->getId() == $match->getId());
    }
}
