<!DOCTYPE html>
<html class="dark" lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LAUNCH MIND | One Goal. One Team. Infinite Execution.</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Geist:wght@500&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#dbfcff",
            "primary-container": "#00f0ff",
            "on-primary-container": "#006970",
            "on-surface": "#dee1f7",
            "on-surface-variant": "#b9cacb",
            "secondary": "#b8c3ff",
            "outline": "#849495",
            "surface": "#0e1322",
            "background": "#0e1322",
            "surface-dim": "#0e1322",
            "surface-container-low": "#161b2b",
            "surface-container-lowest": "#090e1c"
          }
        }
      }
    };
  </script>
</head>
<body class="dark font-body-md text-body-md selection:bg-primary-container/30">

<!-- ═══ HEADER / NAVBAR ═══ -->
<header class="site-header sticky top-0 z-50 w-full border-b border-white/10 bg-surface/30 backdrop-blur-xl shadow-[0_8px_32px_0_rgba(0,240,255,0.08)]">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 md:px-12">
    <a href="#home" class="flex items-center gap-3">
      <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-container/20">
        <span class="material-symbols-outlined text-primary-container">hub</span>
      </div>
      <div>
        <div class="text-sm font-black tracking-tighter text-primary">LAUNCH MIND</div>
        <div class="hidden text-[10px] uppercase tracking-widest text-on-surface-variant sm:block">Multi-Agent Orchestrator</div>
      </div>
    </a>

    <nav class="hidden items-center gap-8 md:flex" id="main-nav">
      <a href="#home" class="nav-link nav-link-active">Home</a>
      <a href="#about" class="nav-link">About</a>
      <a href="#how-it-works" class="nav-link">How It Works</a>
      <a href="#dashboard" class="nav-link">Dashboard</a>
    </nav>

    <div class="flex items-center gap-3">
      <div id="workflow-status" class="hidden items-center gap-2 text-xs text-on-surface-variant">
        <div id="status-dot" class="h-2 w-2 rounded-full bg-primary-container"></div>
        <span id="status-text">Ready</span>
      </div>
      <button id="mobile-menu-btn" class="rounded-lg p-2 text-on-surface-variant hover:bg-white/5 md:hidden" onclick="toggleMobileMenu()">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <a href="#dashboard" class="hidden rounded-full bg-primary-container px-5 py-2 text-sm font-bold text-on-primary-container transition-transform hover:scale-105 sm:inline-block">
        New Launch
      </a>
    </div>
  </div>

  <!-- Mobile nav -->
  <div id="mobile-nav" class="hidden border-t border-white/5 px-6 py-4 md:hidden">
    <nav class="flex flex-col gap-3">
      <a href="#home" class="nav-link" onclick="toggleMobileMenu()">Home</a>
      <a href="#about" class="nav-link" onclick="toggleMobileMenu()">About</a>
      <a href="#how-it-works" class="nav-link" onclick="toggleMobileMenu()">How It Works</a>
      <a href="#dashboard" class="nav-link" onclick="toggleMobileMenu()">Dashboard</a>
    </nav>
  </div>
</header>

