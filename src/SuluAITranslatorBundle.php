<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle;

use Robole\SuluAITranslatorBundle\DependencyInjection\Compiler\TranslatorServicePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuluAITranslatorBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TranslatorServicePass());
    }
}
