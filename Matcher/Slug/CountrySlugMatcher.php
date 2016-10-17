<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Psr\Log\LoggerInterface;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CountryRepository;

/**
 * Class CountrySlugMatcher.
 */
class CountrySlugMatcher
{
    /**
     * @var CountryRepository Country Repository
     */
    protected $countryRepository;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * CountrySlugMatcher constructor.
     *
     * @param CountryRepository $countryRepository Country Repository
     * @param int $licomProfileId App's profile ID
     * @param LoggerInterface $logger Logger
     */
    public function __construct(
        CountryRepository $countryRepository,
        $licomProfileId,
        LoggerInterface $logger
    ) {
        $this->countryRepository = $countryRepository;
        $this->licomProfileId = $licomProfileId;
        $this->logger = $logger;
    }

    /**
     * @param string $countrySlug Country Slug, i.e. 'spain'
     * @param Sport $sport Sport
     *
     * @throws NoMatchFoundException
     *
     * @return Country
     */
    public function match($countrySlug, Sport $sport)
    {
        /*
         * Find related countries having this slug
         */
        $countries = $this
            ->countryRepository
            ->findBySlug(
                $this->licomProfileId,
                $countrySlug
            );

        if (empty($countries)) {
            $this->noMatchFoundException($countrySlug);
        }

        /*
         * Ensure the country is related to the specified sport
         */
        $countryFoundEntity = null;
        foreach ($countries as $country) {
            $competitionCategories = $country->getCompetitionCategory();
            foreach ($competitionCategories as $competitionCategory) {
                $competitionCategorySport = $competitionCategory->getSport();
                if ($competitionCategorySport->getId() == $sport->getId()) {
                    $countryFoundEntity = $country;
                    break 2;
                }
            }
        }

        if (!($countryFoundEntity instanceof Country)) {
            $this->noMatchFoundException($countrySlug);
        }

        return $countryFoundEntity;
    }

    /**
     * @param $countrySlug
     * @throws NoMatchFoundException
     */
    private function noMatchFoundException($countrySlug)
    {
        $message = "Unable to find any Country with the given slug ($countrySlug given).";
        $this->logger->debug($message);
        throw new NoMatchFoundException($message);
    }
}
