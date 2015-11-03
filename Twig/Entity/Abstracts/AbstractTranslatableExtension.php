<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts;

use Twig_Extension;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;

/**
 * Class AbstractTranslatableExtension.
 */
abstract class AbstractTranslatableExtension extends Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    abstract public function getName();

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
     * @param $object
     *
     * @return TranslationInterface
     *
     * @throws \Exception
     */
    protected function getEntityRepository($object)
    {
        switch ($object) {
            case ($object instanceof Participant):
                $provider = $this->participantTranslationProvider;
                break;
            case ($object instanceof Competition):
                $provider = $this->competitionTranslationProvider;
                break;
            case ($object instanceof CompetitionCategory):
                $provider = $this->competitionCategoryTranslationProvider;
                break;
            case ($object instanceof CompetitionStage):
                $provider = $this->competitionStageTranslationProvider;
                break;
            case ($object instanceof Country):
                $provider = $this->countryTranslationProvider;
                break;
            case ($object instanceof MatchStatusDescription):
                $provider = $this->matchStatusDescriptionTranslationProvider;
                break;
            case ($object instanceof Sport):
                $provider = $this->sportTranslationProvider;
                break;
            default:
                throw new \Exception(
                    sprintf(
                        'This entity is not handled by this Twig extension, "%s" given.',
                        get_class($object)
                    )
                );
        }

        return $provider;
    }
}
