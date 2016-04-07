<?php

namespace Visca\Bundle\LicomBundle\Tests\Functional\Repository;

use Symfony\Component\HttpKernel\KernelInterface;
use Visca\Bundle\CoreBundle\Test\FixturesTestCase;

/**
 * Class ProfileEntityGraphRepositoryTest.
 */
class ProfileEntityGraphRepositoryTest extends FixturesTestCase
{
    /**
     * Test.
     */
    public function testFindAll()
    {
        $repository = $this
            ->getContainer()
            ->get('visca_licom.repository.profile_entity_graph');

        $entities = $repository->findAll();

        $this->assertNotEmpty($entities);
    }

    /**
     * {@inheritdoc}
     */
    protected function getFixtures(KernelInterface $kernel, $testName)
    {
        $baseFolder = '@ViscaLicomBundle/Resources/config/fixtures/alice/tests/ProfileEntityGraphRepository/';

        return [
            'licom' => [
                $kernel->locateResource(
                    $baseFolder.$testName.'.yml'
                ),
            ],
        ];
    }
}
