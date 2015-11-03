<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Services\Translations\TranslationCacheManager;
use Visca\Bundle\LicomViewBundle\Twig\Entity\TranslatableDemonymExtension;
use Visca\Bundle\LicomViewBundle\Twig\Entity\TranslatableNickNameExtension;
use Visca\Bundle\LicomViewBundle\Twig\Entity\TranslatableShortNameExtension;
use Visca\Bundle\LicomViewBundle\Twig\Entity\TranslatableTrigraphExtension;

/**
 * Class TranslationsTest.
 */
class TranslationsTest extends FixturesTestCase
{
    /**
     * @var TranslationCacheManager
     */
    protected $translationCacheManager;

    /**
     * @var TranslatableShortNameExtension;
     */
    protected $translatableShortNameExtension;

    /**
     * @var TranslatableDemonymExtension;
     */
    protected $translatableDemonymExtension;

    /**
     * @var TranslatableTrigraphExtension;
     */
    protected $translatableTrigraphExtension;

    /**
     * @var TranslatableNicknameExtension;
     */
    protected $translatableNicknameExtension;

    /**
     * @var int
     */
    protected $profile;

    /**
     * Set up.
     */
    protected function setUp()
    {
        parent::setUp();

        $kernel = static::createKernel();
        $kernel->boot();
        $this->translationCacheManager = $kernel->getContainer()->get(
            'visca_licom.cache.manager.translations'
        );
        $this->translatableShortNameExtension = $kernel->getContainer()->get(
            'visca_licom.twig_extension.entity.translatable_shortname'
        );
        $this->translatableDemonymExtension = $kernel->getContainer()->get(
            'visca_licom.twig_extension.entity.translatable_demonym'
        );
        $this->translatableTrigraphExtension = $kernel->getContainer()->get(
            'visca_licom.twig_extension.entity.translatable_trigraph'
        );
        $this->translatableNicknameExtension = $kernel->getContainer()->get(
            'visca_licom.twig_extension.entity.translatable_nickname'
        );
        $this->profile = $kernel->getContainer()->getParameter(
            'licom_profile_id'
        );
    }

    /**
     * testCompetition.
     *
     * @backupGlobals disabled
     * @backupStaticAttributes disabled
     */
    public function testTranslations()
    {
        $this->competitionTranslations();
        $this->competitionCategoryTranslations();
        $this->competitionStageTranslations();
        $this->countryTranslations();
        $this->matchStatusDescriptionTranslations();
        $this->participantTranslations();
        $this->sportTranslations();
    }

