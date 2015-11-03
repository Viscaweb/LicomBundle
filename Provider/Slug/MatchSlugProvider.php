<?php
namespace Visca\Bundle\LicomViewBundle\Provider\Slug;

use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Exception\MatchParticipantNotFoundException;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;

/**
 * Class CompetitionSlugProvider
 */
class MatchSlugProvider
{
    const PATTERN = '%s-%s';

    /**
     * @var ParticipantSlugProvider Slug provivder
     */
    protected $participantSlugProvider;

    /**
     * MatchSlugProvider constructor.
     *
     * @param ParticipantSlugProvider $participantSlugProvider Slug provider
     */
    public function __construct(
        ParticipantSlugProvider $participantSlugProvider
    ) {
        $this->participantSlugProvider = $participantSlugProvider;
    }

    /**
     * @param Match $match Match
     *
     * @return null|string
     * @throws \Exception
     * @throws SlugNotAvailableException
     */
    public function getSlug(Match $match)
    {
        /*
         * Trying to retrieve the Participant from this match
         * If we can't, we can't generate the slug.
         */
        try {
            $homeTeam = $match->getHomeParticipant()->getParticipant();
            $awayTeam = $match->getAwayParticipant()->getParticipant();
        } catch (MatchParticipantNotFoundException $ex) {
            throw new SlugNotAvailableException();
        }

        $slugHomeTeam = $this->participantSlugProvider->getSlug($homeTeam);
        $slugAwayTeam = $this->participantSlugProvider->getSlug($awayTeam);
        $slug = sprintf(self::PATTERN, $slugHomeTeam, $slugAwayTeam);

        return $slug;
    }
}
