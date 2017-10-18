<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Psr\Log\LoggerInterface;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CompetitionRepository;

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
    public function match($competitionSlug, Country $country): Competition
    {
        /* Find related competitions having this slug */
        $competitions = $this
            ->competitionRepository
            ->findBySlug(
                $this->licomProfileId,
                $competitionSlug
            );

        if (empty($competitions)) {
            $this->noMatchFoundException($competitionSlug);
        }

        /* Ensure the competition is related to the specified country */
        foreach ($competitions as $competition) {
            $competitionCountry = $competition->getCompetitionCategory()->getCountry();
            if ($competitionCountry->getId() === $country->getId()) {
                return $competition;
            }
        }

        /* Otherwise, if only one country uses this slug, we make the redirection anyway */
        $countriesIds = [];
        foreach ($competitions as $competition) {
            $countriesIds[$competition->getCompetitionCategory()->getCountry()->getId()] = 1;
        }
        if (count($countriesIds) === 1) {
            return reset($competitions);
        }

        $this->noMatchFoundException($competitionSlug);
    }

    /**
     * @param $competitionSlug
     *
     * @throws NoMatchFoundException
     */
    protected function noMatchFoundException($competitionSlug)
    {
        $message = "Unable to find any Competition with the given slug ($competitionSlug given).";
        $this->logger->debug($message);
        throw new NoMatchFoundException($message);
    }
}
