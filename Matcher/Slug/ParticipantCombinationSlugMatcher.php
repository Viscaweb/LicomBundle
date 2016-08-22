<?php
namespace Visca\Bundle\LicomBundle\Matcher\Slug;

use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslation;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoMatchFoundException;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Model\Slug\ParticipantCombinationModel;
use Visca\Bundle\LicomBundle\Repository\LocalizationTranslationRepository;
use Visca\Bundle\LicomBundle\Repository\ParticipantRepository;

/**
 * Class ParticipantCombinationSlugMatcher
 */
class ParticipantCombinationSlugMatcher
{
    /**
     * @var ParticipantRepository
     */
    protected $participantRepository;

    /**
     * @var LocalizationTranslationRepository
     */
    protected $localizationTranslationRepository;

    /**
     * ParticipantCombinationSlugMatcher constructor.
     *
     * @param ParticipantRepository             $participantRepository             Participant Repository
     * @param LocalizationTranslationRepository $localizationTranslationRepository Loc. Trans Repository
     */
    public function __construct(
        ParticipantRepository $participantRepository,
        LocalizationTranslationRepository $localizationTranslationRepository
    ) {
        $this->participantRepository = $participantRepository;
        $this->localizationTranslationRepository = $localizationTranslationRepository;
    }

    /**
     * @param Sport  $sport          Sport of the given teams slugs
     * @param int    $licomProfileId App's Profile ID
     * @param string $homeTeamSlug   Supposed Home Team Slug
     * @param string $awayTeamSlug   Supposed Away Team Slug
     *
     * @return ParticipantCombinationModel[]
     * @throws NoMatchFoundException
     */
    public function getParticipantCombinations(
        Sport $sport,
        $licomProfileId,
        $homeTeamSlug,
        $awayTeamSlug
    ) {
        /*
         * Get the home/away participant IDs from translations
         */
        try {
            $homeParticipants = $this->findParticipants(
                $sport,
                $licomProfileId,
                $homeTeamSlug
            );
            $awayParticipants = $this->findParticipants(
                $sport,
                $licomProfileId,
                $awayTeamSlug
            );
        } catch (NoMatchFoundException $ex) {
            throw new $ex();
        }

        /*
         * Create the custom combination model
         */
        $matchSlug = sprintf('%s-%s', $homeTeamSlug, $awayTeamSlug);
        $participantCombinationModels = [];
        foreach ($homeParticipants as $homeParticipant) {
            foreach ($awayParticipants as $awayParticipant) {
                $participantCombinationModels[] = new ParticipantCombinationModel(
                    $homeParticipant,
                    $awayParticipant,
                    $matchSlug
                );
            }
        }

        return $participantCombinationModels;
    }

    /**
     * @param Sport  $sport           Sport of the given teams slugs
     * @param int    $licomProfileId  App's Profile ID
     * @param string $participantSlug Supposed Participant Slug
     *
     * @return Participant[]
     *
     * @throws NoMatchFoundException
     */
    private function findParticipants(
        Sport $sport,
        $licomProfileId,
        $participantSlug
    ) {
        $profileGraphLabelId = ProfileTranslationGraphLabelCode::SLUG_CODE;
        $localizationTranslationTypeId = (int)LocalizationTranslationTypeCode::PARTICIPANT_SLUG_CODE;

        try {
            $participantTranslationSlugs = $this
                ->localizationTranslationRepository
                ->findByProfileAndText(
                    $licomProfileId,
                    $localizationTranslationTypeId,
                    $profileGraphLabelId,
                    [$participantSlug]
                );
        } catch (NoTranslationFoundException $ex) {
            throw new NoMatchFoundException();
        }

        $candidatesParticipantsIds = [];
        foreach ($participantTranslationSlugs as $participantTranslationSlug) {
            $candidatesParticipantsIds[] =
                $participantTranslationSlug->getEntityId();
        }

        $participants = $this
            ->participantRepository
            ->findBy(
                [
                    'id' => $candidatesParticipantsIds,
                    'sport' => $sport->getId(),
                ]
            );

        if (empty($participants)) {
            throw new NoMatchFoundException();
        }

        return $participants;
    }
}
