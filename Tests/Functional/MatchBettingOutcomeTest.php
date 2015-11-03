<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Code\BettingOutcomeSubTypeCode;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\OverUnderMatchBettingOutcome;
use Visca\Bundle\LicomBundle\Entity\Participant;
use Visca\Bundle\LicomBundle\Entity\ThreeWayMatchBettingOutcome;

/**
 * Class MatchBettingOutcomeTest.
 */
class MatchBettingOutcomeTest extends FixturesTestCase
{
    /**
     * Test to find MatchBettingOutcome by Match and type.
     */
    public function testFindByMatchAndType()
    {
        /*
         * Match validation
         */
        $matchRepo = $this
            ->getContainer()
            ->get('doctrine.orm.licom_entity_manager')
            ->getRepository('ViscaLicomBundle:Match');

        $matchId = 1;
        $match = $matchRepo->find($matchId);
        $this->assertInstanceOf(Match::class, $match);

        /*
         * MatchBettingOutcome validation
         */
        $matchBettingOutcomeRepo = $this
            ->getContainer()
            ->get('doctrine.orm.licom_entity_manager')
            ->getRepository('ViscaLicomBundle:MatchBettingOutcome');

        /** @var ThreeWayMatchBettingOutcome[] $outcomes */
        $outcomes = $matchBettingOutcomeRepo->findByMatchAndType(
            $matchId,
            [
                ThreeWayMatchBettingOutcome::class,
            ]
        );

        $this->assertValidThreeWayMatchOutcome($outcomes, $matchId);

        /** @var OverUnderMatchBettingOutcome[] $outcomes */
        $outcomes = $matchBettingOutcomeRepo->findByMatchAndType(
            $matchId,
            [
                OverUnderMatchBettingOutcome::class,
            ]
        );

        $this->assertOverUnderMatchOutcome($outcomes, $matchId);
    }

    /**
     * @param ThreeWayMatchBettingOutcome[] $threeWayOutcomes
     * @param int                           $matchId
     */
    private function assertValidThreeWayMatchOutcome(
        $threeWayOutcomes,
        $matchId
    ) {
        $this->assertCount(3, $threeWayOutcomes);

        $winnerOutcomeKeys = [0, 2];

        foreach ($winnerOutcomeKeys as $winnerOutcomeKey) {
            $winnerOutcome = $threeWayOutcomes[$winnerOutcomeKey];

            $this->assertInstanceOf(
                ThreeWayMatchBettingOutcome::class,
                $winnerOutcome
            );

            $this->assertEquals(
                BettingOutcomeSubTypeCode::WIN_CODE,
                $winnerOutcome->getSubType()->getId()
            );

            $this->assertEquals(
                $matchId,
                $winnerOutcome->getMatch()->getId()
            );

            $this->assertInstanceOf(
                Participant::class,
                $winnerOutcome->getWinner()
            );
        }

        $drawOutcome = $threeWayOutcomes[1];

        $this->assertEquals(
            BettingOutcomeSubTypeCode::DRAW_CODE,
            $drawOutcome->getSubType()->getId()
        );

        $this->assertNull($drawOutcome->getWinner());
    }

    /**
     * @param OverUnderMatchBettingOutcome[] $overUnderOutcomes
     * @param int                            $matchId
     */
    private function assertOverUnderMatchOutcome(
        $overUnderOutcomes,
        $matchId
    ) {
        $this->assertCount(2, $overUnderOutcomes);

        /*
         * Over
         */
        $overOutcome = $overUnderOutcomes[0];

        $this->assertInstanceOf(
            OverUnderMatchBettingOutcome::class,
            $overOutcome
        );

        $this->assertEquals(
            BettingOutcomeSubTypeCode::OVER_CODE,
            $overOutcome->getSubType()->getId()
        );

        $this->assertEquals($matchId, $overOutcome->getMatch()->getId());
        $this->assertEquals(2.5, $overOutcome->getGoalsTotal());

        /*
         * Under
         */
        $underOutcome = $overUnderOutcomes[1];
        $this->assertInstanceOf(
            OverUnderMatchBettingOutcome::class,
            $underOutcome
        );

        $this->assertEquals(
            BettingOutcomeSubTypeCode::UNDER_CODE,
            $underOutcome->getSubType()->getId()
        );
        $this->assertEquals(2.5, $underOutcome->getGoalsTotal());
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/'
            .'fixtures/alice/tests/MatchBettingOutcomeTest/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
