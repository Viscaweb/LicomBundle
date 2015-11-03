<?php

namespace Visca\Bundle\LicomViewBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;

/**
 * This listener will alter the name for some given entities.
 * It DOES NOT have the responsibility to FIND the translation, but just to inject them.
 *
 * Class TranslationInjectorListener
 */
class TranslationInjectorListener
{
    /**
     * @var TranslationInterface Translation Provider for Participant
     */
    protected $participantTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for Competition
     */
    protected $competitionTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for CompetitionCategory
     */
    protected $competitionCategoryTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for CompetitionStage
     */
    protected $competitionStageTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for Country
     */
    protected $countryTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for MatchStatusDescription
     */
    protected $matchStatusDescriptionTranslationProvider;

    /**
     * @var TranslationInterface Translation Provider for Sport
     */
    protected $sportTranslationProvider;

    /**
     * TranslationInjectorListener constructor.
     *
     * @param TranslationInterface $participantTranslationProvider
     * @param TranslationInterface $competitionTranslationProvider
     * @param TranslationInterface $competitionCategoryTranslationProvider
     * @param TranslationInterface $competitionStageTranslationProvider
     * @param TranslationInterface $countryTranslationProvider
     * @param TranslationInterface $matchStatusDescriptionTranslationProvider
     * @param TranslationInterface $sportTranslationProvider
     */
    public function __construct(
        TranslationInterface $participantTranslationProvider,
        TranslationInterface $competitionTranslationProvider,
        TranslationInterface $competitionCategoryTranslationProvider,
        TranslationInterface $competitionStageTranslationProvider,
        TranslationInterface $countryTranslationProvider,
        TranslationInterface $matchStatusDescriptionTranslationProvider,
        TranslationInterface $sportTranslationProvider
    ) {
        $this->participantTranslationProvider = $participantTranslationProvider;
        $this->competitionTranslationProvider = $competitionTranslationProvider;
        $this->competitionCategoryTranslationProvider = $competitionCategoryTranslationProvider;
        $this->competitionStageTranslationProvider = $competitionStageTranslationProvider;
        $this->countryTranslationProvider = $countryTranslationProvider;
        $this->matchStatusDescriptionTranslationProvider = $matchStatusDescriptionTranslationProvider;
        $this->sportTranslationProvider = $sportTranslationProvider;
    }

    /**
     * @param LifecycleEventArgs $args Event
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->translateMainFields($entity);
    }

    /**
     * @param mixed $object Any object who want to be translated
     */
    private function translateMainFields($object)
    {
        switch (true) {
            case ($object instanceof Competition):
                $this->translateCompetition($object);
                break;
            case ($object instanceof CompetitionCategory):
                $this->translateCompetitionCategory($object);
                break;
            case ($object instanceof CompetitionStage):
                $this->translateCompetitionStage($object);
                break;
            case ($object instanceof Country):
                $this->translateCountry($object);
                break;
            case ($object instanceof MatchStatusDescription):
                $this->translateMatchStatusDescription($object);
                break;
            case ($object instanceof Participant):
                $this->translateParticipant($object);
                break;
            case ($object instanceof Sport):
                $this->translateSport($object);
                break;
        }
    }

    /**
     * @param Country $country The MatchStatusDescription object to translate
     */
    private function translateCountry(Country $country)
    {
        try {
            $translatedName = $this->countryTranslationProvider->getTranslation(
                $country,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $country->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param CompetitionStage $competitionStage The CompetitionStage object to translate
     */
    private function translateCompetitionStage(
        CompetitionStage $competitionStage
    ) {
        try {
            $translatedName = $this->competitionStageTranslationProvider->getTranslation(
                $competitionStage,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $competitionStage->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param MatchStatusDescription $matchStatusDescription The MatchStatusDescription object to translate
     */
    private function translateMatchStatusDescription(
        MatchStatusDescription $matchStatusDescription
    ) {
        try {
            $translatedName = $this->matchStatusDescriptionTranslationProvider->getTranslation(
                $matchStatusDescription,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $matchStatusDescription->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param CompetitionCategory $competitionCategory The MatchStatusDescription object to translate
     */
    private function translateCompetitionCategory(
        CompetitionCategory $competitionCategory
    ) {
        try {
            $translatedName = $this->competitionCategoryTranslationProvider->getTranslation(
                $competitionCategory,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $competitionCategory->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param Sport $sport The Sport object to translate
     */
    private function translateSport(Sport $sport)
    {
        try {
            $translatedName = $this->sportTranslationProvider->getTranslation(
                $sport,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $sport->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param Competition $competition The Competition object to translate
     */
    private function translateCompetition(Competition $competition)
    {
        try {
            $translatedName = $this->competitionTranslationProvider->getTranslation(
                $competition,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $competition->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }

    /**
     * @param Participant $participant The Participant object to translate
     */
    private function translateParticipant(Participant $participant)
    {
        try {
            $translatedName = $this->participantTranslationProvider->getTranslation(
                $participant,
                ProfileTranslationGraphLabelCode::NAME_CODE
            );
            $participant->setName($translatedName);
        } catch (NoTranslationFoundException $e) {
            /*
             * If we don't have any translation, let the name as it is.
             */
        }
    }
}
