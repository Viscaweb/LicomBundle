<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetShortNameTrait;

/**
 * Class SportTranslationsProvider.
 */
class SportTranslationsProvider extends AbstractTranslationsProvider implements TranslationInterface, TranslationShortNameInterface
{
    const ENTITY = EntityCode::SPORT_CODE;

    use GetShortNameTrait;

    /**
     * @param mixed $object           The Sport object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel)
    {
        if (!($object instanceof Sport)) {
            throw new \Exception(
                'You must provide a Sport object to use this provider, "%s" given.',
                get_class($object)
            );
        }
        $this->translationCacheManager->setEntity(static::ENTITY);

        return $this->translationCacheManager->fetch($object->getId(), $translationLabel);
    }
}
