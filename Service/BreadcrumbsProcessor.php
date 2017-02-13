<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;
use Symfony\Bundle\TwigBundle\TwigEngine as Twig;

use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsBuilder;
use Rainlike\BreadcrumbsBundle\Model\BreadcrumbProcessItem;

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
     * @var BreadcrumbsBuilder
     */
    private $builder;

    /**
     * Main configurations
     * @var array
     */
    private $configs;

//    /**
//     * Default domain
//     * @var string
//     */
//    const DEFAULT_TRANSLATION_DOMAIN = 'messages';
//
//    /**
//     * Default template of breadcrumbs
//     * @var string
//     */
//    const DEFAULT_TEMPLATE = '';
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
     * Processing template
     * @var string
     */
    private $process_template;

    /**
     * Processing translation domain
     * @var string
     */
    private $process_translation_domain;

    /**
     * Breadcrumbs constructor
     *
     * @param Router $router
     * @param Translator $translator
     * @param Twig $twig
     * @param array $configs
     */
    public function __construct(
        Router $router,
        Translator $translator,
        Twig $twig,
        array $configs
    ) {
        $this->router = $router;
        $this->translator = $translator;
        $this->twig = $twig;
        $this->configs = $configs;
    }

    /**
     * Prepare breadcrumbs for render
     *
     * @param array $preProcessItems
     * @return array
     */
    public function process(array $preProcessItems)
    {
        $breadcrumbs = [];

        foreach ($preProcessItems as $preProcessItem) {
            $breadcrumbs[] = new BreadcrumbProcessItem(
                $this->translateItem($preProcessItem->getLabel(), $preProcessItem->getTranslationParameters()),
                $this->router->generate($preProcessItem->getRoute(), $preProcessItem->getRouteParameters())
            );
        }

        return $breadcrumbs;
    }

    /**
     * Render breadcrumbs
     *
     * @param BreadcrumbsBuilder $builder
     * @param string|null $template
     * @param string|null $translationDomain
     */
    public function render(BreadcrumbsBuilder $builder, ?string $template = null, ?string $translationDomain = null)
    {
        $this->processorSetter($builder, $template, $translationDomain);

        $items = $this->process($builder->getItems());

        return $this->twig->render($this->getTemplate());
    }

    /**
     * Get template for breadcrumbs
     *
     * @return string
     */
    private function getTemplate()
    {
        if (!is_null($this->process_template)) {
            return $this->process_template;
        }

        // @TODO: use parameter
        //if (false) {
        //    return '';
        //}

        return BreadcrumbsBuilder::DEFAULT_TEMPLATE;
    }

    /**
     * Translate Breadcrumb item
     * -helper function
     *
     * @param string $label
     * @param array $parameters
     * @return string
     */
    private function translateItem(string $label, array $parameters = []): string
    {
        $domain = null;
        if (array_key_exists('domain', $parameters)) {
            $domain = $parameters['domain'];
            unset($parameters['domain']);
        }

        return $this->builder->getTranslationMod()
            ? $this->translator->trans($label, $parameters, $this->builder->getTranslationDomain($domain))
            : $label;
    }

    /**
     * Set other Processor components
     * -helper function
     *
     * @param BreadcrumbsBuilder $builder
     * @param string|null $template
     * @param string|null $translationDomain
     * @return void
     */
    private function processorSetter(
        BreadcrumbsBuilder $builder,
        ?string $template = null,
        ?string $translationDomain = null
    ) {
        $this->builder = $builder;
        $this->process_template = $template;
        $this->process_translation_domain = $translationDomain;
    }


    /**
     * Get correct translation domain
     *
     * @param string|null $itemDomain
     * @return string
     */
    public function getTranslationDomain(string $itemDomain = null): string
    {
        if (!is_null($itemDomain)) {
            return $itemDomain;
        }

        if (isset($this->translation_domain)) {
            return $this->translation_domain;
        }

        return self::DEFAULT_TRANSLATION_DOMAIN;
    }

}
