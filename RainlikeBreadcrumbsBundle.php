<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Rainlike\BreadcrumbsBundle\DependencyInjection\RainlikeBreadcrumbsExtension;

/**
 * Class RainlikeBreadcrumbsBundle
 * @package Rainlike\BreadcrumbsBundle
 */
class RainlikeBreadcrumbsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new RainlikeBreadcrumbsExtension();
    }
}
