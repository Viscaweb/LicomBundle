<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional\Command;

use Visca\Bundle\CoreBundle\Test\WebTestCase;

/**
 * Class FixturesLoaderCommandTest.
 */
class FixturesLoaderCommandTest extends WebTestCase
{
    /**
     * @return array
     */
    public function setsProvider()
    {
        $folder = $this
            ->getContainer()
            ->get('kernel')
            ->locateResource(
                '@ViscaLicomBundle/Resources/config/fixtures/alice/sets'
            );

        $files = glob($folder.'/*.yml');

        $testSets = [];

        foreach ($files as $file) {
            $testSets[] = [
                preg_replace('@\.yml$@', '', basename($file)),
            ];
        }

        return $testSets;
    }

    /**
     * @param string $setName
     *
     * @dataProvider setsProvider
     */
    public function testSets($setName)
    {
        $params = [
            'set' => $setName,
        ];

        $this->runCommandWithException('visca:licom:fixtures:load', $params);
    }
}
