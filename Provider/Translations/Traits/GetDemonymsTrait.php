<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Traits;

use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Trait GetDemonymsTrait.
 */
trait GetDemonymsTrait
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
    public function getDemonymMaleSingular($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_SIN_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getDemonymMalePlural($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_PLU_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getDemonymFemaleSingular($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_SIN_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getDemonymFemalePlural($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_PLU_CODE
        );
    }
}
