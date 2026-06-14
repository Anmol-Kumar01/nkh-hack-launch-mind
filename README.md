# Launch Mind

**Multi-Agent Business Orchestrator** · Track 2 Promptathon

Turn a business goal into a full launch kit: market research, marketing content, and a styled landing page. Three AI agents run in sequence, passing context forward like a real team.

![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)
![Vanilla JS](https://img.shields.io/badge/JS-Vanilla-F7DF1E?logo=javascript&logoColor=black)
![Groq](https://img.shields.io/badge/Groq-llama--3.3--70b-orange)
![Zero npm](https://img.shields.io/badge/npm-zero%20deps-success)

---

## Quick Start

### Prerequisites

- PHP 8.1+ with **cURL** extension (`php -m | grep curl`)
- A [Groq API key](https://console.groq.com/) (free tier works)

### 1. Clone & configure

```bash
git clone https://github.com/Anmol-Kumar01/nkh-hack-launch-mind.git
cd nkh-hack-launch-mind

# Create your local env file (never commit this)
cp .env.example .env   # or create manually
```

Add your key to `.env`:

```env
GROQ_API_KEY=gsk_your_key_here
```

### 2. Run

```bash
php -S localhost:8000
```

Open **http://localhost:8000**

That's it. No `composer install`, no `npm install`.

---

## How It Works

```
User goal
    ↓
Research Agent  →  Market report (Markdown, ~600 words)
    ↓  (passes research)
Content Agent   →  Blog, Newsletter, LinkedIn, Twitter, Copy (JSON)
    ↓  (passes research + tagline)
Dev Agent       →  Full HTML landing page (Tailwind CSS)
```

Each agent is a separate PHP file under `agents/`. The frontend calls `api.php`, which routes to the correct agent.

---

## Project Structure

```
nkh-hack-launch-mind/
├── index.php              # UI (dashboard, nav, output panels)
├── api.php                # API router + config
├── agents/
│   ├── research.php       # Market research agent
│   ├── content.php        # Content suite agent
│   └── dev.php            # Landing page generator
├── lib/
│   ├── env.php            # .env loader
│   ├── groq.php           # Groq API client
│   ├── landing.php        # Landing page HTML sanitizer (injects Tailwind CDN)
│   └── words.php          # Word-limit helper
├── assets/
│   ├── css/style.css      # App styles
│   └── js/script.js       # Workflow orchestration + downloads
├── .env                   # Local secrets (gitignored)
├── .gitignore
└── README.md
```

---

## API Reference

All requests go to `POST /api.php` with JSON body.

### Research Agent

```bash
curl -X POST http://localhost:8000/api.php \
  -H "Content-Type: application/json" \
  -d '{"agent":"research","goal":"Launch a green-energy newsletter in India"}'
```

### Content Agent

```bash
curl -X POST http://localhost:8000/api.php \
  -H "Content-Type: application/json" \
  -d '{"agent":"content","goal":"...","research":"...markdown from step 1..."}'
```

### Dev Agent

```bash
curl -X POST http://localhost:8000/api.php \
  -H "Content-Type: application/json" \
  -d '{"agent":"dev","goal":"...","research":"...","tagline":"..."}'
```

**Response format (all agents):**

```json
{ "output": "..." }
```

**Error format:**

```json
{ "error": "Error message" }
```

---

## Features

| Feature | Description |
|---------|-------------|
| Goal dashboard | Enter a business goal, launch the 3-agent pipeline |
| Agent visualizer | Live status cards for Research → Content → Dev |
| Research report | 11-section market doc, Copy / DOC / PDF download |
| Content suite | Blog, Newsletter, LinkedIn, Twitter, Copy tabs |
| Landing page | 12-section Tailwind page, mobile preview frame |
| Download All (ZIP) | Full launch kit: research + content + HTML |
| Agent memory | Shows context chain between agents |
| Workflow timeline | Timestamped log of each agent step |

---

## Configuration

| Variable | Required | Description |
|----------|----------|-------------|
| `GROQ_API_KEY` | Yes | Groq API key from console.groq.com |

Optional: set `GROQ_API_KEY` as a system env var instead of `.env`.

Model used: `llama-3.3-70b-versatile` (configured in `api.php`).

---

## Development

### Run locally

```bash
php -S localhost:8000
```

### Check PHP extensions

```bash
php -m | grep -i curl
php -l api.php
php -l agents/research.php
```

### Test an agent directly

```bash
curl -s -X POST http://localhost:8000/api.php \
  -H "Content-Type: application/json" \
  -d '{"agent":"research","goal":"Test coffee shop in Mumbai"}' | jq .
```

### Modify an agent

Edit the prompt and logic in `agents/<name>.php`. Each agent exports one function:

- `runResearchAgent($goal, $key, $model, $url): string`
- `runContentAgent($goal, $research, $key, $model, $url): array`
- `runDevAgent($goal, $research, $tagline, $key, $model, $url): string`

No rebuild step needed. Refresh and re-run.

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| `Missing GROQ_API_KEY` | Add key to `.env` or export as env var |
| `cURL error` | Install php-curl: `sudo apt install php-curl` |
| Rate limit (429) | Wait 60s or upgrade Groq plan |
| Workflow timeout | Normal for full run (~60-120s). Check Groq dashboard |
| Content tabs empty | Retry workflow. JSON parse fallback is in `agents/content.php` |
| Landing page unstyled | `lib/landing.php` auto-injects Tailwind CDN if missing |

---

## Demo Script (for judges)

1. Open **http://localhost:8000**
2. Enter: *"I want to launch a newsletter about green-energy startups in India"*
3. Click **Launch**
4. Watch agent cards activate in sequence
5. Show **Research Report** (scroll, download PDF)
6. Switch **Content Suite** tabs (Blog → Newsletter → LinkedIn)
7. Scroll to **Landing Page** mobile preview below
8. Click **Download All (ZIP)**
9. Show **Agent Memory** context chain

---

## License

Built for NKH Hackathon · Track 2 Promptathon.
