<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Model;

/**
 * Class BreadcrumbProcessItem
 * @package Rainlike\BreadcrumbsBundle\Model
 */
class BreadcrumbProcessItem
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
     * BreadcrumbProcessItem constructor
     *
     * @param string $label
     * @param string|null $route
     */
    public function __construct(string $label, string $route = null)
    {
        $this->label = $label;
        $this->route = $route;
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
    public function getRoute(): string
    {
        return $this->route;
    }

}
