<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Traits;

use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Trait GetShortNameTrait.
 */
trait GetShortNameTrait
{
    /**
     * @param mixed $object           The object to translate
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    abstract public function getTranslation($object, $translationLabel);

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getShortName($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE
        );
    }
}
