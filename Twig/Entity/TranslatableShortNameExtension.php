<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationShortNameInterface;
use Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts\AbstractTranslatableExtension;

/**
 * Class TranslatableShortNameExtension.
 */
class TranslatableShortNameExtension extends AbstractTranslatableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'transShortName',
                [$this, 'getShortName']
            ),
        ];
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getShortName($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        $result = null;

        /*
         * Try finding the short name
         */
        if ($translationProvider instanceof TranslationShortNameInterface) {
            try {
                $result = $translationProvider->getShortName($object);
            } catch (NoTranslationFoundException $e) {
                /*
                 * If we can't find any short named translation, don't break.
                 * The $result will be null and catch later on this code.
                 */
            }
        }

        /*
         * If we can't find the short name, try to find the normal name
         */
        if (is_null($result) && is_callable([$object, 'getName'])) {
            $result = $object->getName();
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
        return 'visca_licom_extension_entities_translatable_shortname';
    }
}
