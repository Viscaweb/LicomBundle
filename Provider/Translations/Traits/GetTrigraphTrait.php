<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations\Traits;

use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Trait GetTrigraphTrait.
 */
trait GetTrigraphTrait
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
     * @param mixed $object The object to translate
     *
     * @return string
     */
    abstract public function getDefaultName($object);

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    public function getTrigraph($object)
    {
        try {
            $trigram = $this->getTranslation(
                $object,
                ProfileTranslationGraphLabelCode::TRIGRAPH_CODE
            );
        } catch (NoTranslationFoundException $ex) {
            $trigram = $this->generateTrigram($object);
        }

        return $trigram;
    }

    /**
     * @param mixed $object Object
     *
     * @return string
     */
    private function generateTrigram($object)
    {
        $objectDefaultName = $this->getDefaultName($object);

        return strtoupper(mb_substr($objectDefaultName, 0, 3));
    }
}
