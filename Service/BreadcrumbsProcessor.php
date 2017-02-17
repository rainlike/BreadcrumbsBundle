<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Symfony\Component\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine as Twig;

use Rainlike\BreadcrumbsBundle\Helper\BreadcrumbsHelper as Helper;
use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsBuilder as Builder;
use Rainlike\BreadcrumbsBundle\Model\BreadcrumbProcessItem as ProcessItem;

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
     * @var Twig
     */
    private $twig;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var Builder
     */
    private $builder;

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

    /**
     * Default separator of breadcrumbs
     * @var string
     */
    const DEFAULT_SEPARATOR = ' / ';

    /**
     * Name for render breadcrumbs in Twig
     * @var string
     */
    public static $twig_function_name = 'rainlike_breadcrumbs';

    /**
     * Possible translation parameters for Breadcrumb item
     *
     * @var array
     */
    public static $possible_translation_parameters = [
        'enable_translation',
        'translation_domain'
    ];

    /**
     * BreadcrumbsProcessor constructor
     *
     * @param Router $router
     * @param Twig $twig
     * @param Helper $helper
     */
    public function __construct(
        Router $router,
        Twig $twig,
        Helper $helper
    ) {
        $this->router = $router;
        $this->twig = $twig;
        $this->helper = $helper;
    }

    /**
     * Get value of constant
     *
     * @param string $name
     * @return mixed|string|bool
     */
    public static function getConstant(string $name)
    {
        return constant($name);
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
            $url = $buildItem->getRoute()
                ? $this->router->generate($buildItem->getRoute(), $buildItem->getRouteParameters())
                : null;

            $breadcrumbs[] = new ProcessItem(
                $this->helper->translateItem($buildItem),
                $url
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

        $this->helper->setBuilderConfigs($this->builder->getConfigs());
        $this->helper->setProcessConfigs($configs);

        $items = $this->process($builder->getItems());

        return $this->twig->render($this->helper->getConfig('template'), [
            'items' => $items,
            'separator' => $this->helper->getConfig('separator')
        ]);
    }

}
