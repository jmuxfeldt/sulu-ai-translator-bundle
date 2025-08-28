<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TranslatorServicePass implements CompilerPassInterface
{
            public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('sulu_ai_translator.translator_type')) {
            return;
        }

        $translatorType = $container->getParameter('sulu_ai_translator.translator_type');
        $serviceId = 'ai_translator.' . $translatorType . '_service';

        if (!$container->hasDefinition($serviceId)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid translator type "%s". Available types: deepl, openai',
                $translatorType
            ));
        }

        // Update the alias to point to the correct service
        $container->setAlias('ai_translator.translator_service', $serviceId)
            ->setPublic(true);
    }
}
