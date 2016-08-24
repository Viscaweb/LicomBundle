<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CompetitionRepository;
use Psr\Log\LoggerInterface;

/**
 * Class CompetitionSlugMatcher.
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
     * @var LoggerInterface
     */
    protected $logger;


    /**
     * CompetitionSlugMatcher constructor.
     *
     * @param CompetitionRepository $competitionRepository Competition Repository
     * @param int                   $licomProfileId        App's profile ID
     * @param LoggerInterface       $logger                LOgger
     */
    public function __construct(
        CompetitionRepository $competitionRepository,
        $licomProfileId,
        LoggerInterface $logger
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->licomProfileId = $licomProfileId;
        $this->logger = $logger;
    }

    /**
     * @param string  $competitionSlug Competition Slug, i.e. 'liga'
     * @param Country $country         Country
     *
     * @throws NoMatchFoundException
     *
     * @return Competition
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
            $this->logger->debug(
                "Unable to find any Competition with the given slug ($competitionSlug given)."
            );
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
            $this->logger->debug(
                "Unable to find any Competition with the given slug ($competitionSlug given)."
            );
            throw new NoMatchFoundException();
        }

        return $competitionFoundEntity;
    }
}
