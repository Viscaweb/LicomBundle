<?php

namespace Visca\Bundle\LicomViewBundle\Wrapper;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomViewBundle\Provider\Slug\CompetitionCategorySlugProvider;
use Visca\Bundle\LicomViewBundle\Provider\Slug\CompetitionSlugProvider;
use Visca\Bundle\LicomViewBundle\Provider\Slug\CountrySlugProvider;
use Visca\Bundle\LicomViewBundle\Provider\Slug\MatchSlugProvider;
use Visca\Bundle\LicomViewBundle\Provider\Slug\ParticipantSlugProvider;

/**
 * Class SlugWrapper
 */
class SlugWrapper
{
    /**
     * @var CompetitionSlugProvider
     */
    protected $competitionSlugProvider;

    /**
     * @var CountrySlugProvider
     */
    protected $countrySlugProvider;

    /**
     * @var ParticipantSlugProvider
     */
    protected $participantSlugProvider;

    /**
     * @var CompetitionCategorySlugProvider
     */
    protected $competitionCategorySlugProvider;

    /**
     * @var MatchSlugProvider
     */
    protected $matchSlugProvider;

    /**
     * SlugWrapper constructor.
     *
     * @param CompetitionSlugProvider         $competitionSlugProvider         Slug Provider
     * @param CountrySlugProvider             $countrySlugProvider             Slug Provider
     * @param ParticipantSlugProvider         $participantSlugProvider         Slug Provider
     * @param CompetitionCategorySlugProvider $competitionCategorySlugProvider Slug Provider
     * @param MatchSlugProvider               $matchSlugProvider               Slug Provider
     */
    public function __construct(
        CompetitionSlugProvider $competitionSlugProvider,
        CountrySlugProvider $countrySlugProvider,
        ParticipantSlugProvider $participantSlugProvider,
        CompetitionCategorySlugProvider $competitionCategorySlugProvider,
        MatchSlugProvider $matchSlugProvider
    ) {
        $this->competitionSlugProvider = $competitionSlugProvider;
        $this->countrySlugProvider = $countrySlugProvider;
        $this->participantSlugProvider = $participantSlugProvider;
        $this->competitionCategorySlugProvider = $competitionCategorySlugProvider;
        $this->matchSlugProvider = $matchSlugProvider;
    }

    /**
     * @return CompetitionSlugProvider
     */
    public function getCompetitionSlugProvider()
    {
        return $this->competitionSlugProvider;
    }

    /**
     * @return CountrySlugProvider
     */
    public function getCountrySlugProvider()
    {
        return $this->countrySlugProvider;
    }

    /**
     * @return ParticipantSlugProvider
     */
    public function getParticipantSlugProvider()
    {
        return $this->participantSlugProvider;
    }

    /**
     * @return CompetitionCategorySlugProvider
     */
    public function getCompetitionCategorySlugProvider()
    {
        return $this->competitionCategorySlugProvider;
    }

    /**
     * @return MatchSlugProvider
     */
    public function getMatchSlugProvider()
    {
        return $this->matchSlugProvider;
    }

    /**
     * @param mixed $entity Entity
     *
     * @return CompetitionSlugProvider|CountrySlugProvider|ParticipantSlugProvider|MatchSlugProvider
     * @throws \Exception
     */
    public function getSlugProvider($entity)
    {
        switch (true) {
            case ($entity instanceof Competition):
                $slugProvider = $this->getCompetitionSlugProvider();
                break;
            case ($entity instanceof CompetitionCategory):
                $slugProvider = $this->getCompetitionCategorySlugProvider();
                break;
            case ($entity instanceof Country):
                $slugProvider = $this->getCountrySlugProvider();
                break;
            case ($entity instanceof Participant):
                $slugProvider = $this->getParticipantSlugProvider();
                break;
            case ($entity instanceof Match):
                $slugProvider = $this->getMatchSlugProvider();
                break;
            default:
                throw new \Exception(
                    sprintf(
                        'No slug provider found for the given entity ("%s" given).',
                        get_class($entity)
                    )
                );
        }

        return $slugProvider;
    }
}
