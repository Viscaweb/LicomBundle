<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\MatchStatusDescription;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetShortNameTrait;

/**
 * Class MatchStatusDescTranslationProvider.
 */
class MatchStatusDescTranslationProvider extends AbstractTranslationsProvider implements TranslationInterface, TranslationShortNameInterface
{
    const ENTITY = EntityCode::MATCH_STATUS_DESCRIPTION_CODE;

    use GetShortNameTrait;

    /**
     * @param mixed $object           The MatchStatusDescription object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel)
    {
        if (!($object instanceof MatchStatusDescription)) {
            throw new \Exception(
                'You must provide a MatchStatusDescription object to use this provider, "%s" given.',
                get_class($object)
            );
        }
        $this->translationCacheManager->setEntity(static::ENTITY);

        return $this->translationCacheManager->fetch($object->getId(), $translationLabel);
    }
}
