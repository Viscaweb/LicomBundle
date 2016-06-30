<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CountryRepository;
use Psr\Log\LoggerInterface;

/**
 * Class CountrySlugMatcher
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
     * @param int               $licomProfileId    App's profile ID
     * @param LoggerInterface   $logger            Logger
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
     * @param Sport  $sport       Sport
     *
     * @return Country
     * @throws NoMatchFoundException
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
            $this->logger->debug(
                "Unable to find any Country with the given slug ($countrySlug given)."
            );
            throw new NoMatchFoundException();
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
            $this->logger->debug(
                "Unable to find any Country with the given slug ($countrySlug given)."
            );
            throw new NoMatchFoundException();
        }

        return $countryFoundEntity;
    }
}
