<?php

namespace Visca\Bundle\LicomBundle\tests\functional\Repository;

use Tests\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Sport;
use Visca\Bundle\LicomBundle\Repository\Counter\MatchCounterRepository;

class MatchCounterRepositoryTest extends WebTestCase
{
    /** @var string */
    protected $fixturesPath;

    /** @var FixturesLoader */
    protected $fixtureLoader;

    /** @var MatchCounterRepository */
    protected $matchCounterRepository;

    /**
     * @test
     */
    public function when_there_are_live_matches_today_and_yesterday_night()
    {
        $this->fixtureLoader->load('licom', [$this->fixturesPath.'/testLiveMatches.yml']);

        $sport = new Sport();
        $sport->setId(1);
        $count = $this->matchCounterRepository->countLiveMatchesBySport($sport);

        $this->assertEquals(4, $count);
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->matchCounterRepository = $this->getContainer()->get('visca_licom.provider.match_counter');

        $this->fixturesPath = dirname(dirname(dirname(__DIR__))).'/Resources/config/fixtures/alice/tests/MatchRepository';
        $this->fixtureLoader = $this->getContainer()->get('visca_core.test.fixtures.loader');
        $this->loadFixtureFiles([], false, 'licom');
    }
}
