<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class CompetitionRepository.
 */
class CompetitionRepository extends AbstractEntityRepository
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
     * @param int $countryId Id of the country to get
     *
     * @return Competition[]
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
     * Gets the most important competitions of a country, sorted by importance.
     *
     * @param Team $team
     * @param int  $limit Number of competitions to get.
     */
    public function findMostImportantByTeam(Team $team, $limit = 1)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->join('c.competitionCategory', 'cc')
            ->join('c.competitionSeason', 'cs')
            ->join('cs.competitionSeasonStage', 'css')
            ->join('css.match', 'm')
            ->join('m.matchParticipant', 'mp', Join::WITH, 'mp.participant = :participant')
            ->where('cs.end IS NULL')
            ->orWhere('cs.end > CURRENT_TIMESTAMP()')
            ->setParameters([
                'participant' => $team->getId()
            ])

            // This query returns a register for every match found, too many registers.
            // If we group by competition.id, we may get
            ->groupBy('cs.id')

            ->orderBy('c.positionInsideCategory', 'ASC')
            ->setMaxResults($limit);

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

        $profileTopEntriesIds = $profileGraphRepository->findByLabel(
            $sport,
            'top-competitions',
            true,
            $limit
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
            return;
        }

        $competitionsIds = [];
        foreach ($competitionsSlugTranslations as $translation) {
            $competitionsIds[] = $translation->getEntityId();
        }

        return $this->findBy(['id' => $competitionsIds]);
    }

    /**
     * @param Country $country Country entity
     * @param Sport   $sport   Sport entity
     *
     * @return Competition|null
     */
    public function findMainCompetitionByCountryAndSport(
        Country $country,
        Sport $sport
    ) {
        $competitionCategory = $this->entityManager
            ->createQueryBuilder()
            ->select('competition_category.id')
            ->from(
                'ViscaLicomBundle:CompetitionCategory',
                'competition_category'
            )
            ->join(
                'competition_category.sport',
                'sport',
                Join::WITH,
                'sport.id = :sportId'
            )
            ->join(
                'competition_category.country',
                'country',
                Join::WITH,
                'country.id = :countryId'
            )
            ->setParameter('sportId', $sport->getId())
            ->setParameter('countryId', $country->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$competitionCategory) {
            return;
        }

        return $this->createQueryBuilder('competition')
            ->join(
                'competition.competitionCategory',
                'competitionCategory',
                Join::WITH,
                'competitionCategory.id = :competitionCategoryId'
            )
            ->where('competition.level = 1')
            ->setParameter('competitionCategoryId', $competitionCategory['id'])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param array $ids
     * @param Sport $sport
     *
     * @return array
     */
    public function getAndSortByIdsAndSport(array $ids, Sport $sport)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->join('c.competitionCategory', 'cc')
            ->where('c.id IN (:ids)')
            ->andWhere('cc.sport = :sportId')
            ->orderBy('FIELD(c.id, :ids)')
            ->setParameter('ids', $ids)
            ->setParameter('sportId', $sport->getId());

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param Match[] $matches
     *
     * @return Competition[]|null
     */
    public function findByMatchesIds(
        $matches = array()
    ) {
        $competitions = $this->entityManager
            ->createQueryBuilder()
            ->select('c as competition, count(match.id) as matchesNumber')
            ->from(
                'ViscaLicomBundle:Competition',
                'c'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeason',
                'cs',
                Join::WITH,
                'cs.competition = c.id'
            )
            ->join(
                'ViscaLicomBundle:CompetitionSeasonStage',
                'css',
                Join::WITH,
                'css.competitionSeason = cs.id'
            )->join(
                'ViscaLicomBundle:Match',
                'match',
                Join::WITH,
                'match.competitionSeasonStage = css.id'
            )
            ->where('match.id in (:matches)')
            ->setParameter('matches', $matches)
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();

        return $competitions;
    }
}
