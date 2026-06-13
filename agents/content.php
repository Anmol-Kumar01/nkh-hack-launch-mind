<?php

require_once __DIR__ . '/../lib/words.php';

const CONTENT_WORD_LIMITS = [
    'blog'       => 500,
    'newsletter' => 350,
    'linkedin'   => 250,
    'twitter'    => 200,
    'copy'       => 80,
];

function runContentAgent(
    string $goal,
    string $research,
    string $key,
    string $model,
    string $url
): array {

    $system = <<<PROMPT
You are a world-class content strategist and copywriter.

Using the business goal and market research, generate a complete, publication-ready content suite.
Write FULL, SUBSTANTIAL content: not summaries or outlines. Each piece must be ready to publish as-is.

Return ONLY a valid JSON object: no markdown fences, no extra text.

CRITICAL JSON RULES:
- All string values must use escaped newlines (\\n): never raw line breaks inside strings.
- Escape all double quotes inside strings as \\".
- Include ALL five keys exactly as shown.

Required structure and MINIMUM lengths:

{
  "blog": "Full 400-500 word blog article. Include: compelling headline, intro paragraph, 3 named sections with 2-3 paragraphs each, key statistics from research, and a conclusion with CTA. Must feel like a real published article.",
  "newsletter": "Complete newsletter edition (~300-350 words). Include: catchy subject line, personal intro, 3 content blocks with headers, bullet points where useful, and a strong closing CTA. Use \\n between sections.",
  "linkedin": "Full 200-250 word LinkedIn post. Include: attention-grabbing hook (first line), 2-3 insight paragraphs with data points, a personal angle, and a clear CTA. Use \\n for paragraph breaks.",
  "twitter": "5-tweet thread (~150-200 words total). Number each tweet 1/5 through 5/5. Hook in tweet 1, insights in 2-4, CTA in 5. Separate tweets with \\n.",
  "copy": "Punchy tagline (under 15 words) + 2-sentence value proposition + 3 bullet benefits. Max 80 words."
}

QUALITY RULES:
- Use specific details, stats, and insights from the research report.
- Match the brand voice to the target audience in the research.
- Blog and newsletter must be the longest, most detailed pieces.
- Never write placeholder text like 'insert here' or 'Lorem ipsum'.
PROMPT;

    $userMsg = <<<MSG
Business Goal:
$goal

Market Research:
$research

Generate all five content pieces now. Blog ~500 words, newsletter ~350 words, LinkedIn ~250 words. Return ONLY valid JSON.
MSG;

    $raw = callGroq(
        $system,
        $userMsg,
        $key,
        $model,
        $url,
        3200
    );

    return enforceContentWordLimits(normalizeContentOutput($raw));
}

function enforceContentWordLimits(array $content): array {
    foreach ($content as $key => $value) {
        if (is_string($value)) {
            $limit = CONTENT_WORD_LIMITS[$key] ?? 300;
            $content[$key] = truncateWords($value, $limit);
        }
    }
    return $content;
}

function normalizeContentOutput(string $raw): array {
    $defaults = [
        'blog'       => '',
        'newsletter' => '',
        'linkedin'   => '',
        'twitter'    => '',
        'copy'       => ''
    ];

    $clean = trim($raw);
    $clean = preg_replace('/^```json\s*/i', '', $clean);
    $clean = preg_replace('/^```\s*/i', '', $clean);
    $clean = preg_replace('/```\s*$/i', '', $clean);
    $clean = trim($clean);

    $parsed = json_decode($clean, true);

    if (is_array($parsed)) {
        return mergeContentFields($defaults, $parsed);
    }

    $extracted = [];
    foreach (array_keys($defaults) as $key) {
        $extracted[$key] = extractJsonField($clean, $key);
    }

    if (implode('', $extracted) !== '') {
        return mergeContentFields($defaults, $extracted);
    }

    return [
        'blog'       => truncateWords($clean, CONTENT_WORD_LIMITS['blog']),
        'newsletter' => 'Content generation encountered a parsing issue. Please retry.',
        'linkedin'   => '',
        'twitter'    => '',
        'copy'       => ''
    ];
}

function mergeContentFields(array $defaults, array $parsed): array {
    $keyMap = [
        'blog'       => ['blog', 'Blog', 'article'],
        'newsletter' => ['newsletter', 'Newsletter', 'email'],
        'linkedin'   => ['linkedin', 'linkedIn', 'LinkedIn', 'linkedin_post'],
        'twitter'    => ['twitter', 'Twitter', 'x', 'thread'],
        'copy'       => ['copy', 'Copy', 'tagline', 'Tagline']
    ];

    $result = $defaults;

    foreach ($keyMap as $canonical => $aliases) {
        foreach ($aliases as $alias) {
            if (!empty($parsed[$alias]) && is_string($parsed[$alias])) {
                $result[$canonical] = $parsed[$alias];
                break;
            }
        }
    }

    return $result;
}

function extractJsonField(string $json, string $field): string {
    $pattern = '/"' . preg_quote($field, '/') . '"\s*:\s*"((?:[^"\\\\]|\\\\.)*)"/s';
    if (preg_match($pattern, $json, $matches)) {
        return stripcslashes($matches[1]);
    }
    return '';
}
