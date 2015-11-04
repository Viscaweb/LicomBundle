<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CompetitionRepository;
use Visca\Bundle\LicomBundle\Repository\ParticipantRepository;

/**
 * Class ParticipantSlugMatcher
 */
class ParticipantSlugMatcher
{
    /**
     * @var ParticipantRepository Participant Repository
     */
    protected $participantRepository;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * ParticipantSlugMatcher constructor.
     *
     * @param ParticipantRepository $participantRepository Participant Repository
     * @param int                   $licomProfileId        App's profile ID
     */
    public function __construct(
        ParticipantRepository $participantRepository,
        $licomProfileId
    ) {
        $this->participantRepository = $participantRepository;
        $this->licomProfileId = $licomProfileId;
    }

    /**
     * @param string  $participantSlug Participant Slug, i.e. 'fc-barcelona'
     * @param Country $country         Country
     *
     * @return Participant
     * @throws NoMatchFoundException
     */
    public function match($participantSlug, Country $country)
    {
        /*
         * Find related participants having this slug
         */
        $participants = $this
            ->participantRepository
            ->findBySlug(
                $this->licomProfileId,
                $participantSlug
            );

        if (empty($participants)) {
            throw new NoMatchFoundException();
        }

        /*
         * Ensure the participant is related to the specified country
         */
        $participantFoundEntity = null;
        foreach ($participants as $participant) {
            $participantCountry = $participant->getCountry();
            if ($participantCountry->getId() == $country->getId()) {
                $participantFoundEntity = $participant;
                break;
            }
        }

        if (!($participantFoundEntity instanceof Participant)) {
            throw new NoMatchFoundException();
        }

        return $participantFoundEntity;
    }
}
