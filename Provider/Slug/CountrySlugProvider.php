<?php
namespace Visca\Bundle\LicomViewBundle\Provider\Slug;

use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Country;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;
use Visca\Bundle\LicomViewBundle\Provider\Slug\Abstracts\AbstractSlugProvider;

/**
 * Class CountrySlugProvider
 */
final class CountrySlugProvider extends AbstractSlugProvider
{
    /**
     * @param Country $country Country
     *
     * @return null|string
     * @throws \Exception
     * @throws SlugNotAvailableException
     */
    public function getSlug(Country $country)
    {
        try {
            $slug = $this->findSlugFromLanguage(
                LocalizationTranslationTypeCode::COUNTRY_SLUG_CODE,
                $country->getId()
            );
        } catch (NoTranslationFoundException $ex) {
            throw new SlugNotAvailableException();
        }

        return $slug;
    }
}
