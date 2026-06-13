// ── State ──
let state = {
  goal: '',
  research: '',
  content: { blog:'', newsletter:'', linkedin:'', twitter:'', copy:'' },
  landingPage: '',
  activeTab: 'blog',
  previewMode: 'mobile',
  timeline: []
};

// ── Helpers ──
function setExample(text) {
  document.getElementById('goal-input').value = text;
}

function toggleMobileMenu() {
  const nav = document.getElementById('mobile-nav');
  nav.classList.toggle('hidden');
}

function enterWorkflowMode() {
  const btn = document.getElementById('launch-btn');
  btn.disabled = true;
  btn.classList.add('launching');
  document.getElementById('launch-btn-text').textContent = 'Launching...';

  document.getElementById('agent-status-bar').classList.remove('hidden');
  document.getElementById('output-area').classList.remove('hidden');
}

function exitWorkflowMode(success = true) {
  const btn = document.getElementById('launch-btn');
  btn.disabled = false;
  btn.classList.remove('launching');
  document.getElementById('launch-btn-text').textContent = 'Launch';
}

function log(msg) {
  const now = new Date();
  const ts = now.toLocaleTimeString('en-US', { hour12: false });
  state.timeline.push({ time: ts, msg });
  renderTimeline();
}

function renderTimeline() {
  const el = document.getElementById('timeline-list');
  el.innerHTML = state.timeline.map((e, i) => `
    <div class="flex gap-3 pb-3">
      <div class="flex flex-col items-center">
        <div class="timeline-dot"></div>
        ${i < state.timeline.length - 1 ? '<div class="timeline-line" style="height:20px"></div>' : ''}
      </div>
      <div>
        <span class="timeline-time">${e.time}</span>
        <span class="timeline-msg ml-2">${e.msg}</span>
      </div>
    </div>
  `).join('');
}

function setAgentIcon(iconEl, symbol, spin = false) {
  iconEl.innerHTML = `<span class="material-symbols-outlined${spin ? ' spin' : ''}">${symbol}</span>`;
}

function setAgentState(agent, status) {
  const card = document.getElementById(`card-${agent}`);
  const icon = document.getElementById(`icon-${agent}`);
  const label = document.getElementById(`label-${agent}`);
  card.classList.remove('active', 'done');
  if (status === 'active') {
    card.classList.add('active');
    setAgentIcon(icon, 'sync', true);
    icon.classList.add('pulse-ring');
    label.textContent = 'Running...';
    label.style.color = '#00f0ff';
  } else if (status === 'done') {
    card.classList.add('done');
    setAgentIcon(icon, 'check_circle');
    icon.classList.remove('pulse-ring');
    label.textContent = 'Complete';
    label.style.color = '#7df4ff';
  } else if (status === 'error') {
    setAgentIcon(icon, 'error');
    icon.classList.remove('pulse-ring');
    label.textContent = 'Error';
    label.style.color = '#ffb4ab';
  } else {
    setAgentIcon(icon, 'schedule');
    icon.classList.remove('pulse-ring');
    label.textContent = 'Waiting';
    label.style.color = '';
  }
}

function setStatus(text, active = false) {
  const bar = document.getElementById('workflow-status');
  const dot = document.getElementById('status-dot');
  const txt = document.getElementById('status-text');
  bar.style.display = 'flex';
  txt.textContent = text;
  if (active) {
    dot.style.background = '#00f0ff';
    dot.style.animation = 'pulse-ring 1.4s ease-out infinite';
  } else {
    dot.style.background = '#7df4ff';
    dot.style.animation = 'none';
  }
}

// ── Tab switching ──
function switchTab(tab, btn) {
  state.activeTab = tab;
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
  renderContentTab();
}

function renderContentTab() {
  const el = document.getElementById('content-body');
  const t = state.activeTab;
  const data = state.content[t];
  if (!data || !data.trim()) {
    el.innerHTML = `<div class="empty-state">${state.content.blog ? 'No content for this tab.' : 'Waiting for content agent...'}</div>`;
    return;
  }
  el.innerHTML = `<div class="content-text">${formatContentText(data)}</div>`;
}

function formatContentText(text) {
  return escapeHtml(text).replace(/\\n/g, '\n').split('\n').map(line => {
    if (!line.trim()) return '<br>';
    return `<p class="mb-2">${line}</p>`;
  }).join('');
}

