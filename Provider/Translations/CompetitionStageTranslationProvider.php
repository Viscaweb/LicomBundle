<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionStage;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetShortNameTrait;

/**
 * Class CompetitionStageTranslationProvider.
 */
class CompetitionStageTranslationProvider extends AbstractTranslationsProvider implements TranslationInterface, TranslationShortNameInterface
{
    const ENTITY = EntityCode::COMPETITION_STAGE_CODE;

    use GetShortNameTrait;

    /**
     * @param mixed $object           The CompetitionStage object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel)
    {
        if (!($object instanceof CompetitionStage)) {
            throw new \Exception(
                'You must provide a CompetitionStage object to use this provider, "%s" given.',
                get_class($object)
            );
        }
        $this->translationCacheManager->setEntity(static::ENTITY);

        return $this->translationCacheManager->fetch($object->getId(), $translationLabel);
    }
}
