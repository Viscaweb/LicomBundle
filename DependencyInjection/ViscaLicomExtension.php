<?php

namespace Visca\Bundle\LicomBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ViscaLicomExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /*
         * Load the configuration
         */
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');
        $loader->load('parameters.yml');

        $this->loadProviders($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadProviders(array $config, ContainerBuilder $container)
    {
        if (isset($config['provider']['timezone'])) {
            $container->setAlias(
                'visca_licom.provider.timezone',
                $config['provider']['timezone']
            );
        }
    }
}
