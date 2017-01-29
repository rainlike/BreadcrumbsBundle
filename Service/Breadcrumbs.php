<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

use Rainlike\BreadcrumbsBundle\Model\BreadcrumbItem;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\Translator;

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
     * Storage of BreadcrumbItems
     * @var array
     */
    private $items = [];

    /**
     * Modifications
     * @var bool $translation_mod: enable translation
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
     * Set translation mod
     *
     * @param bool $translation_mod
     * @return $this
     */
    public function setTranslationMod(bool $translation_mod)
    {
        $this->translation_mod = $translation_mod;

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
     * Add new Breadcrumbs item
     *
     * @param string $label
     * @param string|null $route
     * @param array $routeParameters
     * @param array $translationParameters
     * @return Breadcrumbs
     */
    public function addItem(
        string $label,
        ?string $route = null,
        array $routeParameters = [],
        array $translationParameters = []
    ): Breadcrumbs {
        $translatedLabel = $this->translateItem($label, $translationParameters);

        $this->items[] = new BreadcrumbItem($translatedLabel, $route, $routeParameters);

        return $this;
    }

    /**
     * Translate Breadcrumb item
     *
     * @param string $label
     * @param array $parameters
     * @return string
     */
    private function translateItem(string $label, array $parameters = []): string
    {
        return $this->translation_mod
            ? $this->translator->trans($label, $parameters)
            : $label;
    }

}
