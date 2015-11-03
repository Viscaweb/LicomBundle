<?php

namespace Visca\Bundle\LicomViewBundle\Tests\Functional\Twig;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Code\EntityCode;
use Visca\Bundle\LicomBundle\Entity\Code\ProfileTranslationGraphLabelCode;
use Visca\Bundle\LicomBundle\Services\Translations\TranslationCacheManager;
use Visca\Bundle\LicomViewBundle\Twig\Entity\TranslatableAutoNameExtension;

/**
 * TranslatableAutoNameExtensionTest.
 */
class TranslatableAutoNameExtensionTest extends FixturesTestCase
{
    /**
     * @var TranslatableAutoNameExtension
     */
    public $translatableAutoNameExtension;

    /**
     * @var TranslationCacheManager
     */
    protected $translationCacheManager;

    /**
     * @var int
     */
    protected $profile;

    /**
     * setUp().
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->translatableAutoNameExtension = $kernel->getContainer()->get(
            'visca_licom.twig_extension.entity.translatable_autoname'
        );
        $this->translationCacheManager = $kernel->getContainer()->get(
            'visca_licom.cache.manager.translations'
        );
        $this->profile = $kernel->getContainer()->getParameter(
            'licom_profile_id'
        );
    }

    /**
     * Test tag.
     */
    public function testAutoName()
    {
        $this->translationCacheManager->setEntity(EntityCode::PARTICIPANT_CODE);
        $string = substr(hash('sha256', mt_rand()), 0, 20);
        $this->translationCacheManager->save(1, $this->profile, ProfileTranslationGraphLabelCode::NAME_CODE, $string);
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Participant',
                'licom'
            );
        $participant = $repository->find(1);
        $result = $this->translatableAutoNameExtension->getTransAutoName($participant);

        $this->assertEquals($result, $string);

        $string = substr(hash('sha256', mt_rand()), 0, 10);
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::SHORTNAME_CODE,
            $string
        );
        $result = $this->translatableAutoNameExtension->getTransAutoName($participant, 19, 11);
        $this->assertEquals($result, $string);

        $string = substr(hash('sha256', mt_rand()), 0, 3);
        $this->translationCacheManager->save(
            1,
            $this->profile,
            ProfileTranslationGraphLabelCode::TRIGRAPH_CODE,
            $string
        );
        $result = $this->translatableAutoNameExtension->getTransAutoName($participant, 19, 9);
        $this->assertEquals($result, $string);
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
