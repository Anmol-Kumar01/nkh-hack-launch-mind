<?php

function truncateWords(string $text, int $max = 150): string {
    $text = trim($text);
    if ($text === '') {
        return '';
    }

    $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);
    if (count($words) <= $max) {
        return $text;
    }

    return implode(' ', array_slice($words, 0, $max)) . '…';
}
