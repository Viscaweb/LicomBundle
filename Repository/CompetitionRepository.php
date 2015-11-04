<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Repository\Traits\GetAndSortByIdTrait;

/**
 * Class CompetitionRepository.
 */
class CompetitionRepository extends AbstractEntityRepository
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
     * @param int $countryId Id of the country to get
     *
     * @returns Competition[]
     */
    public function findByCountry($countryId)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->join('c.competitionCategory', 'cc')
            ->where('cc.country = :countryId')
            ->setParameter('countryId', $countryId);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int      $countryId Country Id
     * @param int      $sportId   Sport Id
     * @param int|bool $limit     Limit number
     *
     * @return array
     */
    public function findByCountryAndSport($countryId, $sportId, $limit = false)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->join('c.competitionCategory', 'cc')
            ->where('cc.country = :countryId')
            ->andWhere('cc.sport = :sportId')
            ->setParameter('countryId', $countryId)
            ->setParameter('sportId', $sportId);

        // set the limit number of competitions to get
        if ($limit !== false && is_numeric($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
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

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @param int $id Id
     *
     * @return Competition | null
     */
    public function findOneWithJoins($id)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->select(
                'c, competitionCategory, country, competitionSeasons'
            )
            ->join('c.competitionCategory', 'competitionCategory')
            ->join('competitionCategory.country', 'country')
            ->leftJoin('c.competitionSeason', 'competitionSeasons')
            ->where('c.id = :competitionId')
            ->setParameter('competitionId', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param Sport    $sport Sport
     * @param int|null $limit Limit of results
     *
     * @return Competition[]
     */
    public function findTop(Sport $sport, $limit = null)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntries = $profileGraphRepository->findByLabel(
            $sport,
            'top-competitions',
            $limit
        );
        $topCompetitionsIds = [];
        /** @var ProfileEntityGraph $profileEntityGraph */
        foreach ($profileTopEntries as $profileEntityGraph) {
            $topCompetitionsIds[] = $profileEntityGraph->getEntityId();
        }

        $topCompetitions = $this->getAndSortById($topCompetitionsIds);

        return $topCompetitions;
    }

    /**
     * @param int    $licomProfileId  App's profile ID
     * @param string $competitionSlug Competition's slug
     *
     * @return Competition[]
     */
    public function findBySlug(
        $licomProfileId,
        $competitionSlug
    ) {
        $localizationTranslationRepository = $this->repositoryLocalizationTranslation;
        try {
            $competitionsSlugTranslations = $localizationTranslationRepository
                ->findByProfileAndText(
                    $licomProfileId,
                    LocalizationTranslationTypeCode::COMPETITION_SLUG_CODE,
                    ProfileTranslationGraphLabelCode::SLUG_CODE,
                    [$competitionSlug]
                );
        } catch (NoTranslationFoundException $ex) {
            return null;
        }

        $competitionsIds = [];
        foreach ($competitionsSlugTranslations as $translation) {
            $competitionsIds[] = $translation->getEntityId();
        }

        return $this->findBy(['id' => $competitionsIds]);
    }
}
