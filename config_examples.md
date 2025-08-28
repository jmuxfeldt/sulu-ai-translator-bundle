# Configuration Examples

## Using DeepL (Default - No Changes Required)

```yaml
# config/packages/sulu_ai_translator.yaml
sulu_ai_translator:
    deepl_api_key: "%env(DEEPL_API_KEY)%"
    translator_type: deepl  # Optional, this is the default
    locale_mapping:
        en: "en-GB"
        de: "de"
        fr: "fr"
```

Environment variable:
```bash
DEEPL_API_KEY="your-deepl-api-key"
```

## Using OpenAI GPT-4

```yaml
# config/packages/sulu_ai_translator.yaml
sulu_ai_translator:
    openai_api_key: "%env(OPENAI_API_KEY)%"
    openai_model: "gpt-4-turbo"  # Optional, defaults to gpt-4-turbo
    openai_context: "Do not translate brand names like 'MyBrand' or 'CompanyName'. Preserve all markdown formatting."  # Optional
    translator_type: openai
    locale_mapping:
        en: "English"
        de: "German"
        fr: "French"
```

Environment variable:
```bash
OPENAI_API_KEY="your-openai-api-key"
```

### OpenAI Context Examples

The `openai_context` field allows you to provide additional instructions to GPT-4:

```yaml
# Example 1: Preserve brand names
openai_context: "Do not translate brand names like 'MyCompany', 'ProductName', or 'ServiceBrand'"

# Example 2: Maintain formatting
openai_context: "Preserve all HTML tags, markdown formatting, and code blocks exactly as they appear"

# Example 3: Tone and style
openai_context: "Use formal language and maintain a professional tone throughout the translation"

# Example 4: Domain-specific terms
openai_context: "This is technical documentation. Keep technical terms like 'API', 'database', 'frontend' untranslated"

# Example 5: Combined instructions
openai_context: "Do not translate 'MyBrand' or 'SpecialProduct'. Preserve all HTML and maintain formal tone"
```

## Override in Main Symfony Configuration

You can also override the translator service directly in your main `config/services.yaml`:

```yaml
# config/services.yaml
services:
    # Use OpenAI instead of configured default
    ai_translator.translator_service: '@ai_translator.openai_service'
    
    # Or use DeepL specifically
    ai_translator.translator_service: '@ai_translator.deepl_service'
```

## Language Mapping

### DeepL Language Codes
DeepL uses specific ISO language codes:
- `en-GB`, `en-US` for English variants
- `de` for German
- `fr` for French
- See: https://developers.deepl.com/docs/resources/supported-languages

### OpenAI Language Names
OpenAI works with natural language names:
- `English` for English
- `German` for German  
- `French` for French
- Any language name that GPT-4 understands

## Installation

1. Install dependencies:
```bash
composer install
```

2. Set your API key in `.env`:
```bash
# For DeepL
DEEPL_API_KEY="your-key"

# For OpenAI  
OPENAI_API_KEY="your-key"
```

3. Configure the bundle as shown above.

## Switching Between Services

You can switch between DeepL and OpenAI by:
1. Changing `translator_type` in configuration
2. Overriding the service in `services.yaml`
3. No code changes required - the interface handles abstraction
