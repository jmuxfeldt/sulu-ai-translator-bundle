<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sulu_ai_translator');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('translator_type')
                    ->defaultValue('deepl')
                    ->info('Translator service to use: deepl or openai')
                    ->end()
                ->scalarNode('deepl_api_key')
                    ->defaultNull()
                    ->end()
                ->scalarNode('openai_api_key')
                    ->defaultNull()
                    ->end()
                ->scalarNode('openai_model')
                    ->defaultValue('gpt-4-turbo')
                    ->info('OpenAI model to use for translations')
                    ->end()
                ->scalarNode('openai_context')
                    ->defaultNull()
                    ->info('Additional context or instructions for OpenAI translations (e.g., "Do not translate brand names", "Preserve all HTML tags")')
                    ->end()
                ->arrayNode('locale_mapping')
                    ->useAttributeAsKey('name')
                    ->scalarPrototype()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
