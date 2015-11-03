<?php
namespace Visca\Bundle\LicomViewBundle\Provider\Slug;

use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\CompetitionCategory;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;
use Visca\Bundle\LicomViewBundle\Provider\Slug\Abstracts\AbstractSlugProvider;

/**
 * Class CompetitionCategorySlugProvider
 */
final class CompetitionCategorySlugProvider extends AbstractSlugProvider
{
    /**
     * @param CompetitionCategory $competitionCategory CompetitionCategory
     *
     * @return null|string
     * @throws \Exception
     * @throws SlugNotAvailableException
     */
    public function getSlug(CompetitionCategory $competitionCategory)
    {
        try {
            $slug = $this->findSlugFromLanguage(
                LocalizationTranslationTypeCode::COMPETITIONCATEGORY_SLUG_CODE,
                $competitionCategory->getId()
            );
        } catch (NoTranslationFoundException $ex) {
            throw new SlugNotAvailableException();
        }

        return $slug;
    }
}
