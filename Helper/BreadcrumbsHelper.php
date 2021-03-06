<?php
declare(strict_types = 1);

namespace Rainlike\BreadcrumbsBundle\Helper;

use Symfony\Component\HttpKernel\KernelInterface as Kernel;
use Symfony\Component\Translation\TranslatorInterface as Translator;

use Rainlike\BreadcrumbsBundle\Model\BreadcrumbItem as Item;
use Rainlike\BreadcrumbsBundle\Service\BreadcrumbsProcessor as Processor;

/**
 * Class BreadcrumbsHelper
 *
 * @package Rainlike\BreadcrumbsBundle\Helper
 */
class BreadcrumbsHelper
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * Builder configs
     * @var array
     */
    private $builder_configs;

    /**
     * Process configs
     * @var array
     */
    private $process_configs;

    /**
     * BreadcrumbsHelper constructor
     *
     * @param Kernel $kernel
     * @param Translator $translator
     */
    public function __construct(
        Kernel $kernel,
        Translator $translator
    ) {
        $this->kernel = $kernel;
        $this->translator = $translator;
    }

    /**
     * Set Builder configs
     *
     * @param array $configs
     * @return self
     */
    public function setBuilderConfigs(array $configs): self
    {
        $this->builder_configs = $configs;

        return $this;
    }

    /**
     * Set Process configs
     *
     * @param array $configs
     * @return self
     */
    public function setProcessConfigs(array $configs): self
    {
        $this->process_configs = $configs;

        return $this;
    }

    /**
     * Get Breadcrumb config by name
     *
     * @param string $name
     * @param Item|null $item
     * @return mixed|string|bool
     */
    public function getConfig(string $name, Item $item = null)
    {
        $kernelConfigName = 'rainlike_breadcrumbs.'.$name;
        $constantName = 'DEFAULT_'.strtoupper($name);

        if ($item && isset($item->getTranslationParameters()[$name])) {
            return $item->getTranslationParameters()[$name];
        } elseif (isset($this->process_configs[$name])) {
            return $this->process_configs[$name];
        } elseif (isset($this->builder_configs[$name])) {
            return $this->builder_configs[$name];
        } elseif ($this->kernel->getContainer()->hasParameter($kernelConfigName)) {
            return $this->kernel->getContainer()->getParameter($kernelConfigName);
        } else {
            return Processor::getConstant($constantName);
        }
    }

    /**
     * Translate Breadcrumb item
     *
     * @param Item $item
     * @return string
     */
    public function translateItem(Item $item): string
    {
        if (!$this->getConfig('enable_translation', $item)) {
            return $item->getLabel();
        }

        $domain = $this->getConfig('translation_domain', $item);
        $parameters = $this->prepareTranslationParameters($item->getTranslationParameters());

        return $this->translator->trans($item->getLabel(), $parameters, $domain);
    }

    /**
     * Prepare parameters for translate
     *
     * @param array $translationParameters
     * @return array
     */
    private function prepareTranslationParameters(array $translationParameters): array
    {
        foreach (Processor::$possible_translation_parameters as $parameter) {
            if (isset($translationParameters[$parameter])) {
                unset($translationParameters[$parameter]);
            }
        }

        return $translationParameters;
    }
}
