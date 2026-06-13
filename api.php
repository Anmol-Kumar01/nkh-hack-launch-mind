<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/lib/env.php';
require_once __DIR__ . '/lib/groq.php';
require_once __DIR__ . '/agents/research.php';
require_once __DIR__ . '/agents/content.php';
require_once __DIR__ . '/agents/dev.php';

loadEnv(__DIR__ . '/.env');

// ── CONFIG ─────────────────────────────────────────────────────────────
$GROQ_API_KEY = getenv('GROQ_API_KEY') ?: '';

$MODEL = 'llama-3.3-70b-versatile';
$API_URL = 'https://api.groq.com/openai/v1/chat/completions';

if (!$GROQ_API_KEY || $GROQ_API_KEY === 'YOUR_GROQ_API_KEY_HERE') {
    http_response_code(500);
    echo json_encode(['error' => 'Missing GROQ_API_KEY. Add it to .env or set it as an environment variable.']);
    exit;
}

// ── Parse Request ──────────────────────────────────────────────────────
$body = json_decode(file_get_contents('php://input'), true);

if (!$body || !isset($body['agent'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing agent type']);
    exit;
}

$agent = $body['agent'];
$goal  = trim($body['goal'] ?? '');

if (!$goal) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing goal']);
    exit;
}

// ── Route to Agent ─────────────────────────────────────────────────────
try {

    switch ($agent) {

        case 'research':
            $result = runResearchAgent(
                $goal,
                $GROQ_API_KEY,
                $MODEL,
                $API_URL
            );
            break;

        case 'content':
            $research = trim($body['research'] ?? '');

            $result = runContentAgent(
                $goal,
                $research,
                $GROQ_API_KEY,
                $MODEL,
                $API_URL
            );
            break;

        case 'dev':
            $research = trim($body['research'] ?? '');
            $tagline  = trim($body['tagline'] ?? '');

            $result = runDevAgent(
                $goal,
                $research,
                $tagline,
                $GROQ_API_KEY,
                $MODEL,
                $API_URL
            );
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'error' => 'Unknown agent: ' . $agent
            ]);
            exit;
    }

    echo json_encode([
        'output' => $result
    ]);

} catch (Exception $e) {

    http_response_code(500);

    echo json_encode([
        'error' => $e->getMessage()
    ]);
}
