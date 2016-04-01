<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Competition;
use Visca\Bundle\LicomBundle\Repository\CompetitionRepository;
use Visca\Bundle\LicomBundle\Repository\CompetitionSeasonRepository;

/**
 * Class CompetitionTest.
 */
class CompetitionTest extends FixturesTestCase
{
    /**
     * testChampionsLeagueStructure.
     */
    public function testChampionsLeagueStructure()
    {
        /** @var CompetitionRepository $competitionRepository */
        $competitionRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('ViscaLicomBundle:Competition', 'licom');

        /** @var CompetitionSeasonRepository $competitionSeasonRepository */
        $competitionSeasonRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository('ViscaLicomBundle:CompetitionSeason', 'licom');

        /** @var Competition $competition */
        $competition = $competitionRepository->findOneBy(
            ['name' => 'UEFA Champions League']
        );

        $this->assertEquals(
            '14/15',
            $competitionSeasonRepository
                ->findByCompetitionAndLabel($competition->getId(), 1)
                ->getName()
        );

        $this->assertEquals(
            '14/15',
            $competitionSeasonRepository
                ->findByCompetitionAndLabel($competition->getId(), 3)
                ->getName()
        );

        $this->assertEquals(
            '13/14',
            $competitionSeasonRepository
                ->findByCompetitionAndLabel($competition->getId(), 4)
                ->getName()
        );

        $this->assertNull(
            $competitionSeasonRepository
                ->findByCompetitionAndLabel($competition->getId(), 2)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/'
            .'fixtures/alice/tests/CompetitionTest/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
