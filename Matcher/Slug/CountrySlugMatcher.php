<?php

namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Repository\CountryRepository;

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
     * CountrySlugMatcher constructor.
     *
     * @param CountryRepository $countryRepository Country Repository
     * @param int               $licomProfileId    App's profile ID
     */
    public function __construct(
        CountryRepository $countryRepository,
        $licomProfileId
    ) {
        $this->countryRepository = $countryRepository;
        $this->licomProfileId = $licomProfileId;
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
            throw new NoMatchFoundException();
        }

        return $countryFoundEntity;
    }
}
