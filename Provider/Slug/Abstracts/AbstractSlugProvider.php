<?php

namespace Visca\Bundle\LicomViewBundle\Provider\Slug\Abstracts;

use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Repository\LocalizationTranslationRepository;

/**
 * Class AbstractSlugProvider
 *
 * Some entities's slugs are found using the languages rules, some using the site's (profile) rules.
 * That's why in this class we have two main methods:
 *  - findSlugFromLanguage
 *  - findSlugFromProfile
 *
 * You can find more information about it in the README.md of this bundle.
 */
abstract class AbstractSlugProvider
{
    /**
     * @var LocalizationTranslationRepository
     */
    protected $localizationTranslationRepository;

    /**
     * @var int
     */
    protected $licomProfileId;

    /**
     * CompetitionSlugProvider constructor.
     *
     * @param LocalizationTranslationRepository $localizationTranslationRepository Repository
     * @param int                               $licomProfileId                    App's profile ID
     */
    public function __construct(
        LocalizationTranslationRepository $localizationTranslationRepository,
        $licomProfileId
    ) {
        $this->localizationTranslationRepository = $localizationTranslationRepository;
        $this->licomProfileId = $licomProfileId;
    }

    /**
     * @param int $localizationTranslationTypeId The type of translation
     * @param int $entityId                      The ID of the entity
     *
     * @return null|string
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    protected function findSlugFromLanguage(
        $localizationTranslationTypeId,
        $entityId
    ) {
        $repository = $this->localizationTranslationRepository;
        try {
            $localizationTranslationSlug = $repository->findOneByLocalizationAndEntityId(
                $this->licomProfileId,
                $localizationTranslationTypeId,
                $entityId
            );
            $slug = $localizationTranslationSlug->getText();
        } catch (NoTranslationFoundException $ex) {
            throw $ex;
        }

        return $slug;
    }

    /**
     * @param int $localizationTranslationTypeId The type of translation
     * @param int $profileGraphLabelId           The profile label type
     * @param int $entityId                      The ID of the entity
     *
     * @return null|string
     * @throws NoTranslationFoundException
     * @throws \Exception
     */
    protected function findSlugFromProfile(
        $localizationTranslationTypeId,
        $profileGraphLabelId,
        $entityId
    ) {
        try {
            $localizationTranslationSlug = $this->localizationTranslationRepository->findOneByProfile(
                $this->licomProfileId,
                $localizationTranslationTypeId,
                $profileGraphLabelId,
                $entityId
            );
            $slug = $localizationTranslationSlug->getText();
        } catch (NoTranslationFoundException $ex) {
            throw $ex;
        }

        return $slug;
    }
}
