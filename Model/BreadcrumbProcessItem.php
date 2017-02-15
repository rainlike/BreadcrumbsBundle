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
     * URL of Breadcrumb
     * @var string|null
     */
    private $url;

    /**
     * BreadcrumbProcessItem constructor
     *
     * @param string $label
     * @param string|null $url
     */
    public function __construct(string $label, string $url = null)
    {
        $this->label = $label;
        $this->url = $url;
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
     * Get URL of Breadcrumb
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

}
