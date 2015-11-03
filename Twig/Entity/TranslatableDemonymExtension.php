<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationDemonymsInterface;
use Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts\AbstractTranslatableExtension;

/**
 * Class TranslatableDemonymExtension.
 */
class TranslatableDemonymExtension extends AbstractTranslatableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'transDemonymFemalePlural',
                [$this, 'transDemonymFemalePlural']
            ),
            new \Twig_SimpleFilter(
                'transDemonymFemaleSingular',
                [$this, 'transDemonymFemaleSingular']
            ),
            new \Twig_SimpleFilter(
                'transDemonymMalePlural',
                [$this, 'transDemonymMalePlural']
            ),
            new \Twig_SimpleFilter(
                'transDemonymMaleSingular',
                [$this, 'transDemonymMaleSingular']
            ),
        ];
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getDemonymFemalePlural($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationDemonymsInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getDemonymFemalePlural($object);
        } catch (NoTranslationFoundException $e) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getDemonymFemaleSingular($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationDemonymsInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getDemonymFemaleSingular($object);
        } catch (NoTranslationFoundException $e) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getDemonymMalePlural($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationDemonymsInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getDemonymMalePlural($object);
        } catch (NoTranslationFoundException $e) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getDemonymMaleSingular($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationDemonymsInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getDemonymMaleSingular($object);
        } catch (NoTranslationFoundException $e) {
            $result = '';
        }

        return $result;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'visca_licom_extension_entities_translatable_demonym';
    }
}
