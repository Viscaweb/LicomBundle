<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationDemonymsInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationNickNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationTrigraphInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetDemonymsTrait;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetNickNameTrait;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetShortNameTrait;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetTrigraphTrait;

/**
 * Class ParticipantTranslationsProvider.
 */
class ParticipantTranslationsProvider extends AbstractTranslationsProvider implements
    TranslationInterface,
    TranslationShortNameInterface,
    TranslationDemonymsInterface,
    TranslationNickNameInterface,
    TranslationTrigraphInterface
{
    const ENTITY = EntityCode::PARTICIPANT_CODE;

    use GetShortNameTrait;
    use GetDemonymsTrait;
    use GetNickNameTrait;
    use GetTrigraphTrait;

    /**
     * @param mixed $object           The Participant object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel)
    {
        if (!($object instanceof Participant)) {
            throw new \Exception(
                'You must provide a Participant object to use this provider, "%s" given.',
                get_class($object)
            );
        }
        $this->translationCacheManager->setEntity(static::ENTITY);

        return $this->translationCacheManager->fetch(
            $object->getId(),
            $translationLabel
        );
    }

    /**
     * @param mixed $object The Participant object to translate
     *
     * @return string
     * @throws \Exception
     */
    public function getDefaultName($object)
    {
        if (!($object instanceof Participant)) {
            throw new \Exception(
                'You must provide a Participant object to use this provider, "%s" given.',
                get_class($object)
            );
        }

        return $object->getName();
    }
}