    /**
     * Test sports translations
     */
    private function sportTranslations()
    {
        $name = 'sport-translation';
        $this->translationCacheManager->setEntity(EntityCode::SPORT_CODE);
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Sport',
                'licom'
            );
        $sport = $repository->find(1);
        $this->assertEquals($sport->getName(), $name);
    }

    /**
     * Test participant translations
     */
    private function participantTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::PARTICIPANT_CODE);
        $name = 'participant-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Participant',
                'licom'
            );
        $participant = $repository->find(1);
        $this->assertEquals($participant->getName(), $name);

        //test shortName
        $name = 'participant-short-name-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
            $name
        );
        $result = $this->translatableShortNameExtension->getShortName($participant);
        $this->assertEquals($result, $name);

        //test trigraph
        $name = 'participant-trigraph-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::TRIGRAPH_CODE,
            $name
        );
        $result = $this->translatableTrigraphExtension->getTrigraph($participant);
        $this->assertEquals($result, $name);

        //test nickname male singular
        $name = 'participant-nickname-male-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::NICKNAME_MALE_SIN_CODE,
            $name
        );
        $result = $this->translatableNicknameExtension->getNicknameMaleSingular($participant);
        $this->assertEquals($result, $name);

        //test nickname male plural
        $name = 'participant-nickname-male-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::NICKNAME_MALE_PLU_CODE,
            $name
        );
        $result = $this->translatableNicknameExtension->getNicknameMalePlural($participant);
        $this->assertEquals($result, $name);

        //test nickname female singular
        $name = 'participant-nickname-female-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::NICKNAME_FEMALE_SIN_CODE,
            $name
        );
        $result = $this->translatableNicknameExtension->getNicknameFemaleSingular($participant);
        $this->assertEquals($result, $name);

        //test nickname female plural
        $name = 'participant-nickname-female-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::NICKNAME_FEMALE_PLU_CODE,
            $name
        );
        $result = $this->translatableNicknameExtension->getNicknameFemalePlural($participant);
        $this->assertEquals($result, $name);

        //test demonym male singular
        $name = 'participant-demonym-male-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_SIN_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymMaleSingular($participant);
        $this->assertEquals($result, $name);

        //test demonym male plural
        $name = 'participant-demonym-male-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_PLU_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymMalePlural($participant);
        $this->assertEquals($result, $name);

        //test demonym female singular
        $name = 'participant-demonym-female-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_SIN_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymFemaleSingular($participant);
        $this->assertEquals($result, $name);

        //test demonym female plural
        $name = 'participant-demonym-female-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_PLU_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymFemalePlural($participant);
        $this->assertEquals($result, $name);
    }

    /**
     * Test match status translations
     */
    private function matchStatusDescriptionTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::MATCH_STATUS_DESCRIPTION_CODE);
        $name = 'match-status-description-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:MatchStatusDescription',
                'licom'
            );
        $matchStatusDescription = $repository->find(1);
        $this->assertEquals($matchStatusDescription->getName(), $name);

        //test shortName
        $name = 'match-status-description-short-name-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
            $name
        );
        $result = $this->translatableShortNameExtension->getShortName($matchStatusDescription);
        $this->assertEquals($result, $name);
    }

    /**
     * Test countries translations
     */
    private function countryTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::COUNTRY_CODE);
        $name = 'country-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Country',
                'licom'
            );
        $country = $repository->find(1);
        $this->assertEquals($country->getName(), $name);

        //test Demonym Male Singular
        $name = 'country-demonym-male-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_SIN_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymMaleSingular($country);
        $this->assertEquals($result, $name);

        //test Demonym Male Plural
        $name = 'country-demonym-male-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_MALE_PLU_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymMalePlural($country);
        $this->assertEquals($result, $name);

        //test Demonym Female Singular
        $this->translationCacheManager->setEntity(EntityCode::COUNTRY_CODE);
        $name = 'country-demonym-female-singular-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_SIN_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymFemaleSingular($country);
        $this->assertEquals($result, $name);

        //test Demonym Female Plural
        $this->translationCacheManager->setEntity(EntityCode::COUNTRY_CODE);
        $name = 'country-demonym-female-plural-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::DEMONYMS_FEMALE_PLU_CODE,
            $name
        );
        $result = $this->translatableDemonymExtension->getDemonymFemalePlural($country);
        $this->assertEquals($result, $name);
    }

    /**
     * Test competition stage translations
     */
    private function competitionStageTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::COMPETITION_STAGE_CODE);
        $name = 'competition-stage-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:CompetitionStage',
                'licom'
            );
        $competitionStage = $repository->find(1);
        $this->assertEquals($competitionStage->getName(), $name);

        //test shortName
        $name = 'competition-stage-short-name-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
            $name
        );
        $result = $this->translatableShortNameExtension->getShortName($competitionStage);
        $this->assertEquals($result, $name);
    }

    /**
     * Test competition category translations
     */
    private function competitionCategoryTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::COMPETITION_CATEGORY_CODE);
        //test Name translation
        $name = 'competition-category-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:CompetitionCategory',
                'licom'
            );
        $competitionCategory = $repository->find(1);
        $this->assertEquals($competitionCategory->getName(), $name);
    }

    /**
     * Test competition translations
     */
    private function competitionTranslations()
    {
        $this->translationCacheManager->setEntity(EntityCode::COMPETITION_CODE);
        //test Name translation
        $name = 'competition-translation';
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $name);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Competition',
                'licom'
            );
        $competition = $repository->find(1);
        $this->assertEquals($competition->getName(), $name);

        //test shortName
        $name = 'competition-short-name-translation';
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
            $name
        );
        $result = $this->translatableShortNameExtension->getShortName($competition);
        $this->assertEquals($result, $name);
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/'
            .'fixtures/alice/tests/TranslationsTest/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
