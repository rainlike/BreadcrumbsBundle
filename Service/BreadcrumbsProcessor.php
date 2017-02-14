<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Symfony\Component\Routing\Router;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Translation\Translator;
use Symfony\Bundle\TwigBundle\TwigEngine as Twig;

use Rainlike\BreadcrumbsBundle\Model\BreadcrumbItem;
use Rainlike\BreadcrumbsBundle\Model\BreadcrumbProcessItem;

use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsBuilder as Builder;

/**
 * Class BreadcrumbsProcessor
 * @package Rainlike\BreadcrumbsBundle\Service
 */
class BreadcrumbsProcessor
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var Twig
     */
    private $twig;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * Default enable translation value
     * @var bool
     */
    const DEFAULT_ENABLE_TRANSLATION = true;

    /**
     * Default translation domain
     * @var string
     */
    const DEFAULT_TRANSLATION_DOMAIN = 'messages';

    /**
     * Default template of breadcrumbs
     * @var string
     */
    const DEFAULT_TEMPLATE = 'default_template.html.twig';
//
//    /**
//     * Default separator of breadcrumbs
//     * @var string
//     */
//    const DEFAULT_SEPARATOR = ' / ';
//
//    /**
//     * Name for render breadcrumbs in Twig
//     * @var string
//     */
//    public static $twig_function_name = 'rainlike_breadcrumbs';

    /**
     * Processing configurations
     * @var array
     */
    private $process_configs;

    /**
     * Breadcrumbs constructor
     *
     * @param Router $router
     * @param Translator $translator
     * @param Twig $twig
     * @param Kernel $kernel
     */
    public function __construct(
        Router $router,
        Translator $translator,
        Twig $twig,
        Kernel $kernel
    ) {
        $this->router = $router;
        $this->translator = $translator;
        $this->twig = $twig;
        $this->kernel = $kernel;
    }

    /**
     * Prepare breadcrumbs for render
     *
     * @param array $buildItems
     * @return array
     */
    public function process(array $buildItems)
    {
        $breadcrumbs = [];

        foreach ($buildItems as $buildItem) {
            $breadcrumbs[] = new BreadcrumbProcessItem(
                $this->translateItem($buildItem),
                $this->router->generate($buildItem->getRoute(), $buildItem->getRouteParameters())
            );
        }

        return $breadcrumbs;
    }

    /**
     * Render breadcrumbs
     *
     * @param Builder $builder
     * @param array $configs
     * @return string
     */
    public function render(Builder $builder, array $configs)
    {
        $this->builder = $builder;
        $this->process_configs = $configs;

        $items = $this->process($builder->getItems());

        return $this->twig->render($this->getTemplate(), $items);
    }

    /**
     * Translate Breadcrumb item
     * -helper function
     *
     * @param BreadcrumbItem $item
     * @return string
     */
    private function translateItem(BreadcrumbItem $item): string
    {
        if (!$this->getConfig($item, 'enable_translation')) {
            return $item->getLabel();
        }

        $domain = $this->getConfig($item, 'translation_domain');
        $parameters = $this->prepareTranslationParameters($item->getTranslationParameters());

        return $this->translator->trans($item->getLabel(), $parameters, $domain);
    }

    /**
     * Get Breadcrumb config by name
     * -helper function
     *
     * @param BreadcrumbItem $item
     * @param string $configName
     * @return bool|string|mixed
     */
    private function getConfig(BreadcrumbItem $item, string $configName)
    {
        $kernelConfigName = 'rainlike_breadcrumbs.'.$configName;
        $constName = 'DEFAULT_'.strtoupper($configName);

        if (isset($item->getTranslationParameters()[$configName])) {
            return $item->getTranslationParameters()[$configName];
        } elseif (isset($this->process_configs[$configName])) {
            return $this->process_configs[$configName];
        } elseif (isset($this->builder->getConfigs()[$configName])) {
            return $this->builder->getConfigs()[$configName];
        } elseif ($this->kernel->getContainer()->hasParameter($kernelConfigName)) {
            return $this->kernel->getContainer()->getParameter($kernelConfigName);
        } else {
            return constant($constName);
        }
    }

    /**
     * Get Template for Breadcrumbs
     * -helper function
     *
     * @return string
     */
    private function getTemplate()
    {
        if (isset($this->process_configs['template'])) {
            return (string)$this->process_configs['template'];
        } elseif (isset($this->builder->getConfigs()['template'])) {
            return (string)$this->builder->getConfigs()['template'];
        } elseif ($this->kernel->getContainer()->hasParameter('rainlike_breadcrumbs.template')) {
            return (string)$this->kernel->getContainer()->getParameter('rainlike_breadcrumbs.template');
        } else {
            return self::DEFAULT_TEMPLATE;
        }
    }

    /**
     * Prepare parameters for translate
     * -helper function
     *
     * @param array $translationParameters
     * @return array
     */
    private function prepareTranslationParameters(array $translationParameters)
    {
        if (isset($translationParameters['enable_translation'])) {
            unset($translationParameters['enable_translation']);
        }

        if (isset($translationParameters['translation_domain'])) {
            unset($translationParameters['translation_domain']);
        }

        return $translationParameters;
    }

}
