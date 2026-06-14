<?php

require_once __DIR__ . '/../lib/landing.php';

function runDevAgent(
    string $goal,
    string $research,
    string $tagline,
    string $key,
    string $model,
    string $url
): string {

    $system = <<<PROMPT
You are an elite front-end developer and UI designer. Build a stunning, premium single-file landing page that looks like a funded startup's marketing site.

MANDATORY <head>: use this structure (replace BUSINESS_NAME and pick colors that fit the industry):

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BUSINESS_NAME</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: { extend: { colors: { brand: { 400: '#22d3ee', 500: '#06b6d4', 600: '#0891b2' } } } }
    }
  </script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-text { background: linear-gradient(135deg, #22d3ee, #818cf8, #c084fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .hero-glow { background: radial-gradient(ellipse at 50% 0%, rgba(34,211,238,0.15) 0%, transparent 60%); }
    .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1); }
    .card-hover { transition: transform 0.2s, box-shadow 0.2s; }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
  </style>
</head>

YOU MUST INCLUDE ALL 12 SECTIONS BELOW IN ORDER: each fully styled with Tailwind classes:

1. **Sticky Navbar**: logo/brand name, 4 nav links (Features, How It Works, Pricing, FAQ), CTA button. Dark bg with blur: `bg-gray-950/80 backdrop-blur-lg border-b border-white/10`. Navbar links MUST use in-page anchors only: `href="#features"`, `href="#how-it-works"`, `href="#pricing"`, `href="#faq"`. NEVER use `href="#"`, `href="/"`, or relative file paths.

NAVIGATION RULES (CRITICAL):
- Every major `<section>` MUST have a matching `id`: `hero`, `features`, `how-it-works`, `pricing`, `faq`, etc.
- All navbar, footer, and CTA links that scroll within the page MUST use `href="#section-id"` matching those ids exactly.
- NEVER use `href="#"`, `href="/"`, `href="index.html"`, or any relative URL for in-page navigation.
- External links (social, email) may use full `https://` or `mailto:` URLs only.

2. **Hero Section**: full viewport feel, gradient background (.hero-glow), large headline with .gradient-text, subheadline, 2 CTA buttons (primary filled + secondary outline), hero image placeholder or SVG illustration using colored divs/shapes, 3 stat badges below (e.g. "10K+ Users", "98% Satisfaction", "$2M Raised")

3. **Social Proof Bar**: "Trusted by" label + 5 company name pills/logos as styled text badges

4. **Problem Section**: "The Challenge" heading, 3 pain-point cards with icons (use emoji or Unicode symbols), dark cards with border

5. **Solution / Value Prop**: split layout: left side headline + paragraph, right side feature checklist with checkmark icons

6. **Features Grid**: "Why Choose Us" heading, 6 feature cards in 3x2 grid, each with icon circle, title, description. Use .glass and .card-hover classes

7. **How It Works**: 3 numbered steps with connecting line, icons, titles, descriptions

8. **Pricing Section**: 3 pricing tiers (Free/Pro/Enterprise) as cards, middle card highlighted/scaled, feature lists, CTA buttons per tier. Use research monetization for pricing

9. **Testimonials**: 3 testimonial cards with avatar initials circles, quote, name, role. Star ratings (★★★★★)

10. **FAQ Section**: 5 questions with answers in styled accordion-like divs (no JS needed, just show Q&A pairs)

11. **Final CTA Banner**: full-width gradient banner, bold headline, email input + subscribe/button

12. **Footer**: 4 columns (Brand blurb, Product links, Company links, Social icons as text links), copyright line

DESIGN RULES:
- Dark theme: bg-gray-950 body, text-gray-100, accent cyan/indigo/purple gradients
- Generous spacing: py-20 or py-24 per section, max-w-6xl mx-auto px-6
- Every element MUST have Tailwind classes: no unstyled bare HTML
- Headlines specific to the business goal: never "Your Company" or "Lorem ipsum"
- Pull feature names, pricing, and value props from the research report and tagline
- Use real-sounding metrics and copy tailored to the industry
- Mobile responsive: grid-cols-1 md:grid-cols-2 lg:grid-cols-3 patterns
- Return ONLY raw HTML from <!DOCTYPE html> to </html>
- No markdown fences. No explanations. No comments.
PROMPT;

    $userMsg = <<<MSG
Business Goal:
$goal

Market Research:
$research

Marketing Tagline:
$tagline

Build the complete premium landing page with ALL 12 sections. Make it visually stunning.
MSG;

    $raw = callGroq(
        $system,
        $userMsg,
        $key,
        $model,
        $url,
        5000
    );

    return sanitizeLandingPage($raw);
}
