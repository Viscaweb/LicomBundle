<?php

namespace Visca\Bundle\LicomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationTypeCode;
use Visca\Bundle\LicomBundle\Entity\Profile;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Class DebugTranslationController.
 */
class DebugTranslationController extends Controller
{
    /**
     * @throws \Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException
     */
    public function testTeamNormalTranslationAction()
    {
        /*
         * Prepare the objects
         */
        $currentProfile = $this->getCurrentProfile();
        $currentProfileId = $currentProfile->getId();
        $translationParticipantNameTypeId = LocalizationTranslationTypeCode::PARTICIPANT_NAME_CODE;
        $translationGraphLabelId = LocalizationTranslationGraphLabelCode::DEFAULT_CODE;
        $teamFcBarcelona = 50;
        $teamParis = 93;

        /*
         * Find the translation of FC Barcelona related to this profile
         */
        $localizationTranslationRepository = $this->get(
            'visca_licom.repository.localization_translation'
        );
        try {
            $localizationTranslations = $localizationTranslationRepository
                ->findByProfileAndEntityIds(
                    $currentProfileId,
                    $translationParticipantNameTypeId,
                    $translationGraphLabelId,
                    [$teamFcBarcelona, $teamParis]
                );
        } catch (NoTranslationFoundException $ex) {
            /*
             * If we don't find for the profile, use the rule to find the correct translations
             */
            try {
                $localizationTranslations = $localizationTranslationRepository
                    ->findByProfileAndEntityIdsUsingRules(
                        $currentProfileId,
                        $translationParticipantNameTypeId,
                        [$teamFcBarcelona, $teamParis]
                    );
            } catch (NoTranslationFoundException $ex) {
                throw $ex;
            }
        }

        $html = '<table border="1">';
        $html .= '<thead><tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Entity ID</th>';
        $html .= '<th>Text</th>';
        $html .= '</tr></thead>';
        foreach ($localizationTranslations as $localizationTranslation) {
            $html .= '<tr>';
            $html .= '<td>'.$localizationTranslation->getId().'</td>';
            $html .= '<td>'.$localizationTranslation->getEntityId().'</td>';
            $html .= '<td>'.$localizationTranslation->getText().'</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        return new Response($html);
    }

    /**
     * @return null|Profile
     */
    private function getCurrentProfile()
    {
        $profileId = $this->container->getParameter('licom_profile_id');
        $profileRepository = $this->get('visca_licom.repository.profile');

        return $profileRepository->findOneBy(['id' => $profileId]);
    }
}
