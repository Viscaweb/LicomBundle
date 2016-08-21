<?php
namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Doctrine\Tests\ORM\Functional\Ticket\Participant;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Matcher\Slug\Helper\FindTeamsCombinationsHelper;
use Visca\Bundle\LicomBundle\Model\Slug\ParticipantCombinationModel;
use Visca\Bundle\LicomBundle\Repository\MatchRepository;
use Visca\Bundle\LicomBundle\Services\Filters\MatchMostRelevantFilter;
use Psr\Log\LoggerInterface;

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
     * @var MatchMostRelevantFilter Match most revelant filter
     */
    protected $matchMostRelevantFilter;

    /**
     * @var FindTeamsCombinationsHelper Participant Combination Finder
     */
    protected $participantCombinationsHelper;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * MatchSlugMatcher constructor.
     *
     * @param MatchRepository                   $matchRepository                Match Repository
     * @param ParticipantCombinationSlugMatcher $participantsCombinationMatcher Participant Combination Matcher
     * @param MatchMostRelevantFilter           $matchMostRelevantFilter        Match most revelant filter
     * @param FindTeamsCombinationsHelper       $participantCombinationsHelper  Participant Combination Finder
     * @param int                               $licomProfileId                 App's profile ID
     * @param LoggerInterface                   $logger                         Logger
     */
    public function __construct(
        MatchRepository $matchRepository,
        ParticipantCombinationSlugMatcher $participantsCombinationMatcher,
        MatchMostRelevantFilter $matchMostRelevantFilter,
        FindTeamsCombinationsHelper $participantCombinationsHelper,
        $licomProfileId,
        LoggerInterface $logger
    ) {
        $this->matchRepository = $matchRepository;
        $this->participantsCombinationMatcher = $participantsCombinationMatcher;
        $this->matchMostRelevantFilter = $matchMostRelevantFilter;
        $this->participantCombinationsHelper = $participantCombinationsHelper;
        $this->licomProfileId = $licomProfileId;
        $this->logger = $logger;
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
        $participantCombinations = null;
        foreach ($combinations as $combination) {
            try {
                $participantCombinations = $this
                    ->participantsCombinationMatcher
                    ->getParticipantCombinations(
                        $competition->getCompetitionCategory()->getSport(),
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
        if ($participantCombinations === null) {
            $this->logger->debug(
                "Unable to find any combinations of two participants with the given slug ($matchSlug given)."
            );
            throw new NoMatchFoundException();
        }

        /*
         * Try to find the related match
         */
        $matchesCollection = [];
        foreach ($participantCombinations as $participantCombination) {
            $matches = $this
                ->matchRepository
                ->findMatchByParticipants(
                    [$participantCombination->getHomeParticipant()],
                    [$participantCombination->getAwayParticipant()]
                );
            $matchesCollection = array_merge($matchesCollection, $matches);
        }
        if (empty($matchesCollection)) {
            $this->logger->debug("Unable to find any match with the two participants detected.");
            throw new NoMatchFoundException();
        }

        /*
         * Filter the match on the given competition
         */
        $competitionMatchCollection = $this->filterByGivenCompetition(
            $matchesCollection,
            $competition
        );

        return $this->getBestMatch($competitionMatchCollection);
    }

    /**
     * @param array $matches
     *
     * @return Match
     * @throws NoMatchFoundException
     */
    public function getBestMatch(array $matches)
    {
        /**
         * Take the best match to display in this list
         */
        try {
            $bestMatch = $this->matchMostRelevantFilter->filter(
                $matches
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
    public function filterByGivenCompetition(
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

        if (empty($competitionMatchCollection)) {
            throw new NoMatchFoundException();
        }

        return $competitionMatchCollection;
    }
}
