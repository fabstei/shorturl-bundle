<?php

namespace Fabstei\ShorturlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fabstei_shorturl');

        $rootNode
            ->children()
                ->scalarNode('redirect_class')
                    ->defaultValue('Fabstei\ShorturlBundle\Controller\RedirectController')
                    ->info('Class used to execute redirections.')
                    ->example('Fabstei\ShorturlBundle\Controller\RedirectController')
                    ->end()
                ->scalarNode('url_controller')
                    ->defaultValue('Fabstei\ShorturlBundle\Controller\UrlController')
                    ->info('Controller to manage redirections.')
                    ->example('Fabstei\ShorturlBundle\Controller\UrlController')
                    ->end()
                ->scalarNode('url_class')
                    ->defaultValue('Fabstei\ShorturlBundle\Entity\Url')
                    ->info('Entity which stores redirections.')
                    ->example('Fabstei\ShorturlBundle\Entity\Url')
                    ->end()
                ->scalarNode('url_manager_class')
                    ->defaultValue('Fabstei\ShorturlBundle\Doctrine\UrlManager')
                    ->info('Url Model Manager.')
                    ->example('Fabstei\ShorturlBundle\Doctrine\UrlManager')
                    ->end()
                ->scalarNode('codeset')
                    ->defaultValue('abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789')
                    ->info('Codeset used to calculate unique shorturl tokens.')
                    ->example('"abc", "abcABC123" or also "abcABCD123-!"')
                    ->end()
                ->scalarNode('tokenizer_class')
                    ->defaultValue('Fabstei\ShorturlBundle\Service\Token')
                    ->info('Service which encodes and decodes uniqe shorturl tokens.')
                    ->example('Fabstei\ShorturlBundle\Service\Token')
                    ->end()
        ->end();

        return $treeBuilder;
    }
}
