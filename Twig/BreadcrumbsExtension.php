<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Twig;

use Rainlike\BreadcrumbsBundle\Service\Breadcrumbs;

/**
 * Class BreadcrumbsExtension
 * @package Rainlike\BreadcrumbsBundle\Twig
 */
class BreadcrumbsExtension extends \Twig_Extension
{
    /**
     * @var Breadcrumbs
     */
    private $breadcrumbs;

    /**
     * @param string $breadcrumbs
     */
    public function __construct($breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Functions for Twig
     * -required function
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'rainlike_breadcrumbs',
                [ $this, 'renderBreadcrumbs' ],
                [
                    'is_safe' => [ 'html' ],
                    'needs_environment' => true,
                    'needs_context' => true
                ]
            )
        ];
    }

    /**
     * Render breadcrumbs
     *
     * @param array $context
     * @return void
     */
    public function renderBreadcrumbs(array $context)
    {
        return;
    }

    /**
     * Get extension name
     * -required function
     *
     * @return string
     */
    public function getName(): string
    {
        return 'rainlike.breadcrumbs.extension';
    }

}
