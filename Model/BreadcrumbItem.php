<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Model;

/**
 * Class BreadcrumbItem
 * @package Rainlike\BreadcrumbsBundle\Model
 */
class BreadcrumbItem
{
    /**
     * Label of Breadcrumb
     * @var string
     */
    private $label;

    /**
     * Route of Breadcrumb
     * @var string|null
     */
    private $route;

    /**
     * Parameters of route
     * @var array
     */
    private $route_parameters;

    /**
     * Parameters for translation
     * @var array
     */
    private $translation_parameters;

    /**
     * BreadcrumbItem constructor
     *
     * @param string $label
     * @param string|null $route
     * @param array $routeParameters
     * @param array $translationParameters
     */
    public function __construct(
        string $label,
        string $route = null,
        array $routeParameters = [],
        array $translationParameters = []
    ) {
        $this->label = $label;
        $this->route = $route;
        $this->route_parameters = $routeParameters;
        $this->translation_parameters = $translationParameters;
    }

    /**
     * Get label of Breadcrumb
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Get route of Breadcrumb
     *
     * @return string|null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get route parameters of Breadcrumb
     *
     * @return array
     */
    public function getRouteParameters(): array
    {
        return $this->route_parameters;
    }

    /**
     * Get translation parameters of Breadcrumb
     *
     * @return array
     */
    public function getTranslationParameters(): array
    {
        return $this->translation_parameters;
    }

}
