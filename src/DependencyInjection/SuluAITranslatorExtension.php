<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages bundle configuration.
 */
class SuluAITranslatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('sulu_ai_translator.translator_type', $config['translator_type'] ?? 'deepl');
        $container->setParameter('sulu_ai_translator.deepl_api_key', $config['deepl_api_key'] ?? '');
        $container->setParameter('sulu_ai_translator.openai_api_key', $config['openai_api_key'] ?? '');
        $container->setParameter('sulu_ai_translator.openai_model', $config['openai_model'] ?? 'gpt-4-turbo');
        $container->setParameter('sulu_ai_translator.openai_context', $config['openai_context'] ?? '');
        $container->setParameter('sulu_ai_translator.locale_mapping', $config['locale_mapping'] ?? []);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('controller.xml');
    }
}
