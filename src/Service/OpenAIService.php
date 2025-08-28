<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\Service;

use OpenAI;

class OpenAIService implements TranslatorInterface
{
    private OpenAI\Client $client;

    public function __construct(
        private readonly string $openaiApiKey,
        private readonly string $model = 'gpt-4-turbo',
        private readonly string $context = ''
    ) {
        $this->client = OpenAI::client($this->openaiApiKey);
    }

    public function translateText(string $text, ?string $source, string $target, array $options = []): object
    {
        $sourceText = $source ? "from {$source} " : '';
        $basePrompt = "Translate the following text {$sourceText}to {$target}. Preserve all HTML tags and formatting exactly as they appear.";

        // Add custom context/instructions if provided
        if (!empty($this->context)) {
            $basePrompt .= " " . $this->context . ".";
        }

        $prompt = "{$basePrompt} Only return the translated text without any additional explanations:\n\n{$text}";

        $response = $this->client->chat()->create([
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.3,
        ]);

        $translatedText = $response->choices[0]->message->content ?? '';

        return (object) [
            'text' => $translatedText
        ];
    }

    public function getUsage(): ?object
    {
        // OpenAI doesn't provide usage statistics via API like DeepL
        // This could be extended to track usage locally or return placeholder data
        return (object) [
            'model' => $this->model,
            'provider' => 'OpenAI',
            'note' => 'Usage statistics not available via OpenAI API'
        ];
    }
}
