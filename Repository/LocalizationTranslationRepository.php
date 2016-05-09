<?php

namespace Visca\Bundle\LicomBundle\Repository;

use Visca\Bundle\DoctrineBundle\Repository\Abstracts\AbstractEntityRepository;
use Visca\Bundle\LicomBundle\Entity\Code\LocalizationTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Entity\Localization;
use Visca\Bundle\LicomBundle\Entity\LocalizationTranslation;
use Visca\Bundle\LicomBundle\Entity\ProfileRule;
use Visca\Bundle\LicomBundle\Exception\NoTranslationFoundException;

/**
 * Class LocalizationTranslationRepository.
 */
class LocalizationTranslationRepository extends AbstractEntityRepository
{
    /**
     * @var ProfileRuleRepository
     */
    protected $repositoryProfileRule;

    /**
     * @var LocalizationRepository
     */
    protected $repositoryLocalization;

    /**
     * @param ProfileRuleRepository $repositoryProfileRule Repository
     */
    public function setRepositoryProfileRule(
        ProfileRuleRepository $repositoryProfileRule
    ) {
        $this->repositoryProfileRule = $repositoryProfileRule;
    }

    /**
     * @param LocalizationRepository $repositoryLocalization Repository
     */
    public function setRepositoryLocalization(
        LocalizationRepository $repositoryLocalization
    ) {
        $this->repositoryLocalization = $repositoryLocalization;
    }

    /**
     * @param int $profileId                     Profile ID
     * @param int $localizationTranslationTypeId Localization Translation Type
     * @param int $profileGraphLabelId           Profile Graph Label ID
     * @param int $entityId                      Entity to look for
     *
     * @return LocalizationTranslation
     * @throws NoTranslationFoundException
     */
    public function findOneByProfile(
        $profileId,
        $localizationTranslationTypeId,
        $profileGraphLabelId,
        $entityId
    ) {
        $localizationTranslations = $this->findByProfileAndEntityIds(
            $profileId,
            $localizationTranslationTypeId,
            $profileGraphLabelId,
            [$entityId]
        );

        return reset($localizationTranslations);
    }

    /**
     * @param int   $profileId                     Profile ID
     * @param int   $localizationTranslationTypeId Localization Translation Type
     * @param int   $profileGraphLabelId           Profile Graph Label ID
     * @param int[] $entityIds                     Entities to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByProfileAndEntityIds(
        $profileId,
        $localizationTranslationTypeId,
        $profileGraphLabelId,
        $entityIds
    ) {
        return $this->findByProfile(
            $profileId,
            $localizationTranslationTypeId,
            $profileGraphLabelId,
            $entityIds
        );
    }

    /**
     * @param int      $profileId                     Profile ID
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param int      $profileGraphLabelId           Profile Graph Label ID
     * @param string[] $textCollection                Text to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByProfileAndText(
        $profileId,
        $localizationTranslationTypeId,
        $profileGraphLabelId,
        $textCollection
    ) {
        return $this->findByProfile(
            $profileId,
            $localizationTranslationTypeId,
            $profileGraphLabelId,
            [],
            $textCollection
        );
    }

    /**
     * @param int      $profileId                     Profile ID
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param int      $profileGraphLabelId           Profile Graph Label ID
     * @param int[]    $filterEntityId                Filter by entity ID
     * @param string[] $filterText                    Filter by text value
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    private function findByProfile(
        $profileId,
        $localizationTranslationTypeId,
        $profileGraphLabelId,
        $filterEntityId = [],
        $filterText = []
    ) {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->join('l.profileTranslationGraph', 'p')
            ->where('p.profile = :profileId')
            ->andWhere('p.profileTranslationGraphLabel = :profileGraphLabelId')
            ->andWhere(
                'l.localizationTranslationType = :localizationTranslationTypeId'
            )
            ->andWhere('l.del = :delValue')
            ->setParameter('profileId', $profileId)
            ->setParameter(
                'profileGraphLabelId',
                $profileGraphLabelId
            )
            ->setParameter(
                'localizationTranslationTypeId',
                $localizationTranslationTypeId
            )
            ->setParameter('delValue', 'no')
            ->getQuery();

        /*
         * Filter by entity
         */
        if (!empty($filterEntityId)) {
            /* Using BINARY make it case-sensitive */
            $qb
                ->andWhere('l.entityId IN (:entityId)')
                ->setParameter('entityId', $filterEntityId);
        }

        /**
         * Filter by text
         */
        if (!empty($filterText)) {
            $qb
                ->andWhere('l.text IN(:text)')
                ->setParameter('text', $filterText);
        }

        $query = $qb->getQuery();
        $this->setCacheStrategy($query);

        $localizationTranslation = $query->getResult();

        if (count($localizationTranslation) === 0) {
            throw new NoTranslationFoundException(
                sprintf('No translation can be found for the given parameters.')
            );
        }

