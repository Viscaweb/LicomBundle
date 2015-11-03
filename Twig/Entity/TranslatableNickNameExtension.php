<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationNickNameInterface;
use Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts\AbstractTranslatableExtension;

/**
 * Class TranslatableNickNameExtension.
 */
class TranslatableNickNameExtension extends AbstractTranslatableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'transNicknameFemalePlural',
                [$this, 'transNicknameFemalePlural']
            ),
            new \Twig_SimpleFilter(
                'transNicknameFemaleSingular',
                [$this, 'transNicknameFemaleSingular']
            ),
            new \Twig_SimpleFilter(
                'transNicknameMalePlural',
                [$this, 'transNicknameMalePlural']
            ),
            new \Twig_SimpleFilter(
                'transNicknameMaleSingular',
                [$this, 'transNicknameMaleSingular']
            ),
        ];
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getNicknameFemalePlural($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationNickNameInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getNicknameFemalePlural($object);
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
    public function getNicknameFemaleSingular($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationNickNameInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getNicknameFemaleSingular($object);
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
    public function getNicknameMalePlural($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationNickNameInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getNicknameMalePlural($object);
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
    public function getNicknameMaleSingular($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationNickNameInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getNicknameMaleSingular($object);
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
        return 'visca_licom_extension_entities_translatable_nickname';
    }
}
