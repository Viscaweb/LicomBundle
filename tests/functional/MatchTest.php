<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Code\MatchAuxTypeCode;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Entity\MatchParticipant;
use Visca\Bundle\LicomBundle\Repository\MatchRepository;
use Visca\Bundle\LicomBundle\Test\Assertion\DataTestAssertion;

/**
 * Class MatchTest.
 */
class MatchTest extends FixturesTestCase
{
    /**
     * @var DataTestAssertion
     */
    protected $dataTestAssertion;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->dataTestAssertion = new DataTestAssertion();
    }

    /**
     * testToGetParticipantsFromMatches.
     */
    public function testToGetParticipantsFromMatches()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Match',
                'licom'
            );

        /** @var Match $match */
        $match = $repository->findOneBy(
            ['name' => 'Real Madrid - Atletico Madrid']
        );

        /** @var MatchParticipant[] $matchParticipants */
        $matchParticipants = $match->getMatchParticipant();

        $this->assertCount(2, $matchParticipants);

        foreach ($matchParticipants as $matchParticipant) {
            $participant = $matchParticipant->getParticipant();

            $this->assertInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Team',
                $participant
            );

            $this->assertNotInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Athlete',
                $participant
            );

            $this
                ->dataTestAssertion
                ->assertMatchParticipantIsValid($matchParticipant);
        }
    }

    /**
     * testToGetMatchesByCompetitionId.
     */
    public function testToGetMatchesByCompetitionId()
    {
        /** @var MatchRepository $repository */
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Match',
                'licom'
            );

        $matches = $repository->findByCompetitionId(1);

        $this->assertNotEmpty($matches);
    }

    /**
     * Test to get some Aux by using getAuxByKey method.
     */
    public function testGetAuxByKeyMethodReturnValidAuxValue()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Match',
                'licom'
            );

        /** @var Match $match */
        $match = $repository->findOneBy(
            ['name' => 'Real Madrid - Atletico Madrid']
        );

        $this->assertEquals(
            '80000',
            $match->getAuxByKey(MatchAuxTypeCode::SPECTATORS_CODE)
        );
    }

    /**
     * Test if coverage can have multiple value.
     */
    public function testCoverageCanHaveMultipleValues()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Match',
                'licom'
            );

        /** @var Match $match */
        $match = $repository->findOneBy(
            ['name' => 'Match with only live coverage']
        );
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_LIVE));
        $this->assertFalse($match->hasCoverage(Match::COVERAGE_LINEUP));
        $this->assertFalse($match->hasCoverage(Match::COVERAGE_COMMENT));

        /** @var Match $match */
        $match = $repository
            ->findOneBy(
                ['name' => 'Match with lineup']
            );
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_LIVE));
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_LINEUP));
        $this->assertFalse($match->hasCoverage(Match::COVERAGE_COMMENT));

        /** @var Match $match */
        $match = $repository
            ->findOneBy(
                ['name' => 'Match with lineup and comment']
            );
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_LIVE));
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_LINEUP));
        $this->assertTrue($match->hasCoverage(Match::COVERAGE_COMMENT));
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/'
            .'fixtures/alice/tests/MatchTest/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
