<?php

namespace Visca\Bundle\LicomBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

/**
 * Class LoadLicomData.
 */
class LoadLicomData extends DataFixtureLoader implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__.'/../../Resources/config/fixtures/alice/sets/default.yml',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 50;
    }
}
