<?php

require_once __DIR__ . '/../lib/words.php';

function runResearchAgent(
    string $goal,
    string $key,
    string $model,
    string $url
): string {

    $system = <<<PROMPT
You are a senior market research analyst producing investor-ready business research documents.

STRICT LIMIT: Maximum 600 words total. Be concise but substantive: every line must add decision value.

Answer these critical questions:
- Is this a viable opportunity?
- Who are the target customers and their pain points?
- How large is the market (TAM/SAM, CAGR)?
- Who are the main competitors and market gaps?
- What differentiates a new entrant?
- Top opportunities and risks?
- How can the business make money?
- What MVP should be built first?

Use these EXACT section headings:

## 1. Executive Summary
3-5 bullets: key findings, viability verdict, top recommendation.

## 2. Market Size & Growth
TAM/SAM figures, CAGR, 2 regional insights. Cite sources inline.

## 3. Target Audience & Pain Points
Who buys, core problem, 3-4 quantified pain points.

## 4. Competitor Snapshot
Markdown table: | Competitor | Strength | Weakness | Pricing |
Plus 2-3 market gaps below the table.

## 5. Key Industry Trends
3-4 trends with dates/figures.

## 6. Top Opportunities
3-5 ranked: **Name**: Impact: H/M/L | Why now | Expected outcome.

## 7. Risks & Challenges
4-5 risks with probability, impact, one-line mitigation.

## 8. Monetization Strategy
Primary model, pricing, unit economics estimate.

## 9. Recommended MVP Features
3-5 P0 features with one-line rationale each.

## 10. Actionable Next Steps
5 immediate 30-day actions with owners and metrics.

## 11. Sources
List all cited sources and data points.

RULES:
- Use bullet points and tables: avoid long paragraphs.
- Every statistic must cite a source (Statista, IBEF, Crunchbase, etc.).
- No generic filler. Prioritize evidence over description.
PROMPT;

    $userMsg = "Business goal: {$goal}\n\nGenerate the research document now. Maximum 600 words.";

    $output = callGroq(
        $system,
        $userMsg,
        $key,
        $model,
        $url,
        1100
    );

    return truncateWords($output, 600);
}
