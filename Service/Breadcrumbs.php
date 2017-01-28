<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Service;

/**
 * Class Breadcrumbs
 * @package Rainlike\BreadcrumbsBundle\Service
 */
class Breadcrumbs
{
    /**
     * Add item to Breadcrumbs
     *
     * @param string $text
     * @param mixed|null $url
     * @param array $translationParameters
     * @return Breadcrumbs
     */
    public function addItem(string $text, $url = null, array $translationParameters = []): Breadcrumbs
    {
        $translatedText = $this->translateItem($text, $translationParameters);

        $breadcrumbItem = [
            'item' => $translatedText,
            'link' => $url
        ];

        $this->breadcrumbs[] = $breadcrumbItem;

        return $this;
    }

}
