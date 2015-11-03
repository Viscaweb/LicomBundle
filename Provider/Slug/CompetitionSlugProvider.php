<?php
namespace Visca\Bundle\LicomViewBundle\Provider\Slug;

use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;
use Visca\Bundle\LicomViewBundle\Provider\Slug\Abstracts\AbstractSlugProvider;

/**
 * Class CompetitionSlugProvider
 */
final class CompetitionSlugProvider extends AbstractSlugProvider
{
    /**
     * @param Competition $competition Competition
     *
     * @return null|string
     * @throws \Exception
     * @throws SlugNotAvailableException
     */
    public function getSlug(Competition $competition)
    {
        try {
            $slug = $this->findSlugFromProfile(
                self::LOCALIZATION_TRANSLATION_TYPE,
                LocalizationTranslationTypeCode::COMPETITION_SLUG_CODE,
                $competition->getId()
            );
        } catch (NoTranslationFoundException $ex) {
            throw new SlugNotAvailableException();
        }

        return $slug;
    }
}
