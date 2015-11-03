<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Interface TranslationShortNameInterface.
 */
interface TranslationShortNameInterface
{
    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getShortName($object);
}