// ── Landing page preview toggle ──
function togglePreview() {
  const codeView = document.getElementById('landing-code-view');
  const previewView = document.getElementById('landing-preview-view');
  const btn = document.getElementById('preview-toggle');
  if (codeView.classList.contains('hidden')) {
    codeView.classList.remove('hidden');
    previewView.classList.add('hidden');
    btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px">visibility</span> Preview';
  } else {
    codeView.classList.add('hidden');
    previewView.classList.remove('hidden');
    btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:14px">code</span> Code';
    loadLandingPreview();
  }
}

function loadLandingPreview() {
  if (!state.landingPage) return;
  const iframe = document.getElementById('landing-iframe');
  iframe.srcdoc = state.landingPage;
}

function setPreviewMode(mode, btn) {
  state.previewMode = mode;

  document.querySelectorAll('.device-toggle-btn').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');

  const frame = document.getElementById('device-frame');
  const stage = document.getElementById('landing-preview-view');
  const label = document.getElementById('preview-size-label');
  const urlBar = document.getElementById('device-frame-url');

  frame.classList.remove('device-mobile', 'device-desktop');
  stage.classList.remove('preview-mobile-mode', 'preview-desktop-mode');

  if (mode === 'desktop') {
    frame.classList.add('device-desktop');
    stage.classList.add('preview-desktop-mode');
    if (label) label.textContent = 'Desktop preview (1280px)';
    if (urlBar) urlBar.textContent = 'preview.launchmind.local';
  } else {
    frame.classList.add('device-mobile');
    stage.classList.add('preview-mobile-mode');
    if (label) label.textContent = 'Mobile preview (375px)';
  }

  loadLandingPreview();
}

// ── Copy helpers ──
function copyResearch() {
  navigator.clipboard.writeText(state.research || '').then(() => showToast('Copied!'));
}
function copyText(id) {
  const text = document.getElementById(id).innerText;
  navigator.clipboard.writeText(text).then(() => showToast('Copied!'));
}
function copyActiveTab() {
  const text = state.content[state.activeTab] || '';
  navigator.clipboard.writeText(text).then(() => showToast('Copied!'));
}
function copyLandingPage() {
  navigator.clipboard.writeText(state.landingPage || '').then(() => showToast('HTML copied!'));
}

// ── Download helpers ──
function downloadAsDoc(content, filename, title) {
  if (!content || !content.trim()) {
    showToast('Nothing to download yet');
    return;
  }
  const html = `<!DOCTYPE html><html><head><meta charset="utf-8"><title>${escapeHtml(title)}</title></head><body style="font-family:Arial,sans-serif;line-height:1.6;padding:40px;"><h1>${escapeHtml(title)}</h1><pre style="white-space:pre-wrap;font-family:Arial,sans-serif;font-size:12pt;">${escapeHtml(content)}</pre></body></html>`;
  const blob = new Blob(['\ufeff', html], { type: 'application/msword' });
  triggerDownload(blob, filename);
  showToast('DOC downloaded');
}

function downloadAsPdf(content, filename, title) {
  if (!content || !content.trim()) {
    showToast('Nothing to download yet');
    return;
  }
  if (typeof html2pdf === 'undefined') {
    showToast('PDF library loading, try again');
    return;
  }
  const wrapper = document.createElement('div');
  wrapper.style.cssText = 'position:fixed;left:-9999px;top:0;width:800px;padding:40px;font-family:Arial,sans-serif;line-height:1.6;color:#111;background:#fff;';
  wrapper.innerHTML = `<h1 style="font-size:22px;margin-bottom:16px;">${escapeHtml(title)}</h1><div style="font-size:12pt;white-space:pre-wrap;">${escapeHtml(content)}</div>`;
  document.body.appendChild(wrapper);

  html2pdf().set({
    margin: 10,
    filename: filename,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  }).from(wrapper).save().then(() => {
    wrapper.remove();
    showToast('PDF downloaded');
  }).catch(() => {
    wrapper.remove();
    showToast('PDF export failed');
  });
}

function triggerDownload(blob, filename) {
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = filename;
  a.click();
  URL.revokeObjectURL(url);
}

function downloadResearchDoc() {
  downloadAsDoc(state.research, 'research-report.doc', 'Research Report');
}
function downloadResearchPdf() {
  downloadAsPdf(state.research, 'research-report.pdf', 'Research Report');
}
function downloadContentDoc() {
  const tab = state.activeTab;
  const labels = { blog: 'Blog', newsletter: 'Newsletter', linkedin: 'LinkedIn', twitter: 'Twitter', copy: 'Marketing Copy' };
  const content = state.content[tab] || '';
  downloadAsDoc(content, `content-${tab}.doc`, labels[tab] || 'Content');
}
function downloadContentPdf() {
  const tab = state.activeTab;
  const labels = { blog: 'Blog', newsletter: 'Newsletter', linkedin: 'LinkedIn', twitter: 'Twitter', copy: 'Marketing Copy' };
  const content = state.content[tab] || '';
  downloadAsPdf(content, `content-${tab}.pdf`, labels[tab] || 'Content');
}

