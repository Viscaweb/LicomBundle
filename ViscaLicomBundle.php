<?php

namespace Visca\Bundle\LicomBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Visca\Bundle\LicomBundle\DependencyInjection\Compiler\OddsFormatterCompilerPass;

/**
 * Class ViscaLicomBundle
 */
class ViscaLicomBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OddsFormatterCompilerPass());
    }

}
