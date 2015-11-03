<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional\Repository;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;

/**
 * Class MatchRepositoryTest.
 */
class MatchRepositoryTest extends FixturesTestCase
{
    /**
     * Test that findMatchIdByPeriodMethod return an array.
     */
    public function testFindMatchIdByPeriodMethod()
    {
        /*
         * There are 3 matches in the fixtures
         * But only 1 in the 2000 year
         * The others are in 1999 and 2001
         */
        $expectedMatchIdArray = [2];

        $matchRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager('licom')
            ->getRepository('ViscaLicomBundle:Match');

        $periodFrom = new \DateTime('2000-01-01');
        $periodTo = new \DateTime('2000-12-31');

        $matchIdArray = $matchRepository->findMatchIdByPeriod(
            $periodFrom,
            $periodTo
        );

        $this->assertInternalType('array', $matchIdArray);
        $this->assertEquals($expectedMatchIdArray, $matchIdArray);
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/fixtures/alice/tests/MatchRepository/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