function slugify(text) {
  return text.toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-|-$/g, '')
    .slice(0, 40) || 'launch-kit';
}

function buildZipReadme() {
  const now = new Date().toLocaleString();
  const files = [
    'research-report.md',
    'content/blog.txt',
    'content/newsletter.txt',
    'content/linkedin.txt',
    'content/twitter.txt',
    'content/marketing-copy.txt',
    'landing-page.html'
  ];
  return `LAUNCH MIND: Full Launch Kit
Generated: ${now}

Business Goal:
${state.goal}

Contents:
${files.map(f => `  - ${f}`).join('\n')}

Generated by Launch Mind Multi-Agent Orchestrator
`;
}

function showDownloadAllBar() {
  const bar = document.getElementById('download-all-bar');
  if (bar) bar.classList.remove('hidden');
}

function hideDownloadAllBar() {
  const bar = document.getElementById('download-all-bar');
  if (bar) bar.classList.add('hidden');
}

async function downloadAllZip() {
  if (typeof JSZip === 'undefined') {
    showToast('ZIP library loading, try again');
    return;
  }

  const hasContent = state.research?.trim() ||
    Object.values(state.content).some(v => v?.trim()) ||
    state.landingPage?.trim();

  if (!hasContent) {
    showToast('Nothing to download yet');
    return;
  }

  const btn = document.getElementById('download-all-btn');
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined btn-icon spin" style="font-size:16px">sync</span> Building ZIP...';
  }

  try {
    const zip = new JSZip();
    const root = zip.folder('launch-kit');

    root.file('README.txt', buildZipReadme());

    if (state.research?.trim()) {
      root.file('research-report.md', state.research);
    }

    const contentFolder = root.folder('content');
    const contentFiles = {
      blog: 'blog.txt',
      newsletter: 'newsletter.txt',
      linkedin: 'linkedin.txt',
      twitter: 'twitter.txt',
      copy: 'marketing-copy.txt'
    };
    for (const [key, filename] of Object.entries(contentFiles)) {
      const text = state.content[key];
      if (text?.trim()) {
        contentFolder.file(filename, text.replace(/\\n/g, '\n'));
      }
    }

    if (state.landingPage?.trim()) {
      root.file('landing-page.html', state.landingPage);
    }

    const blob = await zip.generateAsync({ type: 'blob', compression: 'DEFLATE', compressionOptions: { level: 6 } });
    triggerDownload(blob, `${slugify(state.goal)}-launch-kit.zip`);
    showToast('ZIP downloaded!');
  } catch (err) {
    console.error(err);
    showToast('ZIP export failed');
  } finally {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = '<svg class="btn-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2v7"/><path d="M5.5 6.5 8 9l2.5-2.5"/><path d="M3 12h10"/></svg> Download All (ZIP)';
    }
  }
}
function showToast(msg) {
  const t = document.createElement('div');
  t.textContent = msg;
  t.style.cssText = 'position:fixed;bottom:24px;right:24px;background:#00f0ff;color:#00363a;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;z-index:9999;transition:opacity 0.3s;box-shadow:0 4px 20px rgba(0,240,255,0.3);';
  document.body.appendChild(t);
  setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 2000);
}

function escapeHtml(str) {
  return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function truncate(str, n = 120) {
  return str.length > n ? str.slice(0, n) + '...' : str;
}

// ── API call ──
async function callAgent(agentType, payload) {
  const res = await fetch('api.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ agent: agentType, ...payload })
  });
  if (!res.ok) {
    const err = await res.text();
    throw new Error(err || 'API error');
  }
  return res.json();
}

