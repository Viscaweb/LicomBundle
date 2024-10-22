<?php

namespace Visca\Bundle\LicomBundle\Services\Filters;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Services\Filters\Rules\Interfaces\FilterMatchRuleInterface;

/**
 * The aim of this service is to extract from a Match collection the match
 * the most relevant to be displayed using basic rules.
 *
 * We usually give a collection of Match from the same MatchParticipant,
 * and this class has to filter the matches to find, in the order:
 *  1. A match which is in progress,
 *  2. If not, the last match played (in the last 8 days),
 *  3. If not, the next match to come,
 *  4. If not, the last match played,
 *  5. If not, the first match of the list.
 *
 * @TODO This class will be deprecated, when LIVE team implements it inside LIVE
 *
 * Class MatchMostRelevantFilter
 */
class MatchMostRelevantFilter
{
    /**
     * @var FilterMatchRuleInterface[]
     */
    protected $rules;

    /**
     * MatchMostRelevantFilter constructor.
     *
     * @param FilterMatchRuleInterface[] $rules Rules to use
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param Match[] $matches Matches collection
     *
     * @throws NoMatchFoundException
     *
     * @return Match
     */
    public function filter($matches)
    {
        if (empty($matches)) {
            throw new NoMatchFoundException();
        }

        foreach ($this->getRules() as $ruler) {
            $ruler->setMatchesCollection($matches);
            foreach ($matches as $match) {
                if ($ruler->matchApplyRule($match)) {
                    return $match;
                }
            }
        }

        /** @var Match $defaultMatch */
        $defaultMatch = reset($matches);

        return $defaultMatch;
    }

    /**
     * @return Rules\Interfaces\FilterMatchRuleInterface[]
     */
    public function getRules()
    {
        return $this->rules;
    }
}
