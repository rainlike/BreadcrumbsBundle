<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Rainlike\BreadcrumbsBundle\DependencyInjection
 * @link http://symfony.com/doc/current/cookbook/bundles/configuration.html
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rainlike_breadcrumbs');

        $rootNode
            ->children()
                ->booleanNode('enable_translation')
                    ->defaultTrue()
                ->end()
                ->scalarNode('translation_domain')
                    ->defaultValue('messages')
                ->end()
                ->scalarNode('template')
                    ->defaultValue('breadcrumbs.html.twig')
                ->end()
                ->scalarNode('separator')
                    ->defaultValue(' / ')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
