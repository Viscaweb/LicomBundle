<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CompetitionRepository;

/**
 * Class CompetitionSlugMatcher
 */
class CompetitionSlugMatcher
{
    /**
     * @var CompetitionRepository Competition Repository
     */
    protected $competitionRepository;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * CompetitionSlugMatcher constructor.
     *
     * @param CompetitionRepository $competitionRepository Competition Repository
     * @param int                   $licomProfileId        App's profile ID
     */
    public function __construct(
        CompetitionRepository $competitionRepository,
        $licomProfileId
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->licomProfileId = $licomProfileId;
    }

    /**
     * @param string  $competitionSlug Competition Slug, i.e. 'liga'
     * @param Country $country         Country
     *
     * @return Competition
     * @throws NoMatchFoundException
     */
    public function match($competitionSlug, Country $country)
    {
        /*
         * Find related competitions having this slug
         */
        $competitions = $this
            ->competitionRepository
            ->findBySlug(
                $this->licomProfileId,
                $competitionSlug
            );

        if (empty($competitions)) {
            throw new NoMatchFoundException();
        }

        /*
         * Ensure the competition is related to the specified country
         */
        $competitionFoundEntity = null;
        foreach ($competitions as $competition) {
            $competitionCountry = $competition
                ->getCompetitionCategory()
                ->getCountry();
            if ($competitionCountry->getId() == $country->getId()) {
                $competitionFoundEntity = $competition;
                break;
            }
        }

        if (!($competitionFoundEntity instanceof Competition)) {
            throw new NoMatchFoundException();
        }

        return $competitionFoundEntity;
    }
}
