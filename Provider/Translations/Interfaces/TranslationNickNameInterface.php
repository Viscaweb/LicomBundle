<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Interface TranslationNickNameInterface.
 */
interface TranslationNickNameInterface
{
    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getNicknameMaleSingular($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getNicknameMalePlural($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getNicknameFemaleSingular($object);

    /**
     * @param mixed $object The object to work on (Participant, Competition, etc..)
     *
     * @return string
     *
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    public function getNicknameFemalePlural($object);
}
