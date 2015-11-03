<?php

namespace Visca\Bundle\LicomViewBundle\Command\Translations;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslationGraphLabel;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslationType;
use Visca\Bundle\LicomBundle\Entity\Profile;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Class AbstractTranslationsCommand.
 */
abstract class AbstractTranslationsCommand extends ContainerAwareCommand
{
    const ENTITY = 'entity';
    const ENTITY_NAME = 'entity name';

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * @param array       $entities
     * @param ProgressBar $progress
     */
    protected function generateAllTranslations(array $entities, ProgressBar $progress)
    {
        $profileId = $this->getContainer()->getParameter('licom_profile_id');
        foreach ($entities as $entity) {
            foreach ($this->properties as $propertyKey => $property) {
                $id = $entity['id'];
                $result = $this->generateTranslation($id, $propertyKey);
                if (empty($result)) {
                    $message = sprintf(
                        'No translation found for entity %s with id: %d for property: %d in profile: %d',
                        static::ENTITY_NAME,
                        $id,
                        $propertyKey,
                        $profileId
                    );
                    $this->getLogger()->addWarning($message);
                    continue;
                }
                $this->getCacheManager()->save($id, $profileId, $property, $result[0]->getText());
                $progress->advance();
            }
        }
    }

    /**
     * @return \Visca\Bundle\LicomBundle\Services\Translations\TranslationCacheManager
     */
    private function getCacheManager()
    {
        $cacheManager = $this->getContainer()->get('visca_licom.cache.manager.translations');
        $cacheManager->setEntity(static::ENTITY);

        return $cacheManager;
    }

    /**
     * @param int $entityId                      EntityId
     * @param int $localizationTranslationTypeId LocalizationTranslationTypeId
     *
     * @return null|\Visca\Bundle\LicomBundle\Entity\LocalizationTranslation[]
     */
    private function generateTranslation($entityId, $localizationTranslationTypeId)
    {
        $currentProfile = $this->getCurrentProfile();
        $translationParticipantNameType = $this->getLocalizationTranslationType(
            $localizationTranslationTypeId
        );
        $translationGraphLabel = $this->getLocalizationTranslationGraphLabel(
            LocalizationTranslationGraphLabelCode::DEFAULT_CODE
        );
        $localizationTranslationRepository = $this->getContainer()->get(
            'visca_licom.repository.localization_translation'
        );
        try {
            $localizationTranslations = $localizationTranslationRepository
                ->findByProfileAndEntityIds(
                    $currentProfile->getId(),
                    $translationParticipantNameType->getId(),
                    $translationGraphLabel->getId(),
                    [$entityId]
                );
        } catch (NoTranslationFoundException $ex) {
            try {
                $localizationTranslations = $localizationTranslationRepository
                    ->findByProfileAndEntityIdsUsingRules(
                        $currentProfile->getId(),
                        $translationParticipantNameType->getId(),
                        [$entityId]
                    );
            } catch (NoTranslationFoundException $ex) {
                $localizationTranslations = null;
            }
        }

        return $localizationTranslations;
    }

    /**
     * @param int $id Id
     *
     * @return null|LocalizationTranslationType
     */
    private function getLocalizationTranslationType($id)
    {
        $localizationTranslationTypeRepository = $this->getContainer()->get(
            'visca_licom.repository.localization_translation_type'
        );

        return $localizationTranslationTypeRepository->findOneBy(['id' => $id]);
    }

    /**
     * @param int $id Id
     *
     * @return null|LocalizationTranslationGraphLabel
     */
    private function getLocalizationTranslationGraphLabel($id)
    {
        $localizationTranslationGraphLabelRepository = $this->getContainer()->get(
            'visca_licom.repository.localization_translation_graph_label'
        );

        return $localizationTranslationGraphLabelRepository->findOneBy(
            ['id' => $id]
        );
    }

    /**
     * @return null|Profile
     */
    private function getCurrentProfile()
    {
        $profileId = $this->getContainer()->getParameter('licom_profile_id');
        $profileRepository = $this->getContainer()->get('visca_licom.repository.profile');

        return $profileRepository->findOneBy(['id' => $profileId]);
    }

    /**
     * @return \Symfony\Bridge\Monolog\Logger
     */
    private function getLogger()
    {
        return $this->getContainer()->get('logger');
    }
}
