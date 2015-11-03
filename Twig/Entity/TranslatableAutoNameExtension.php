<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationTrigraphInterface;
use Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts\AbstractTranslatableExtension;

/**
 * Class TranslatableAutoNameExtension.
 */
class TranslatableAutoNameExtension extends AbstractTranslatableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'transAutoName',
                [$this, 'getTransAutoName']
            ),
        ];
    }

    /**
     * @param mixed $object             The object to translate
     * @param int   $maxLengthName      MaxLengthName
     * @param int   $maxLengthShortName MaxLengthShortName
     *
     * @return string
     * @throws \Exception
     */
    public function getTransAutoName(
        $object,
        $maxLengthName = 20,
        $maxLengthShortName = 10
    ) {
        $translationProvider = $this->getEntityRepository($object);

        $name = $object->getName();

        /*
         * If the default name's length is smaller than the max. name length allowed.
         */
        if (strlen($name) <= $maxLengthName) {
            return $name;
        }

        try {
            /*
             * If the short name's length is smaller than the max. short name length allowed.
             *
             * This condition works only if we have short name for this entity.
             */
            if ($translationProvider instanceof TranslationShortNameInterface) {
                $shortName = $translationProvider->getShortName($object);
                if (strlen($shortName) <= $maxLengthShortName) {
                    return $shortName;
                }
            }

            /*
             * If the trigraph name's length is smaller than the max. short name length allowed.
             *
             * This condition works only if we have short name for this entity.
             */
            if ($translationProvider instanceof TranslationTrigraphInterface) {
                return $translationProvider->getTrigraph($object);
            }
        } catch (NoTranslationFoundException $e) {
        }

        /*
         * If really we can't do better, just truncate the word
         */
        $nameLength = strlen($name);
        if ($nameLength > $maxLengthName) {
            $nameTruncated = substr($name, 0, $maxLengthName - 2).'.';
        } else {
            $nameTruncated = substr($name, 0, $maxLengthName);
        }

        return $nameTruncated;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'visca_licom_extension_entities_translatable_auto_name';
    }
}