<main class="relative">

  <!-- ═══ HOME / HERO ═══ -->
  <section id="home" class="relative scroll-mt-20">
    <div class="hero-gradient pointer-events-none absolute inset-0 z-0"></div>
    <div id="hero-section" class="relative z-10 mx-auto max-w-6xl px-4 py-16 text-center md:px-8 md:py-20">
      <p class="section-eyebrow mb-4">AI-Powered Business Orchestrator</p>
      <h1 class="text-glow mx-auto mb-4 max-w-4xl text-3xl font-extrabold leading-tight text-primary md:text-5xl">
        Launch your next big idea with the power of a
        <span class="bg-gradient-to-r from-primary-container to-secondary bg-clip-text text-transparent">collective mind.</span>
      </h1>
      <p class="mx-auto max-w-2xl text-base text-on-surface-variant md:text-lg">
        Turn your business intent into a complete product with a collaborative swarm of AI agents working in perfect harmony.
      </p>
    </div>
  </section>

  <!-- ═══ ABOUT ═══ -->
  <section id="about" class="scroll-mt-20 border-t border-white/5 bg-surface-container-lowest/40 py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 md:px-8">
      <div class="mb-10 text-center">
        <p class="section-eyebrow mb-3">About Launch Mind</p>
        <h2 class="text-2xl font-bold text-primary md:text-3xl">One goal. One team. Infinite execution.</h2>
        <p class="mx-auto mt-4 max-w-2xl text-on-surface-variant">
          Launch Mind is a multi-agent AI orchestrator built for founders, creators, and teams who want to go from idea to launch kit in minutes, not months.
        </p>
      </div>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="glass-card rounded-2xl p-6">
          <span class="material-symbols-outlined mb-3 text-3xl text-primary-container">psychology</span>
          <h3 class="mb-2 font-semibold text-primary">Agent Intelligence</h3>
          <p class="text-sm text-on-surface-variant">Three specialized AI agents (Research, Content, and Dev), each expert in their domain, passing context forward like a real team.</p>
        </div>
        <div class="glass-card rounded-2xl p-6">
          <span class="material-symbols-outlined mb-3 text-3xl text-primary-container">bolt</span>
          <h3 class="mb-2 font-semibold text-primary">Speed to Market</h3>
          <p class="text-sm text-on-surface-variant">Generate market research, marketing content, and a styled landing page in a single workflow, ready to download and deploy.</p>
        </div>
        <div class="glass-card rounded-2xl p-6">
          <span class="material-symbols-outlined mb-3 text-3xl text-primary-container">hub</span>
          <h3 class="mb-2 font-semibold text-primary">Context Chain</h3>
          <p class="text-sm text-on-surface-variant">Every agent builds on the previous one's output. Research informs content. Content informs the landing page. Nothing gets lost.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══ HOW IT WORKS ═══ -->
  <section id="how-it-works" class="scroll-mt-20 py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4 md:px-8">
      <div class="mb-10 text-center">
        <p class="section-eyebrow mb-3">How It Works</p>
        <h2 class="text-2xl font-bold text-primary md:text-3xl">Your Swarm Awaits</h2>
        <p class="mt-3 text-on-surface-variant">Three specialized nodes, one unified mission.</p>
      </div>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="glass-card group rounded-3xl p-6 transition-transform hover:scale-[1.02]">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-container/10 text-primary-container transition-colors group-hover:bg-primary-container/20">
            <span class="material-symbols-outlined text-3xl">search</span>
          </div>
          <div class="mb-2 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-container/20 text-xs font-bold text-primary-container">1</span>
            <h3 class="font-semibold text-primary">Research Agent</h3>
          </div>
          <p class="text-sm text-on-surface-variant">Analyzes your market: size, competitors, trends, risks, and MVP recommendations. Downloads as DOC or PDF.</p>
        </div>
        <div class="glass-card group rounded-3xl p-6 transition-transform hover:scale-[1.02]">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-container/10 text-primary-container transition-colors group-hover:bg-primary-container/20">
            <span class="material-symbols-outlined text-3xl">edit_note</span>
          </div>
          <div class="mb-2 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-container/20 text-xs font-bold text-primary-container">2</span>
            <h3 class="font-semibold text-primary">Content Agent</h3>
          </div>
          <p class="text-sm text-on-surface-variant">Creates blog posts, newsletters, LinkedIn posts, Twitter threads, and marketing copy, all informed by the research report.</p>
        </div>
        <div class="glass-card group rounded-3xl p-6 transition-transform hover:scale-[1.02]">
          <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary-container/10 text-primary-container transition-colors group-hover:bg-primary-container/20">
            <span class="material-symbols-outlined text-3xl">terminal</span>
          </div>
          <div class="mb-2 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-container/20 text-xs font-bold text-primary-container">3</span>
            <h3 class="font-semibold text-primary">Dev Agent</h3>
          </div>
          <p class="text-sm text-on-surface-variant">Builds a fully styled HTML landing page with Tailwind CSS. Preview it live, copy the HTML, and deploy instantly.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══ DASHBOARD / WORKFLOW ═══ -->
  <section id="dashboard" class="scroll-mt-20 border-t border-white/5 bg-surface-container-lowest/20 py-12 md:py-16">
    <div class="relative z-10 mx-auto max-w-6xl px-4 md:px-8">

      <div class="mb-8 text-center">
        <p class="section-eyebrow mb-3">Launch Dashboard</p>
        <h2 class="text-2xl font-bold text-primary">Start Your Launch</h2>
      </div>

      <!-- Goal Input -->
      <div id="goal-panel" class="glass-card glow-border mx-auto mb-8 max-w-3xl rounded-2xl p-6 transition-all duration-500">
        <label class="mb-3 flex items-center gap-2 text-sm font-medium text-on-surface-variant">
          <span class="material-symbols-outlined text-lg text-primary-container">auto_awesome</span>
          Your business goal
        </label>
        <textarea
          id="goal-input"
          rows="3"
          placeholder="e.g. I want to launch a newsletter about green-energy startups in India"
          class="w-full resize-none rounded-xl border border-white/10 bg-surface-container-low px-4 py-3 text-sm text-primary placeholder-outline transition-all focus:border-primary-container focus:ring-0"
        ></textarea>
        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
          <div id="example-chips" class="flex flex-wrap gap-2">
            <button onclick="setExample('I want to launch a SaaS tool for freelance designers in India')" class="example-chip">SaaS for designers</button>
            <button onclick="setExample('I want to start a D2C skincare brand targeting Gen Z in urban India')" class="example-chip">D2C skincare brand</button>
            <button onclick="setExample('I want to launch a newsletter about green-energy startups in India')" class="example-chip">Green-energy newsletter</button>
          </div>
          <button id="launch-btn" onclick="launchWorkflow()" class="btn-primary">
            <span id="launch-btn-text">Launch</span>
            <span id="launch-btn-icon" class="material-symbols-outlined text-lg">rocket_launch</span>
          </button>
        </div>
      </div>

      <!-- Agent Status Bar -->
      <div id="agent-status-bar" class="mb-8 hidden max-w-3xl mx-auto">
        <div class="flex items-center gap-3">
          <div class="agent-card flex-1 p-4" id="card-research">
            <div class="flex items-center gap-3">
              <div id="icon-research" class="agent-icon-wrap"><span class="material-symbols-outlined">schedule</span></div>
              <div>
                <div class="flex items-center gap-1.5 text-sm font-semibold text-primary">
                  <span class="material-symbols-outlined text-base text-primary-container">search</span>Research Agent
                </div>
                <div id="label-research" class="text-xs text-on-surface-variant">Waiting</div>
              </div>
            </div>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/40">arrow_forward</span>
          <div class="agent-card flex-1 p-4" id="card-content">
            <div class="flex items-center gap-3">
              <div id="icon-content" class="agent-icon-wrap"><span class="material-symbols-outlined">schedule</span></div>
              <div>
                <div class="flex items-center gap-1.5 text-sm font-semibold text-primary">
                  <span class="material-symbols-outlined text-base text-primary-container">edit_note</span>Content Agent
                </div>
                <div id="label-content" class="text-xs text-on-surface-variant">Waiting</div>
              </div>
            </div>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/40">arrow_forward</span>
          <div class="agent-card flex-1 p-4" id="card-dev">
            <div class="flex items-center gap-3">
              <div id="icon-dev" class="agent-icon-wrap"><span class="material-symbols-outlined">schedule</span></div>
              <div>
                <div class="flex items-center gap-1.5 text-sm font-semibold text-primary">
                  <span class="material-symbols-outlined text-base text-primary-container">terminal</span>Dev Agent
                </div>
                <div id="label-dev" class="text-xs text-on-surface-variant">Waiting</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Output Grid -->
      <div id="output-area" class="hidden">

        <!-- Download All bar (shown after workflow completes) -->
        <div id="download-all-bar" class="download-all-bar hidden mb-6">
          <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-2xl text-primary-container">folder_zip</span>
              <div>
                <div class="text-sm font-semibold text-primary">Full Launch Kit Ready</div>
                <div class="text-xs text-on-surface-variant">Research · Content · Landing page, all in one ZIP</div>
              </div>
            </div>
            <button id="download-all-btn" onclick="downloadAllZip()" class="btn-download-all">
              <svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg>
              Download All (ZIP)
            </button>
          </div>
        </div>

        <!-- Top row: Research + Content (equal width & height) -->
        <div class="output-grid-top">

          <div class="agent-card output-panel output-panel-equal p-5" id="research-output-card">
            <div class="mb-4 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-lg text-primary-container">analytics</span>
                <div class="section-eyebrow">Research Report</div>
              </div>
              <div class="flex flex-wrap justify-end gap-2">
                <button class="copy-btn" onclick="copyResearch()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="5" width="8" height="9" rx="1"/><path d="M4 3h6a1 1 0 0 1 1 1v1"/></svg>Copy</button>
                <button class="copy-btn download-btn" onclick="downloadResearchDoc()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg>DOC</button>
                <button class="copy-btn download-btn" onclick="downloadResearchPdf()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg>PDF</button>
              </div>
            </div>
            <div class="scroll-box scroll-box-equal">
              <div id="research-body" class="output-content"><div class="empty-state">Waiting for research agent...</div></div>
            </div>
          </div>

          <div class="agent-card output-panel output-panel-equal p-5" id="content-output-card">
            <div class="mb-3 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-lg text-primary-container">article</span>
                <div class="section-eyebrow">Content Suite</div>
              </div>
              <div class="flex flex-wrap justify-end gap-2">
                <button class="copy-btn" onclick="copyActiveTab()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="5" width="8" height="9" rx="1"/><path d="M4 3h6a1 1 0 0 1 1 1v1"/></svg>Copy</button>
                <button class="copy-btn download-btn" onclick="downloadContentDoc()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg>DOC</button>
                <button class="copy-btn download-btn" onclick="downloadContentPdf()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg>PDF</button>
              </div>
            </div>
            <div class="mb-4 flex flex-wrap gap-1" id="content-tabs">
              <button class="tab-btn active" onclick="switchTab('blog', this)">Blog</button>
              <button class="tab-btn" onclick="switchTab('newsletter', this)">Newsletter</button>
              <button class="tab-btn" onclick="switchTab('linkedin', this)">LinkedIn</button>
              <button class="tab-btn" onclick="switchTab('twitter', this)">Twitter</button>
              <button class="tab-btn" onclick="switchTab('copy', this)">Copy</button>
            </div>
            <div class="scroll-box scroll-box-equal">
              <div id="content-body" class="output-content"><div class="empty-state">Waiting for content agent...</div></div>
            </div>
          </div>

        </div>

        <!-- Landing Page: full width below -->
        <div class="agent-card output-panel mt-6 p-5" id="landing-output-card">
          <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-lg text-primary-container">web</span>
              <div>
                <div class="section-eyebrow">Landing Page</div>
                <div id="preview-size-label" class="text-xs text-on-surface-variant">Mobile preview (375px)</div>
              </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
              <div class="preview-device-toggle">
                <button type="button" class="device-toggle-btn active" onclick="setPreviewMode('mobile', this)" title="Phone view">
                  <span class="material-symbols-outlined">smartphone</span>
                  <span class="hidden sm:inline">Phone</span>
                </button>
                <button type="button" class="device-toggle-btn" onclick="setPreviewMode('desktop', this)" title="Desktop view">
                  <span class="material-symbols-outlined">desktop_windows</span>
                  <span class="hidden sm:inline">Desktop</span>
                </button>
              </div>
              <button class="copy-btn" onclick="copyLandingPage()"><svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="5" width="8" height="9" rx="1"/><path d="M4 3h6a1 1 0 0 1 1 1v1"/></svg>HTML</button>
              <button class="copy-btn" id="preview-toggle" onclick="togglePreview()"><span class="material-symbols-outlined" style="font-size:14px">visibility</span> Preview</button>
            </div>
          </div>
          <div id="landing-code-view" class="scroll-box scroll-box-code hidden"><div class="empty-state">Waiting for dev agent...</div></div>
          <div id="landing-preview-view" class="landing-preview-stage preview-mobile-mode">
            <div id="device-frame" class="device-frame device-mobile">
              <div class="device-frame-bar" id="device-frame-bar">
                <span class="device-frame-dot"></span>
                <span class="device-frame-dot"></span>
                <span class="device-frame-dot"></span>
                <span id="device-frame-url" class="device-frame-bar-url">preview.launchmind.local</span>
              </div>
              <div class="device-frame-screen">
                <iframe id="landing-iframe" class="landing-iframe" sandbox="allow-scripts allow-same-origin"></iframe>
              </div>
            </div>
          </div>
        </div>

        <!-- Bottom row: Timeline + Memory -->
        <div class="output-grid-bottom mt-6">
          <div class="agent-card output-panel p-5" id="timeline-card">
            <div class="mb-4 flex items-center gap-2">
              <span class="material-symbols-outlined text-lg text-primary-container">timeline</span>
              <div class="section-eyebrow">Workflow Timeline</div>
            </div>
            <div class="scroll-box scroll-box-sm">
              <div id="timeline-list"><div class="empty-state">Timeline will appear here...</div></div>
            </div>
          </div>

          <div class="agent-card p-5" id="memory-card">
            <div class="mb-4 flex items-center gap-2">
              <span class="material-symbols-outlined text-lg text-primary-container">memory</span>
              <div class="section-eyebrow">Agent Memory | Context Chain</div>
            </div>
            <div class="grid grid-cols-1 gap-4">
              <div class="memory-block">
                <div class="memory-label memory-label-1">① Research Output →</div>
                <div id="mem-research" class="memory-text">Waiting...</div>
              </div>
              <div class="memory-block">
                <div class="memory-label memory-label-2">② Content Agent receives →</div>
                <div id="mem-content" class="memory-text">Waiting...</div>
              </div>
              <div class="memory-block">
                <div class="memory-label memory-label-3">③ Dev Agent receives →</div>
                <div id="mem-dev" class="memory-text">Waiting...</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</main>

