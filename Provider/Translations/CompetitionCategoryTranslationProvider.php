<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Traits\GetShortNameTrait;

/**
 * Class CompetitionCategoryTranslationProvider.
 */
class CompetitionCategoryTranslationProvider extends AbstractTranslationsProvider implements TranslationInterface, TranslationShortNameInterface
{
    const ENTITY = EntityCode::COMPETITION_CATEGORY_CODE;

    use GetShortNameTrait;

    /**
     * @param mixed $object           The CompetitionCategory object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel)
    {
        if (!($object instanceof CompetitionCategory)) {
            throw new \Exception(
                'You must provide a CompetitionCategory object to use this provider, "%s" given.',
                get_class($object)
            );
        }
        $this->translationCacheManager->setEntity(static::ENTITY);

        return $this->translationCacheManager->fetch($object->getId(), $translationLabel);
    }
}
