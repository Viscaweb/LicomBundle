<?php

namespace Visca\Bundle\LicomBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class OddsFormatterCompilerPass.
 */
final class OddsFormatterCompilerPass implements CompilerPassInterface
{
    const VALIDATOR_SERVICE_ID = 'visca_licom.chain.formatter.odds';
    const TAG = 'visca_licom.formatter.odds';

    /**
     * @param ContainerBuilder $container The container
     */
    public function process(ContainerBuilder $container)
    {
        /*
         * Check that we have the definition for the chain where to save the odds formatter.
         */
        if (!$container->hasDefinition(self::VALIDATOR_SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::VALIDATOR_SERVICE_ID);

        /*
         * Find all the odds formatter.
         */
        $taggedServices = $container->findTaggedServiceIds(self::TAG);

        /*
         * Then register them in the chain
         */
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['label'])) {
                    continue;
                }
                $definition->addMethodCall(
                    'attach',
                    [$tag['label'], new Reference($id)]
                );
            }
        }
    }
}
