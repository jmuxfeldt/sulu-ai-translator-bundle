<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\Service;

interface TranslatorInterface
{
    /**
     * Translate text from source to target language
     *
     * @param string $text Text to translate
     * @param string|null $source Source language (null for auto-detection)
     * @param string $target Target language
     * @param array $options Translation options
     * @return object Translation result with text property
     */
    public function translateText(string $text, ?string $source, string $target, array $options = []): object;

    /**
     * Get usage statistics for the translation service
     *
     * @return object|null Usage information or null if not available
     */
    public function getUsage(): ?object;
}
