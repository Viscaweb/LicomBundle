<?php

namespace Visca\Bundle\LicomViewBundle\Twig\Entity;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomViewBundle\Provider\Translations\Interfaces\TranslationTrigraphInterface;
use Visca\Bundle\LicomViewBundle\Twig\Entity\Abstracts\AbstractTranslatableExtension;

/**
 * Class TranslatableTrigraphExtension.
 */
class TranslatableTrigraphExtension extends AbstractTranslatableExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'transTrigraph',
                [$this, 'getTrigraph']
            ),
        ];
    }

    /**
     * @param mixed $object The object to translate
     *
     * @return string
     */
    public function getTrigraph($object)
    {
        $translationProvider = $this->getEntityRepository($object);
        if (!$translationProvider instanceof TranslationTrigraphInterface) {
            return '';
        }

        try {
            $result = $translationProvider->getTrigraph($object);
        } catch (NoTranslationFoundException $e) {
            $result = substr($object->getName(), 0, 3);
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
        return 'visca_licom_extension_entities_translatable_trigraph';
    }
}
