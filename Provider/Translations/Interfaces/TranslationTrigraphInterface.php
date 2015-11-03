<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Interface TranslationTrigraphInterface.
 */
interface TranslationTrigraphInterface
{
    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getTrigraph($object);
}