// ── Main Workflow ──
async function launchWorkflow() {
  const goal = document.getElementById('goal-input').value.trim();
  if (!goal) {
    document.getElementById('goal-input').focus();
    return;
  }

  state.goal = goal;
  state.timeline = [];
  state.research = '';
  state.content = { blog:'', newsletter:'', linkedin:'', twitter:'', copy:'' };
  state.landingPage = '';

  enterWorkflowMode();
  hideDownloadAllBar();

  // Reset agents
  ['research','content','dev'].forEach(a => setAgentState(a, 'waiting'));

  // Reset outputs
  document.getElementById('research-body').innerHTML = '<div class="empty-state">Waiting for research agent...</div>';
  document.getElementById('content-body').innerHTML = '<div class="empty-state">Waiting for content agent...</div>';
  document.getElementById('landing-code-view').innerHTML = '<div class="empty-state">Waiting for dev agent...</div>';
  document.getElementById('landing-code-view').classList.add('hidden');
  document.getElementById('landing-preview-view').classList.remove('hidden');
  document.getElementById('preview-toggle').innerHTML = '<span class="material-symbols-outlined" style="font-size:14px">code</span> Code';
  document.getElementById('landing-iframe').srcdoc = '';
  const mobileBtn = document.querySelector('.preview-device-toggle .device-toggle-btn');
  if (mobileBtn) setPreviewMode('mobile', mobileBtn);
  document.getElementById('mem-research').textContent = 'Waiting...';
  document.getElementById('mem-content').textContent = 'Waiting...';
  document.getElementById('mem-dev').textContent = 'Waiting...';

  setStatus('Running workflow...', true);
  log('Workflow started');

  try {
    // ── AGENT 1: Research ──
    setAgentState('research', 'active');
    log('Research Agent started');

    const researchResult = await callAgent('research', { goal });
    state.research = researchResult.output;

    document.getElementById('research-body').innerHTML = markdownToHtml(state.research);
    document.getElementById('mem-research').textContent = truncate(state.research);

    setAgentState('research', 'done');
    log('Research Agent complete');

    // ── AGENT 2: Content ──
    setAgentState('content', 'active');
    log('Content Agent started');

    const contentResult = await callAgent('content', { goal, research: state.research });
    const c = contentResult.output;
    state.content = {
      blog: c.blog || '',
      newsletter: c.newsletter || '',
      linkedin: c.linkedin || '',
      twitter: c.twitter || '',
      copy: c.copy || ''
    };

    renderContentTab();
    document.getElementById('mem-content').textContent = truncate(state.content.blog);

    setAgentState('content', 'done');
    log('Content Agent complete');

    // ── AGENT 3: Dev / Landing Page ──
    setAgentState('dev', 'active');
    log('Dev Agent started');

    const devResult = await callAgent('dev', {
      goal,
      research: state.research,
      tagline: state.content.copy
    });
    state.landingPage = devResult.output;

    document.getElementById('landing-code-view').innerHTML =
      `<pre class="text-xs text-on-surface-variant/60">${escapeHtml(state.landingPage.slice(0, 3000))}${state.landingPage.length > 3000 ? '...' : ''}</pre>`;
    document.getElementById('mem-dev').textContent = truncate(state.landingPage, 120);

    document.getElementById('landing-code-view').classList.add('hidden');
    document.getElementById('landing-preview-view').classList.remove('hidden');
    document.getElementById('preview-toggle').innerHTML = '<span class="material-symbols-outlined" style="font-size:14px">code</span> Code';
    loadLandingPreview();

    setAgentState('dev', 'done');
    log('Landing page generated');
    log('Workflow complete ✅');
    setStatus('Complete', false);
    showDownloadAllBar();
    exitWorkflowMode(true);

  } catch (err) {
    log('Error: ' + err.message);
    setStatus('Error, check console', false);
    console.error(err);
    if (state.research?.trim() || Object.values(state.content).some(v => v?.trim()) || state.landingPage?.trim()) {
      showDownloadAllBar();
    }
    exitWorkflowMode(false);
  }
}

// ── Simple markdown → HTML ──
function markdownToHtml(md) {
  let html = md;

  // Markdown tables
  html = html.replace(/^\|(.+)\|\s*\n\|[-| :]+\|\s*\n((?:\|.+\|\s*\n?)*)/gm, (_, header, rows) => {
    const ths = header.split('|').filter(c => c.trim()).map(c => `<th>${c.trim()}</th>`).join('');
    const trs = rows.trim().split('\n').map(row => {
      const tds = row.split('|').filter(c => c.trim()).map(c => `<td>${c.trim()}</td>`).join('');
      return `<tr>${tds}</tr>`;
    }).join('');
    return `<table><thead><tr>${ths}</tr></thead><tbody>${trs}</tbody></table>`;
  });

  return html
    .replace(/^## (.+)$/gm, '<h2>$1</h2>')
    .replace(/^### (.+)$/gm, '<h3>$1</h3>')
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
    .replace(/^- (.+)$/gm, '<li>$1</li>')
    .replace(/(<li>[\s\S]*?<\/li>)/g, '<ul>$1</ul>')
    .replace(/\n\n/g, '<br><br>')
    .trim();
}
