<?php

declare(strict_types=1);

namespace Robole\SuluAITranslatorBundle\Controller\Admin;

use Robole\SuluAITranslatorBundle\Service\TranslatorInterface;
use FOS\RestBundle\View\ViewHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TranslationController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translatorService,
        private ViewHandlerInterface $viewHandler,
        private array $localeMapping
    ) {
    }

    /**
     * Returns ISO 3166-1 compatible language key from bundle configuration
     *
     * @see https://developers.deepl.com/docs/resources/supported-languages#target-languages
     */
    private function getLanguageKey(?string $language): ?string
    {
        return $this->localeMapping[$language] ?? null;
    }

        /**
     * Returns translator service usage statistics
     *
     * @return Response
     */
    public function getTranslateUsageAction()
    {
        return new JsonResponse($this->translatorService->getUsage());
    }

    /**
     * Translate text from source to target language using configured translator service.
     * Translation is done in backend for security and API key protection.
     *
     * @param Request $request
     *
     * @return Response
     */
        public function postTranslateAction(Request $request)
    {
                        $text = $request->request->get('text');

        if (!$text || empty($text)) {
            return new JsonResponse([
                "translation" => ""
            ]);
        }

        $source = $this->getLanguageKey($request->request->get('source') ?? null);
        $target = $this->getLanguageKey($request->request->get('target'));

        if (!$target) {
            return new JsonResponse([
                "translation" => $text,
                "error" => "Translation failed: Target language not set"
            ]);
        }

        try {
            $result = $this->translatorService->translateText($text, $source, $target, [
                "tag_handling" => "html"
            ]);

            if (!$result || !$result->text) {
                return new JsonResponse([
                    "error" => "Translation failed: API error (missing credentials?)"
                ], 400);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                "error" => "Translation failed: " . $e->getMessage()
            ], 500);
        }

        return new JsonResponse([
            "translation" => $result->text
        ]);
    }
}