        return $localizationTranslation;
    }

    /**
     * @param int      $profileId                     Profile
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param string[] $textCollection                Text to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByProfileAndTextUsingRules(
        $profileId,
        $localizationTranslationTypeId,
        $textCollection
    ) {
        return $this->findByProfileUsingRules(
            $profileId,
            $localizationTranslationTypeId,
            [],
            $textCollection
        );
    }

    /**
     * @param int   $profileId                     Profile
     * @param int   $localizationTranslationTypeId Localization Translation Type
     * @param int[] $entityIds                     Entities to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByProfileAndEntityIdsUsingRules(
        $profileId,
        $localizationTranslationTypeId,
        $entityIds
    ) {
        return $this->findByProfileUsingRules(
            $profileId,
            $localizationTranslationTypeId,
            $entityIds
        );
    }

    /**
     * @param int      $profileId                     Profile
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param int[]    $filterEntityId                Entities to look for
     * @param string[] $filterText                    Text to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    private function findByProfileUsingRules(
        $profileId,
        $localizationTranslationTypeId,
        $filterEntityId = [],
        $filterText = []
    ) {
        /*
         * Find rules
         */
        $profileRules = $this->repositoryProfileRule->findBy(
            ['profile' => $profileId],
            ['position' => 'ASC']
        );

        /*
         * Find the best translations
         */
        $localizationTranslations = null;
        /** @var ProfileRule $rule */
        foreach ($profileRules as $rule) {
            $ruleType = $rule->getProfileRuleType()->getCode();
            switch ($ruleType) {
                case 'from-localization':
                    $localization = $this->repositoryLocalization->findOneBy(
                        ['id' => $rule->getValue()]
                    );
                    if (!($localization instanceof Localization)) {
                        continue;
                    }

                    try {
                        $localizationTranslations = $this->findByLocalization(
                            $localization->getId(),
                            $localizationTranslationTypeId,
                            $filterEntityId,
                            $filterText
                        );
                        break;
                    } catch (NoTranslationFoundException $ex) {
                        /*
                         * We don't throw this exception straight away because an other rule
                         * could find the translation.
                         * The exception will be throw after all the rules will be checked.
                         */
                    }

                    break;
                default:
                    throw new NoTranslationFoundException(
                        sprintf(
                            'The given ProfileRule (type is "%s") is not yet handled.',
                            $ruleType
                        )
                    );
            }
        }

        if (count($localizationTranslations) === 0) {
            throw new NoTranslationFoundException(
                sprintf('No translation can be found for the given parameters.')
            );
        }

        return $localizationTranslations;
    }

    /**
     * @param int $localizationId                Localization
     * @param int $localizationTranslationTypeId Localization Translation Type
     * @param int $entityId                      Entity to look for
     *
     * @return LocalizationTranslation
     * @throws NoTranslationFoundException
     */
    public function findOneByLocalizationAndEntityId(
        $localizationId,
        $localizationTranslationTypeId,
        $entityId
    ) {
        $localizationTranslations = $this->findByLocalizationAndEntityIds(
            $localizationId,
            $localizationTranslationTypeId,
            [$entityId]
        );

        return reset($localizationTranslations);
    }

    /**
     * @param int   $localizationId                Localization
     * @param int   $localizationTranslationTypeId Localization Translation Type
     * @param int[] $entityIdCollection            Entities to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByLocalizationAndEntityIds(
        $localizationId,
        $localizationTranslationTypeId,
        $entityIdCollection
    ) {
        return $this->findByLocalization(
            $localizationId,
            $localizationTranslationTypeId,
            $entityIdCollection
        );
    }

    /**
     * @param int    $localizationId                Localization
     * @param int    $localizationTranslationTypeId Localization Translation Type
     * @param string $text                          Text to look for
     *
     * @return LocalizationTranslation
     * @throws NoTranslationFoundException
     */
    public function findOneByLocalizationAndText(
        $localizationId,
        $localizationTranslationTypeId,
        $text
    ) {
        $localizationTranslations = $this->findByLocalizationAndText(
            $localizationId,
            $localizationTranslationTypeId,
            [$text]
        );

        return reset($localizationTranslations);
    }

    /**
     * @param int      $localizationId                Localization
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param string[] $textCollection                Text to look for
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    public function findByLocalizationAndText(
        $localizationId,
        $localizationTranslationTypeId,
        $textCollection
    ) {
        return $this->findByLocalization(
            $localizationId,
            $localizationTranslationTypeId,
            [],
            $textCollection
        );
    }

    /**
     * @param int      $localizationId                Localization
     * @param int      $localizationTranslationTypeId Localization Translation Type
     * @param int[]    $filterEntityId                Filter by entity ID
     * @param string[] $filterText                    Filter by text value
     *
     * @return LocalizationTranslation[]
     *
     * @throws NoTranslationFoundException
     */
    private function findByLocalization(
        $localizationId,
        $localizationTranslationTypeId,
        $filterEntityId = [],
        $filterText = []
    ) {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->join('l.localizationTranslationGraph', 'g')
            ->where('g.localization = :localizationId')
            ->andWhere('g.label = :localizationLabel')
            ->andWhere(
                'l.localizationTranslationType = :localizationTranslationTypeId'
            )
            ->andWhere('l.del = :delValue')
            ->setParameter('localizationId', $localizationId)
            ->setParameter(
                'localizationLabel',
                LocalizationTranslationGraphLabelCode::DEFAULT_CODE
            )
            ->setParameter(
                'localizationTranslationTypeId',
                $localizationTranslationTypeId
            )
            ->setParameter('delValue', 'no');

        /*
         * Filter by entity
         */
        if (!empty($filterEntityId)) {
            $qb
                ->andWhere('l.entityId IN (:entityId)')
                ->setParameter('entityId', $filterEntityId);
        }

        /**
         * Filter by text
         */
        if (!empty($filterText)) {
            $qb
                ->andWhere('l.text IN(:text)')
                ->setParameter('text', $filterText);
        }

        $query = $qb->getQuery();
        $this->setCacheStrategy($query);

        $localizationTranslations = $query->getResult();

        if (count($localizationTranslations) === 0) {
            throw new NoTranslationFoundException(
                sprintf('No translation can be found for the given parameters.')
            );
        }

        return $localizationTranslations;
    }
}
