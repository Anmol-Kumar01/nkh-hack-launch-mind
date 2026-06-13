<?php

function sanitizeLandingPage(string $raw): string {
    $html = trim($raw);

    $html = preg_replace('/^```html\s*/i', '', $html);
    $html = preg_replace('/^```\s*/i', '', $html);
    $html = preg_replace('/```\s*$/i', '', $html);
    $html = trim($html);

    if (!preg_match('/<!DOCTYPE/i', $html)) {
        $html = "<!DOCTYPE html>\n" . $html;
    }

    if (!preg_match('/<html/i', $html)) {
        $html = "<!DOCTYPE html>\n<html lang=\"en\">\n" . $html . "\n</html>";
    }

    $tailwindCdn = '<script src="https://cdn.tailwindcss.com"></script>';
    $fontsLink   = '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">';
    $baseStyles  = <<<'CSS'
<style>
  body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
  .gradient-text { background: linear-gradient(135deg, #22d3ee, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
  .hero-glow { background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.15) 0%, transparent 60%); }
  .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1); }
  .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
  .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
</style>
CSS;

    if (preg_match('/<head[^>]*>/i', $html)) {
        if (!preg_match('/cdn\.tailwindcss\.com/i', $html)) {
            $html = preg_replace('/(<head[^>]*>)/i', '$1' . "\n  " . $tailwindCdn, $html, 1);
        }
        if (!preg_match('/fonts\.googleapis\.com/i', $html)) {
            $html = preg_replace('/(<head[^>]*>)/i', '$1' . "\n  " . $fontsLink, $html, 1);
        }
        if (!preg_match('/<style/i', $html)) {
            $html = preg_replace('/(<\/head>)/i', "  " . $baseStyles . "\n$1", $html, 1);
        }
    } else {
        $head = "<head>\n  <meta charset=\"UTF-8\">\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n  {$tailwindCdn}\n  {$fontsLink}\n  {$baseStyles}\n</head>";
        $html = preg_replace('/(<html[^>]*>)/i', '$1' . "\n" . $head, $html, 1);
    }

    if (!preg_match('/<\/html>/i', $html)) {
        $html .= "\n</html>";
    }

    return $html;
}
