<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Traits;

use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Trait GetNickNameTrait.
 */
trait GetNickNameTrait
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
    public function getNicknameMaleSingular($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::NICKNAME_MALE_SIN_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getNicknameMalePlural($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::NICKNAME_MALE_PLU_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getNicknameFemaleSingular($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::NICKNAME_FEMALE_SIN_CODE
        );
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getNicknameFemalePlural($object)
    {
        return $this->getTranslation(
            $object,
            ProfileTranslationGraphLabelCode::NICKNAME_FEMALE_PLU_CODE
        );
    }
}
