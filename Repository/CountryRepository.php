<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class CountryRepository.
 */
class CountryRepository extends AbstractEntityRepository
{
    use GetAndSortByIdTrait;

    /**
     * @var ProfileEntityGraphRepository
     */
    protected $repositoryProfileEntityGraph;

    /**
     * @param ProfileEntityGraphRepository $repositoryProfileEntityGraph Repository
     */
    public function setRepositoryProfileEntityGraph(
        ProfileEntityGraphRepository $repositoryProfileEntityGraph
    ) {
        $this->repositoryProfileEntityGraph = $repositoryProfileEntityGraph;
    }

    /**
     * @var LocalizationTranslationRepository
     */
    protected $repositoryLocalizationTranslation;

    /**
     * @param LocalizationTranslationRepository $repositoryLocalizationTranslation Repository
     */
    public function setRepositoryLocalizationTranslation(
        LocalizationTranslationRepository $repositoryLocalizationTranslation
    ) {
        $this->repositoryLocalizationTranslation = $repositoryLocalizationTranslation;
    }

    /**
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('c')->select('c.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        $query = $queryBuilder->getQuery();
        $this->setCacheStrategy($query);

        return $query->getArrayResult();
    }

    /**
     * @param Sport $sport Sport
     *
     * @return Country[]
     */
    public function findTop(Sport $sport)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntries = $profileGraphRepository->findByLabel(
            $sport,
            'top-countries'
        );

        $topCountriesIds = [];
        /** @var ProfileEntityGraph $profileEntityGraph */
        foreach ($profileTopEntries as $profileEntityGraph) {
            $topCountriesIds[] = $profileEntityGraph->getEntityId();
        }

        $topCountries = $this->getAndSortById($topCountriesIds);

        return $topCountries;
    }

    /**
     * @param null $limit Number of country we need
     *
     * @return Country[]
     */
    public function findAllOrderedByName($limit = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');

        if (is_numeric($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        $query = $queryBuilder->getQuery();
        $this->setCacheStrategy($query);

        return $query->getResult();
    }

    /**
     * @param int    $licomProfileId App's profile ID
     * @param string $countrySlug    Country's slug
     *
     * @return Country[]
     */
    public function findBySlug(
        $licomProfileId,
        $countrySlug
    ) {
        $localizationTranslationRepository = $this->repositoryLocalizationTranslation;
        try {
            $countriesSlugTranslations = $localizationTranslationRepository
                ->findByLocalizationAndText(
                    $licomProfileId,
                    LocalizationTranslationTypeCode::COUNTRY_SLUG_CODE,
                    [$countrySlug]
                );
        } catch (NoTranslationFoundException $ex) {
            return null;
        }

        $countriesIds = [];
        foreach ($countriesSlugTranslations as $translation) {
            $countriesIds[] = $translation->getEntityId();
        }

        return $this->findBy(['id' => $countriesIds]);
    }
}