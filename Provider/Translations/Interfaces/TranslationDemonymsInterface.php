<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Interface TranslationDemonymsInterface.
 */
interface TranslationDemonymsInterface
{
    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getDemonymMaleSingular($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getDemonymMalePlural($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getDemonymFemaleSingular($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getDemonymFemalePlural($object);
}
