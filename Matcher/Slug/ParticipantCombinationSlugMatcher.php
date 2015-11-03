<?php
namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Model\Slug\ParticipantCombinationModel;
use Visca\Bundle\LicomBundle\Repository\ParticipantRepository;

/**
 * Class ParticipantCombinationSlugMatcher
 */
class ParticipantCombinationSlugMatcher
{
    /**
     * @var Cache
     */
    protected $doctrineCache;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var FileLocatorInterface
     */
    protected $fileLocator;

    /**
     * @var ParticipantRepository
     */
    protected $participantRepository;

    /**
     * ParticipantCombinationSlugMatcher constructor.
     *
     * @param Cache                  $doctrineCache         Doctrine Cache
     * @param EntityManagerInterface $entityManager         Licom Entity Manager
     * @param FileLocatorInterface   $fileLocator           File Locator
     * @param ParticipantRepository  $participantRepository Participant Repository
     */
    public function __construct(
        Cache $doctrineCache,
        EntityManagerInterface $entityManager,
        FileLocatorInterface $fileLocator,
        ParticipantRepository $participantRepository
    ) {
        $this->doctrineCache = $doctrineCache;
        $this->entityManager = $entityManager;
        $this->fileLocator = $fileLocator;
        $this->participantRepository = $participantRepository;
    }

    /**
     * @param int    $licomProfileId App's Profile ID
     * @param string $matchSlug      Match Slug (i.e. 'fc-barcelona-madrid')
     *
     * @return ParticipantCombinationModel
     * @throws \Doctrine\DBAL\DBALException
     * @throws NoMatchFoundException
     */
    public function getParticipantCombination(
        $licomProfileId,
        $matchSlug
    ) {
        /*
         * Get the home/away participant IDs from a custom query
         */
        $stmt = $this->prepareQuery($licomProfileId, $matchSlug);
        $results = $stmt->fetchAll();
        if (!isset($results[0])) {
            throw new NoMatchFoundException();
        }

        $result = $results[0];
        $stmt->closeCursor();

        $homeParticipantID = $result['homeParticipantID'];
        $awayParticipantID = $result['awayParticipantID'];

        /*
         * Find the related Participant object
         */
        $participants = $this->participantRepository->getAndSortById(
            [$homeParticipantID, $awayParticipantID]
        );
        if (count($participants) !== 2) {
            throw new NoMatchFoundException();
        }

        $homeParticipant = reset($participants);
        $awayParticipant = next($participants);

        /*
         * Create the custom combination model
         */
        $participantCombinationModel = new ParticipantCombinationModel(
            $homeParticipant,
            $awayParticipant,
            $matchSlug
        );

        return $participantCombinationModel;
    }

    /**
     * @param int    $licomProfileId App's Profile ID
     * @param string $matchSlug      Match Slug (i.e. 'fc-barcelona-madrid')
     *
     * @return \Doctrine\DBAL\Driver\ResultStatement
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws NoMatchFoundException
     */
    private function prepareQuery(
        $licomProfileId,
        $matchSlug
    ) {
        /*
         * Please note that this query works ONLY if the FROM statement are completely
         * isolated (using parentheses) (in order to make the following LEFT JOIN).
         *
         * I couldn't reproduce it using a query builder.
         * It does not seems to be available yet.
         * More information: \Doctrine\DBAL\Query\QueryBuilder::getSQLForSelect
         *
         * I tried as well to create a DQL query but it's being execute by Doctrine
         * who tried to associate the first table of the FROM statement using the "(".
         * It's throwing an exception saying that '(ProfileTranslation_graph' is not a valid table name...
         */
        $sqlQueryLocation = $this->fileLocator->locate(
            '@ViscaLicomBundle/Resources/queries/ParticipantsCombinationQuery.sql'
        );
        $queryString = file_get_contents($sqlQueryLocation);

        $queryParameters = $this->prepareQueryParameters(
            $licomProfileId,
            $matchSlug
        );

        $connection = $this->entityManager->getConnection();

        return $connection->executeCacheQuery(
            $queryString,
            $queryParameters,
            [],
            new QueryCacheProfile(0, 'test', $this->doctrineCache)
        );
    }

    /**
     * @param $licomProfileId
     * @param $matchSlug
     *
     * @return array
     */
    private function prepareQueryParameters(
        $licomProfileId,
        $matchSlug
    ) {
        $parameters = [
            'profileTranslationLabel' => (int) ProfileTranslationGraphLabelCode::SLUG_CODE,
            'profileId' => (int) $licomProfileId,
            'localizationTranslationType' => (int) LocalizationTranslationTypeCode::PARTICIPANT_SLUG_CODE,
            'matchSlug' => $matchSlug,
        ];

        return $parameters;
    }
}
