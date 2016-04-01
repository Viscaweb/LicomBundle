<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional\Repository;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;

/**
 * Class StandingRepositoryTest.
 */
class StandingRepositoryTest extends FixturesTestCase
{
    /**
     * Test that the method return valid data.
     */
    public function testFindByViewMethodReturnValidData()
    {
        $standingRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager('licom')
            ->getRepository('ViscaLicomBundle:Standing');

        $standing = $standingRepository->findByView(509, 1, 2);

        $this->assertInstanceOf(
            '\Visca\Bundle\LicomBundle\Entity\Standing',
            $standing
        );

        /*
         * Test the rows
         */
        $rows = $standing->getStandingRow();
        $this->assertCount(2, $rows);

        foreach ($rows as $row) {
            $this->assertInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\StandingRow',
                $row
            );
        }

        /*
         * We need to check that there are no StandingColumn 4 (drawAway)
         * because we filter on StandingView 2 which is CompetitionTableHome
         * so we have StandingColumn 5 (drawHome) but not StandingColumn 4 (drawAway)
         * otherwise it means there is no filtration applied
         */
    }

    /**
     * Test to get a CardsStatistics standing view data.
     */
    public function testFindByViewWithCardsStatisticStandingReturnValidData()
    {
        $standingRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager('licom')
            ->getRepository('ViscaLicomBundle:Standing');

        $standing = $standingRepository->findByView(509, 1, 12);

        $this->assertInstanceOf(
            '\Visca\Bundle\LicomBundle\Entity\Standing',
            $standing
        );

        /*
         * Test the rows
         */
        $rows = $standing->getStandingRow();
        $this->assertCount(2, $rows);

        /*
         * We should have 3 cells:
         *  - red cards
         *  - yellow cards
         *  - total matches
         */
        foreach ($rows as $row) {
            $cells = $row->getStandingCell();
            $this->assertCount(3, $cells);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/fixtures/alice/tests/StandingRepository/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
