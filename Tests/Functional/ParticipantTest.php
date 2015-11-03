<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;
use Visca\Bundle\LicomBundle\Entity\Athlete;
use Visca\Bundle\LicomBundle\Entity\Team;

/**
 * Class ParticipantTest.
 */
class ParticipantTest extends FixturesTestCase
{
    /**
     * testThatWeCanGetAthletesWithoutTeams.
     */
    public function testThatWeCanGetAthletesWithoutTeams()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Athlete',
                'licom'
            );

        /** @var Athlete[] $athletes */
        $athletes = $repository->findAll();

        $this->assertNotEmpty($athletes);

        foreach ($athletes as $athlete) {
            $this->assertInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Athlete',
                $athlete
            );

            $this->assertNotInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Team',
                $athlete
            );
        }
    }

    /**
     * testThatWeCanGetTeamsWithoutAthletes.
     */
    public function testThatWeCanGetTeamsWithoutAthletes()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Team',
                'licom'
            );

        /** @var Team[] $teams */
        $teams = $repository->findAll();

        $this->assertNotEmpty($teams);

        foreach ($teams as $team) {
            $this->assertInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Team',
                $team
            );

            $this->assertNotInstanceOf(
                '\Visca\Bundle\LicomBundle\Entity\Athlete',
                $team
            );
        }
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
                'ViscaLicomBundle:Athlete',
                'licom'
            );

        /** @var Athlete $athlete */
        $athlete = $repository->findOneBy(['name' => 'Athlete0']);

        $this->assertEquals('John', $athlete->getAuxByKey(1));
        $this->assertEquals('Smith', $athlete->getAuxByKey(2));
    }

    /**
     * Test gender is a valid enum.
     */
    public function testGenderIsAnEnumType()
    {
        $repository = $this
            ->getContainer()
            ->get('doctrine')
            ->getRepository(
                'ViscaLicomBundle:Athlete',
                'licom'
            );

        /** @var Athlete $athlete */
        $athlete = $repository->findOneBy(['name' => 'Athlete0']);

        $this->assertEquals('male', $athlete->getGender());
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/'
            .'fixtures/alice/tests/ParticipantTest/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
