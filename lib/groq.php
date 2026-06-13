<?php

function callGroq(
    string $system,
    string $userMsg,
    string $key,
    string $model,
    string $url,
    int $maxTokens = 1500
): string {

    $payload = json_encode([
        'model' => $model,
        'messages' => [
            [
                'role' => 'system',
                'content' => $system
            ],
            [
                'role' => 'user',
                'content' => $userMsg
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => $maxTokens
    ]);

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $key
        ],
        CURLOPT_TIMEOUT => 90
    ]);

    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);

    curl_close($ch);

    if ($curlErr) {
        throw new Exception('cURL error: ' . $curlErr);
    }

    $data = json_decode($response, true);

    if ($httpCode !== 200) {

        $errMsg = $data['error']['message']
            ?? $response
            ?? 'Unknown error';

        throw new Exception(
            "Groq API error ($httpCode): $errMsg"
        );
    }

    return $data['choices'][0]['message']['content'] ?? '';
}
