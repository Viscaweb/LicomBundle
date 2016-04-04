<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional\DataFixtures\ORM;

use Visca\Bundle\CoreBundle\Test\WebTestCase;
use Visca\Bundle\LicomBundle\Entity\Match;
use Visca\Bundle\LicomBundle\Test\Assertion\DataTestAssertion;

/**
 * Class LoadLicomDataTest.
 */
class LoadLicomDataTest extends WebTestCase
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
        $this->setUpDatabases();
        $this->loadFixturesWithCommand(
            [
                'src/Visca/Bundle/LicomBundle/DataFixtures/ORM',
            ],
            'licom'
        );

        $this->dataTestAssertion = new DataTestAssertion();
    }

    /**
     * Test licom fixtures are valid.
     */
    public function testFixtures()
    {
        $matchRepository = $this
            ->getContainer()
            ->get('doctrine')
            ->getManager('licom')
            ->getRepository('ViscaLicomBundle:Match');

        $matches = $matchRepository->findAll();

        $this->assertNotEmpty($matches);

        foreach ($matches as $match) {
            $this->dataTestAssertion->assertLicomMatchIsValid($match);
        }
    }
}
