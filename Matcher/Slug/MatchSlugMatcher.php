<?php
namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Doctrine\Tests\ORM\Functional\Ticket\Participant;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Matcher\Slug\Helper\FindTeamsCombinationsHelper;
use Visca\Bundle\LicomBundle\Model\Slug\ParticipantCombinationModel;
use Visca\Bundle\LicomBundle\Repository\MatchRepository;
use Visca\Bundle\LicomBundle\Services\Filters\MatchMostRevelantFilter;

/**
 * Class MatchSlugMatcher
 *
 *
 * THE PROBLEM
 * ---
 * Why do we try to match the slug of the Match, and not for the team home and the team away?
 * Simply because sometimes we don't really know which part of the slug is related to
 * the team home and which one to the team away.
 *
 * Imagine the URL: /foot/spain/liga/fc-barcelona-madrid.html
 * We don't know what's the slug for the team home, it could be:
 *  - fc
 *  - fc-barcelona
 *  - fc-barcelona-madrid
 *
 * You see? There is no way to really detect it.
 *
 *
 * OUR SOLUTION
 * ---
 * Description:
 *  - We generate all the combinations that could exists:
 *      - Combination A: "fc" + "barcelona-madrid"
 *      - Combination B: "fc-barcelona" + "madrid"
 *  - Try to match the teams and create a ParticipantCombinationModel object
 *  - Once found, try to find the related matches.
 */
class MatchSlugMatcher
{
    /**
     * @var MatchRepository Match Repository
     */
    protected $matchRepository;

    /**
     * @var ParticipantCombinationSlugMatcher Participants matcher
     */
    protected $participantsCombinationMatcher;

    /**
     * @var MatchMostRevelantFilter Match most revelant filter
     */
    protected $matchMostRevelantFilter;

    /**
     * @var FindTeamsCombinationsHelper Participant Combination Finder
     */
    protected $participantCombinationsHelper;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * MatchSlugMatcher constructor.
     *
     * @param MatchRepository                   $matchRepository                Match Repository
     * @param ParticipantCombinationSlugMatcher $participantsCombinationMatcher Participant Combination Matcher
     * @param MatchMostRevelantFilter           $matchMostRevelantFilter        Match most revelant filter
     * @param FindTeamsCombinationsHelper       $participantCombinationsHelper  Participant Combination Finder
     * @param int                               $licomProfileId                 App's profile ID
     */
    public function __construct(
        MatchRepository $matchRepository,
        ParticipantCombinationSlugMatcher $participantsCombinationMatcher,
        MatchMostRevelantFilter $matchMostRevelantFilter,
        FindTeamsCombinationsHelper $participantCombinationsHelper,
        $licomProfileId
    ) {
        $this->matchRepository = $matchRepository;
        $this->participantsCombinationMatcher = $participantsCombinationMatcher;
        $this->matchMostRevelantFilter = $matchMostRevelantFilter;
        $this->participantCombinationsHelper = $participantCombinationsHelper;
        $this->licomProfileId = $licomProfileId;
    }

    /**
     * @param string      $matchSlug   Match Slug, i.e. 'fc-barcelona-madrid'
     * @param Competition $competition Competition
     *
     * @return Match
     * @throws NoMatchFoundException
     */
    public function match($matchSlug, Competition $competition)
    {
        /*
         * Find all possible combinations
         */
        $combinations = $this->participantCombinationsHelper->findCombinations(
            $matchSlug
        );

        /*
         * Try to find what's the participants related to this slug
         */
        $participantCombination = null;
        foreach ($combinations as $combination) {
            try {
                $participantCombination = $this
                    ->participantsCombinationMatcher
                    ->getParticipantCombination(
                        $this->licomProfileId,
                        $combination[0],
                        $combination[1]
                    );
            } catch (NoMatchFoundException $ex) {
                /*
                 * Try the next occurrence
                 */
            }
        }
        if ($participantCombination === null) {
            throw new NoMatchFoundException();
        }

        /*
         * Try to find the related match
         */
        $matchCollection = $this
            ->matchRepository
            ->findMatchByParticipants(
                [$participantCombination->getHomeParticipant()],
                [$participantCombination->getAwayParticipant()]
            );
        if (empty($matchCollection)) {
            throw new NoMatchFoundException();
        }

        /*
         * Filter the match on the given competition
         */
        $competitionMatchCollection = $this->filterByGivenCompetition(
            $matchCollection,
            $competition
        );
        if (empty($competitionMatchCollection)) {
            throw new NoMatchFoundException();
        }

        /**
         * Take the best match to display in this list
         */
        try {
            $bestMatch = $this->matchMostRevelantFilter->filter(
                $competitionMatchCollection
            );
        } catch (NoMatchFoundException $ex) {
            throw $ex;
        }

        return $bestMatch;
    }

    /**
     * For the moment, we are filtering the match by competition in PHP, and not in the SQL query.
     *
     * Pros:
     *  => No need to complicate the findMatchByParticipant method
     *  => The SQL query is lighter
     *  => The cache over the query will be used for two requests of the same match in different competition.
     *  (example: 'FC Barcelona. vs Madrid' in Liga, and in Champion's League)
     *
     * Cons:
     *  => More PHP consumption
     *  => More memory consumption
     *
     * Note: we use this method for now to not complicate the process.
     * We will improve this method depending on how it react in production.
     *
     * @param Match[]     $matchCollection Matches
     * @param Competition $competition     Competition we want to filter by
     *
     * @return Match[]
     */
    private function filterByGivenCompetition(
        array $matchCollection,
        Competition $competition
    ) {
        $competitionMatchCollection = [];
        foreach ($matchCollection as $match) {
            $matchCompetition = $match
                ->getCompetitionSeasonStage()
                ->getCompetitionSeason()
                ->getCompetition();
            if ($matchCompetition->getId() == $competition->getId()) {
                $competitionMatchCollection[] = $match;
            }
        }

        return $competitionMatchCollection;
    }
}
