<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Twig;

use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsBuilder as Builder;
use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsProcessor as Processor;

/**
 * Class BreadcrumbsExtension
 * @package Rainlike\BreadcrumbsBundle\Twig
 */
class BreadcrumbsExtension extends \Twig_Extension
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var Processor
     */
    private $processor;

    /**
     * BreadcrumbsExtension constructor
     *
     * @param Builder $builder
     * @param Processor $processor
     */
    public function __construct(Builder $builder, Processor $processor)
    {
        $this->builder = $builder;
        $this->processor = $processor;
    }

    /**
     * Functions for Twig
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction(
                'rainlike_breadcrumbs',
                [ $this, 'renderBreadcrumbs' ],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                    'needs_context' => true
                ]
            )
        ];
    }

    /**
     * Render breadcrumbs
     *
     * @param \Twig_Environment $twig
     * @param array $context
     * @param array $configs
     * @return string
     */
    public function renderBreadcrumbs(\Twig_Environment $twig, array $context, array $configs = []): string
    {
        return $this->processor->render($this->builder, $configs);
    }

    /**
     * Get extension name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'rainlike.breadcrumbs.extension';
    }
}
