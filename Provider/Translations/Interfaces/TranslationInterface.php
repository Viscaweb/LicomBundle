<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Interface TranslationInterface.
 */
interface TranslationInterface
{
    /**
     * @param mixed $object           The object to work on (Participant, Competition, etc..)
     * @param int   $translationLabel The required translation
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTranslation($object, $translationLabel);
}
