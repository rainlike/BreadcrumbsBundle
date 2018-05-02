<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class RainlikeBreadcrumbsExtension
 *
 * @package Rainlike\BreadcrumbsBundle\DependencyInjection
 */
class RainlikeBreadcrumbsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'rainlike_breadcrumbs';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('rainlike_breadcrumbs.enable_translation', $config['enable_translation']);
        $container->setParameter('rainlike_breadcrumbs.translation_domain', $config['translation_domain']);
        $container->setParameter('rainlike_breadcrumbs.template', $config['template']);
        $container->setParameter('rainlike_breadcrumbs.separator', $config['separator']);
    }
}
