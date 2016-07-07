<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Class CountryRepository.
 */
class CountryRepository extends AbstractEntityRepository
{
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

        $profileTopEntriesIds = $profileGraphRepository->findByLabel(
            $sport,
            'top-countries',
            true
        );

        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.id IN (:ids)')
            ->orderBy('FIELD(c.id, :ids)')
            ->setParameter('ids', $profileTopEntriesIds);

        $query = $queryBuilder->getQuery();
        $this->setCacheStrategy($query);

        return $query->getResult();
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
     * @param Sport $sport Sport
     * @param null  $limit Number of country we need
     *
     * @return \Visca\Bundle\LicomBundle\Entity\Country[]
     */
    public function findWithCompetitionAndCountryExistsOrderedByName(Sport $sport, $limit = null)
    {
        // The ids of countries that not exists currently.
        $notExistsIds = [96, 673, 671, 672, 670, 669, 675, 665];

        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->join('c.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.competition', 'competition')
            ->Where('c.id NOT IN (:notExistsIds)')
            ->andWhere('competitionCategory.sport = :sport')
            ->setParameter('notExistsIds',$notExistsIds)
            ->setParameter('sport',$sport)
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

    /**
     * @param array $ids Ids
     *
     * @return Country[]
     */
    public function getAndSortByIds($ids)
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.id IN (:ids)')
            ->orderBy('FIELD(c.id, :ids)')
            ->setParameter('ids', $ids);

        return $queryBuilder->getQuery()->getResult();
    }
}
