<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Code\StandingTypeCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionSeason;
use Visca\Bundle\LicomBundle\Entity\Enum\ParticipantType;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\ParticipantMembership;
use Visca\Bundle\LicomBundle\Entity\ProfileEntityGraph;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Entity\Standing;
use Visca\Bundle\LicomBundle\Entity\Team;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class ParticipantRepository.
 */
class ParticipantRepository extends AbstractEntityRepository
{
    const COMPETITION_SEASON_CODE = 'CompetitionSeason';

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
     * @param int $competitionSeasonId competitionSeasonId
     *
     * @return Participant[]
     */
    public function findByCompetitionSeason($competitionSeasonId)
    {
        return $this
            ->createQueryBuilder('participant')
            ->join(
                'ViscaLicomBundle:ParticipantMembership',
                'participantMembership',
                'WITH',
                'participantMembership.participant = participant.id'
            )
            ->join(
                'participantMembership.entity',
                'entity',
                'WITH',
                'entity.code = :code'
            )
            ->andWhere('participantMembership.entityId = :competitionSeasonId')
            ->setParameter('code', self::COMPETITION_SEASON_CODE)
            ->setParameter('competitionSeasonId', $competitionSeasonId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Sport    $sport Sport
     * @param int|null $limit Limit of results
     *
     * @return Participant[]
     */
    public function findTop(Sport $sport, $limit = null)
    {
        $profileGraphRepository = $this->repositoryProfileEntityGraph;

        $profileTopEntriesIds = $profileGraphRepository->findByLabel(
            $sport,
            'top-teams',
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
     * @param int|null $limit Limit
     *
     * @return array
     */
    public function getAllIds($limit = null)
    {
        $queryBuilder = $this->createQueryBuilder('p')->select('p.id');

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @param int    $licomProfileId  App's profile ID
     * @param string $participantSlug Participant slug
     *
     * @return Participant[]
     */
    public function findBySlug(
        $licomProfileId,
        $participantSlug
    ) {
        $localizationTranslationRepository = $this->repositoryLocalizationTranslation;
        try {
            $participantsSlugTranslations = $localizationTranslationRepository
                ->findByProfileAndText(
                    $licomProfileId,
                    LocalizationTranslationTypeCode::PARTICIPANT_SLUG_CODE,
                    ProfileTranslationGraphLabelCode::SLUG_CODE,
                    [$participantSlug]
                );
        } catch (NoTranslationFoundException $ex) {
            return null;
        }

        $participantsIds = [];
        foreach ($participantsSlugTranslations as $translation) {
            $participantsIds[] = $translation->getEntityId();
        }

        return $this->findBy(['id' => $participantsIds]);
    }

    /**
     * @param array $ids Ids
     *
     * @return Participant[]
     */
    public function findByIds(array $ids)
    {
        return $this
            ->createQueryBuilder('p')
            ->select('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int[] $teamsIds
     *
     * @return Participant[]
     */
    public function findAthleteByTeamIds($teamsIds)
    {
        return $this
            ->createQueryBuilder('participant')
            ->join(
                'ViscaLicomBundle:ParticipantMembership',
                'participantMembership',
                'WITH',
                'participantMembership.participant = participant.id'
            )
            ->where('participantMembership.entity = :membershipEntity')
            ->andWhere('participantMembership.entityId IN (:membershipsTeamsIds)')
            ->setParameter('membershipEntity', EntityCode::PARTICIPANT_CODE)
            ->setParameter('membershipsTeamsIds', $teamsIds)
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns the Athlete team in the current Standing
     *
     * @param Athlete  $athlete
     * @param Standing $standing
     *
     * @return mixed
     */
    public function findOneByMainTeamByAthleteAndStanding(
        Athlete $athlete,
        Standing $standing
    ){
        $participantMemberships = $athlete->getParticipantMembership();
        $teamIds = [];
        if(!$participantMemberships->isEmpty()){
            /** @var ParticipantMembership $participantMembership */
            foreach($participantMemberships as $participantMembership){
                $teamIds[] = $participantMembership->getEntityId();
            }
        }

        $query = $this
            ->createQueryBuilder('participant')
            ->join(
                'ViscaLicomBundle:Standing',
                'standing',
                'WITH',
                'standing.entityId = :standingId'
            )
            ->join(
                'ViscaLicomBundle:StandingRow',
                'standingRow',
                'WITH',
                'standingRow.standing = standing.id'
            )
            ->where('standing.entity = :standingEntity')
            ->andWhere('standing.standingType = :standingType')
            ->andWhere('participant.id IN (:athleteTeamsIds)')
            ->andWhere('participant.id = standingRow.participant')
            ->setParameter('standingId', $standing->getEntityId())
            ->setParameter('standingEntity', EntityCode::COMPETITION_SEASON_STAGE_CODE)
            ->setParameter('standingType', StandingTypeCode::LEAGUE_TABLE_CODE)
            ->setParameter('athleteTeamsIds', $teamIds)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
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
            ->createQueryBuilder('p')
            ->join('p.sport', 's', Join::WITH, 's.id = :sportId')
            ->where('p.id IN (:ids)')
            ->orderBy('FIELD(p.id, :ids)')
            ->setParameter('ids', $ids)
            ->setParameter('sportId', $sport->getId());

       return $queryBuilder->getQuery()->getResult();
    }
}
