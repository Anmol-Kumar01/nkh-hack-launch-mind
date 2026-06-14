<?php

function landingSlug(string $text): string {
    $text = strtolower(trim(strip_tags($text)));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-') ?: 'section';
}

function ensureLandingSectionIds(string $html): string {
    $defaults = [
        'hero', 'social-proof', 'problem', 'solution', 'features',
        'how-it-works', 'pricing', 'testimonials', 'faq', 'cta', 'footer',
    ];
    $index = 0;

    return preg_replace_callback(
        '/<section([^>]*)>(.*?)<\/section>/is',
        function (array $m) use (&$index, $defaults): string {
            $attrs = $m[1];
            $inner = $m[2];

            if (preg_match('/\bid=["\']([^"\']+)["\']/i', $attrs)) {
                return $m[0];
            }

            $id = null;
            if (preg_match('/<h[12][^>]*id=["\']([^"\']+)["\']/i', $inner, $hm)) {
                $id = $hm[1];
            } elseif (preg_match('/<h[12][^>]*>(.*?)<\/h[12]>/is', $inner, $hm)) {
                $id = landingSlug($hm[1]);
            } else {
                $id = $defaults[$index] ?? 'section-' . $index;
            }

            if ($index === 0 && $id !== 'hero') {
                $id = 'hero';
            }

            $index++;
            return '<section' . $attrs . ' id="' . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . '">' . $inner . '</section>';
        },
        $html
    );
}

function fixLandingNavAnchors(string $html): string {
    $linkMap = [
        'home'          => 'hero',
        'features'      => 'features',
        'how it works'  => 'how-it-works',
        'how-it-works'  => 'how-it-works',
        'pricing'       => 'pricing',
        'plans'         => 'pricing',
        'faq'           => 'faq',
        'faqs'          => 'faq',
        'testimonials'  => 'testimonials',
        'about'         => 'problem',
        'contact'       => 'cta',
        'get started'   => 'cta',
        'subscribe'     => 'cta',
    ];

    return preg_replace_callback(
        '/<a(\s[^>]*?)href=(["\'])([^"\']*)\2([^>]*)>(.*?)<\/a>/is',
        function (array $m) use ($linkMap): string {
            $before = $m[1];
            $quote  = $m[2];
            $href   = trim($m[3]);
            $after  = $m[4];
            $text   = strtolower(trim(strip_tags($m[5])));

            if (preg_match('/^(https?:|mailto:|tel:)/i', $href)) {
                return $m[0];
            }

            if ($href !== '' && $href !== '#' && $href[0] === '#') {
                return $m[0];
            }

            foreach ($linkMap as $needle => $id) {
                if (str_contains($text, $needle)) {
                    return '<a' . $before . 'href=' . $quote . '#' . $id . $quote . $after . '>' . $m[5] . '</a>';
                }
            }

            if ($href === '' || $href === '#' || !preg_match('/^(https?:|mailto:|tel:)/i', $href)) {
                return '<a' . $before . 'href=' . $quote . '#hero' . $quote . $after . '>' . $m[5] . '</a>';
            }

            return $m[0];
        },
        $html
    );
}

function injectLandingNavigation(string $html): string {
    $baseTag = '<base target="_self">';
    $navStyles = <<<'CSS'
<style id="launchmind-nav-fix">
  html { scroll-behavior: smooth; }
  [id] { scroll-margin-top: 5rem; }
</style>
CSS;

    $navScript = <<<'JS'
<script id="launchmind-nav-fix">
(function () {
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a');
    if (!link) return;

    var href = (link.getAttribute('href') || '').trim();
    if (!href || href === '#') {
      e.preventDefault();
      return;
    }

    if (href.charAt(0) === '#') {
      e.preventDefault();
      var id = href.slice(1);
      if (!id) return;

      var target = document.getElementById(id);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (history.replaceState) {
          history.replaceState(null, '', '#' + id);
        }
      }
      return;
    }

    if (!/^(https?:|mailto:|tel:)/i.test(href)) {
      e.preventDefault();
    }
  }, true);
})();
</script>
JS;

    if (preg_match('/<head[^>]*>/i', $html) && !preg_match('/<base\b/i', $html)) {
        $html = preg_replace('/(<head[^>]*>)/i', '$1' . "\n  " . $baseTag, $html, 1);
    }

    if (!preg_match('/id=["\']launchmind-nav-fix["\']/i', $html)) {
        if (preg_match('/<\/body>/i', $html)) {
            $html = preg_replace('/<\/body>/i', $navStyles . "\n" . $navScript . "\n</body>", $html, 1);
        } else {
            $html .= "\n" . $navStyles . "\n" . $navScript;
        }
    }

    return $html;
}

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

    $html = ensureLandingSectionIds($html);
    $html = fixLandingNavAnchors($html);
    $html = injectLandingNavigation($html);

    return $html;
}
