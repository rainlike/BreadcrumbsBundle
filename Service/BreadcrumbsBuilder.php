<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Rainlike\BreadcrumbsBundle\Model\BreadcrumbItem;

/**
 * Class BreadcrumbsBuilder
 * @package Rainlike\BreadcrumbsBundle\Service
 */
class BreadcrumbsBuilder
{
    /**
     * Builder configurations:
     * @var $enable_translation bool
     */
    private $enable_translation = true;

    /**
     * @var string
     */
    private $translation_domain;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $separator;

    /**
     * Storage of BreadcrumbItems
     * @var array
     */
    private $items = [];

    /**
     * Enable translation
     *
     * @param bool $enableTranslation
     * @return BreadcrumbsBuilder
     */
    public function enableTranslation(bool $enableTranslation = true): BreadcrumbsBuilder
    {
        $this->enable_translation = $enableTranslation;

        return $this;
    }

    /**
     * Set translation domain
     *
     * @param string $translationDomain
     * @return BreadcrumbsBuilder
     */
    public function setTranslationDomain(string $translationDomain): BreadcrumbsBuilder
    {
        $this->translation_domain = $translationDomain;

        return $this;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return BreadcrumbsBuilder
     */
    public function setTemplate(string $template): BreadcrumbsBuilder
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set separator
     *
     * @param string $separator
     * @return BreadcrumbsBuilder
     */
    public function setSeparator(string $separator): BreadcrumbsBuilder
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Add new item of BreadcrumbsBuilder
     *
     * @param string $label
     * @param string|null $route
     * @param array $routeParameters
     * @param array $translationParameters
     * @return BreadcrumbsBuilder
     */
    public function addItem(
        string $label,
        string $route = null,
        array $routeParameters = [],
        array $translationParameters = []
    ): BreadcrumbsBuilder {
        $this->items[] = new BreadcrumbItem(
            $label,
            $route,
            $routeParameters,
            $translationParameters
        );

        return $this;
    }

    /**
     * Get Breadcrumbs items
     *
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

}