<!-- ═══ FOOTER ═══ -->
<footer class="site-footer relative z-10 border-t border-white/5 bg-surface-dim">
  <div class="mx-auto max-w-7xl px-6 py-12 md:px-12">
    <div class="grid grid-cols-1 gap-10 md:grid-cols-4">
      <div class="md:col-span-2">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-primary-container">hub</span>
          <span class="font-bold tracking-wider text-primary">LAUNCH MIND</span>
        </div>
        <p class="mt-3 max-w-sm text-sm text-outline">
          Accelerating thought with execution precision. One goal, three agents, full launch kit.
        </p>
        <p class="mt-4 text-xs text-outline/60">© 2024 Launch Mind · Track 2 Promptathon · Powered by Groq</p>
      </div>
      <div>
        <h4 class="mb-4 text-xs font-bold uppercase tracking-widest text-primary">Navigate</h4>
        <ul class="space-y-2 text-sm text-outline">
          <li><a href="#home" class="footer-link">Home</a></li>
          <li><a href="#about" class="footer-link">About</a></li>
          <li><a href="#how-it-works" class="footer-link">How It Works</a></li>
          <li><a href="#dashboard" class="footer-link">Dashboard</a></li>
        </ul>
      </div>
      <div>
        <h4 class="mb-4 text-xs font-bold uppercase tracking-widest text-primary">Agents</h4>
        <ul class="space-y-2 text-sm text-outline">
          <li><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-primary-container">search</span>Research Agent</span></li>
          <li><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-primary-container">edit_note</span>Content Agent</span></li>
          <li><span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm text-primary-container">terminal</span>Dev Agent</span></li>
        </ul>
      </div>
    </div>
    <div class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-white/5 pt-6 md:flex-row">
      <div class="flex gap-6 text-xs text-outline">
        <a href="#" class="footer-link">Terms of Service</a>
        <a href="#" class="footer-link">Privacy Policy</a>
        <a href="#" class="footer-link">Status Page</a>
      </div>
      <div class="flex items-center gap-2 text-xs text-outline">
        <span class="h-2 w-2 rounded-full bg-primary-container animate-pulse"></span>
        All systems operational
      </div>
    </div>
  </div>
</footer>

<script src="assets/js/script.js" defer></script>
</body>
</html>
