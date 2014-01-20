<?php

namespace Fabstei\ShorturlBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Config\FileLocator,
    Symfony\Component\Config\Definition\Processor,
    Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FabsteiShorturlExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $processor     = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('fabstei_shorturl.url_controller', $config['url_controller']);
        $container->setParameter('fabstei_shorturl.redirect_class', $config['redirect_class']);
        $container->setParameter('fabstei_shorturl.codeset', $config['codeset']);
        $container->setParameter('fabstei_shorturl.url_class', $config['url_class']);
        $container->setParameter('fabstei_shorturl.url_manager_class', $config['url_manager_class']);
        $container->setParameter('fabstei_shorturl.tokenizer_class', $config['tokenizer_class']);
    }

    public function getAlias()
    {
        return 'fabstei_shorturl';
    }
}
