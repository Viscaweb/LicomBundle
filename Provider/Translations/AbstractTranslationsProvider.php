<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Translations;

use Visca\Bundle\LicomBundle\Services\Translations\TranslationCacheManager;

/**
 * Abstract Class AbstractTranslationsProvider.
 */
abstract class AbstractTranslationsProvider
{
    const ENTITY = 'entity';

    /**
     * @var TranslationCacheManager
     */
    protected $translationCacheManager;

    /**
     * @param TranslationCacheManager $translationCacheManager TranslationCacheManager
     */
    public function __construct(TranslationCacheManager $translationCacheManager)
    {
        $this->translationCacheManager = $translationCacheManager;
    }
}
