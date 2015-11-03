<?php
namespace Visca\Bundle\LicomViewBundle\Provider\Slug;

use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;
use Visca\Bundle\LicomBundle\Exception\SlugNotAvailableException;
use Visca\Bundle\LicomViewBundle\Provider\Slug\Abstracts\AbstractSlugProvider;

/**
 * Class ParticipantSlugProvider
 */
final class ParticipantSlugProvider extends AbstractSlugProvider
{
    /**
     * @param Participant $participant Participant
     *
     * @return null|string
     * @throws \Exception
     * @throws SlugNotAvailableException
     */
    public function getSlug(Participant $participant)
    {
        try {
            $slug = $this->findSlugFromProfile(
                LocalizationTranslationTypeCode::PARTICIPANT_SLUG_CODE,
                ProfileTranslationGraphLabelCode::SLUG_CODE,
                $participant->getId()
            );
        } catch (NoTranslationFoundException $ex) {
            throw new SlugNotAvailableException();
        }

        return $slug;
    }
}
