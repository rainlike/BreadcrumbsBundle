<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

use Rainlike\BreadcrumbsBundle\Model\BreadcrumbItem;

/**
 * Class Breadcrumbs
 * @package Rainlike\BreadcrumbsBundle\Service
 */
class Breadcrumbs
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
     * Default domain
     * @var string
     */
    const DEFAULT_DOMAIN = 'messages';

    /**
     * Default separator of breadcrumbs
     * @var string
     */
    const DEFAULT_SEPARATOR = ' / ';

    /**
     * Translation domain
     * @var string
     */
    private $translation_domain;

    /**
     * Storage of BreadcrumbItems
     * @var array
     */
    private $items = [];

    /**
     * Modifications
     * @var bool $translation_mod: enable translations
     */
    private $translation_mod = true;

    /**
     * Breadcrumbs constructor
     *
     * @param Router $router
     * @param Translator $translator
     */
    public function __construct(Router $router, Translator $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * Set translation domain
     *
     * @param string $translationDomain
     * @return Breadcrumbs
     */
    public function setTranslationDomain(string $translationDomain): Breadcrumbs
    {
        $this->translation_domain = $translationDomain;

        return $this;
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

        return self::DEFAULT_DOMAIN;
    }

    /**
     * Set translation mod
     *
     * @param bool $translationMod
     * @return Breadcrumbs
     */
    public function setTranslationMod(bool $translationMod = true): Breadcrumbs
    {
        $this->translation_mod = $translationMod;

        return $this;
    }

    /**
     * Get translation mod
     * @return bool
     */
    public function getTranslationMod(): bool
    {
        return $this->translation_mod;
    }

    /**
     * Add new item of Breadcrumbs
     *
     * @param string $label
     * @param string|null $route
     * @param array $routeParameters
     * @param array $translationParameters
     * @return Breadcrumbs
     */
    public function addItem(
        string $label,
        string $route = null,
        array $routeParameters = [],
        array $translationParameters = []
    ): Breadcrumbs {
        $translatedLabel = $this->translateItem($label, $translationParameters);

        $this->items[] = new BreadcrumbItem($translatedLabel, $route, $routeParameters);

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
        if (array_key_exists('domain', $parameters)) {
            $domain = $parameters['domain'];
            unset($parameters['domain']);
        }

        return $this->translation_mod
            ? $this->translator->trans($label, $parameters, $this->getTranslationDomain($domain))
            : $label;
    }

}
