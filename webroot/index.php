<?php
$phpVersion = phpversion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Berny WebHost</title>

  <style>
    :root{
      /* Light */
      --bg: #f5f5f7;
      --bg2:#ffffff;
      --card: rgba(255,255,255,0.72);
      --stroke: rgba(0,0,0,0.08);
      --text: #1d1d1f;
      --muted: #6e6e73;
      --accent: #0071e3;
      --success: #34c759;
      --shadow: 0 12px 34px rgba(0,0,0,0.10), 0 1px 0 rgba(255,255,255,0.65) inset;
      --radius: 18px;
      --blur: blur(22px);
    }

    /* Auto dark if OS is dark */
    @media (prefers-color-scheme: dark){
      :root{
        --bg: #0b0b0f;
        --bg2:#121216;
        --card: rgba(18,18,22,0.72);
        --stroke: rgba(255,255,255,0.10);
        --text: #f5f5f7;
        --muted: rgba(245,245,247,0.65);
        --accent: #0a84ff;
        --success: #30d158;
        --shadow: 0 14px 40px rgba(0,0,0,0.55), 0 1px 0 rgba(255,255,255,0.06) inset;
      }
    }

    /* Manual override */
    html[data-theme="dark"]{
      --bg: #0b0b0f;
      --bg2:#121216;
      --card: rgba(18,18,22,0.72);
      --stroke: rgba(255,255,255,0.10);
      --text: #f5f5f7;
      --muted: rgba(245,245,247,0.65);
      --accent: #0a84ff;
      --success: #30d158;
      --shadow: 0 14px 40px rgba(0,0,0,0.55), 0 1px 0 rgba(255,255,255,0.06) inset;
    }
    html[data-theme="light"]{
      --bg: #f5f5f7;
      --bg2:#ffffff;
      --card: rgba(255,255,255,0.72);
      --stroke: rgba(0,0,0,0.08);
      --text: #1d1d1f;
      --muted: #6e6e73;
      --accent: #0071e3;
      --success: #34c759;
      --shadow: 0 12px 34px rgba(0,0,0,0.10), 0 1px 0 rgba(255,255,255,0.65) inset;
    }

    *{ box-sizing:border-box; margin:0; padding:0; }
    body{
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--text);
      background:
        radial-gradient(900px 500px at 20% 10%, rgba(10,132,255,0.18), transparent 60%),
        radial-gradient(900px 500px at 80% 20%, rgba(48,209,88,0.12), transparent 60%),
        linear-gradient(180deg, var(--bg2) 0%, var(--bg) 100%);
      font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display","SF Pro Text","Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    .card{
      width: min(680px, 92vw);
      padding: 46px 54px;
      border-radius: var(--radius);
      background: var(--card);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      border: 1px solid var(--stroke);
      box-shadow: var(--shadow);
      animation: enter .75s ease;
      position: relative;
      overflow: hidden;
    }

    .card::before{
      content:"";
      position:absolute;
      inset:-2px;
      background: radial-gradient(600px 220px at 20% 0%, rgba(10,132,255,0.18), transparent 60%),
                  radial-gradient(560px 220px at 80% 0%, rgba(48,209,88,0.10), transparent 60%);
      pointer-events:none;
      filter: blur(14px);
      opacity: .9;
    }

    @keyframes enter{
      from{ opacity:0; transform: translateY(12px); }
      to{ opacity:1; transform: translateY(0); }
    }

    .top{
      position: relative;
      z-index: 1;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap: 16px;
      margin-bottom: 18px;
    }

    .badge{
      display:inline-flex;
      gap:10px;
      align-items:center;
      padding: 7px 12px;
      border-radius: 999px;
      border: 1px solid var(--stroke);
      background: rgba(0,0,0,0.04);
      color: var(--muted);
      font-size:.85rem;
      font-weight:600;
    }

    .badge .pill{
      width: 10px; height: 10px; border-radius: 50%;
      background: var(--success);
      box-shadow: 0 0 0 6px rgba(48,209,88,0.12);
    }

    .toggle{
      border: 1px solid var(--stroke);
      background: rgba(0,0,0,0.04);
      color: var(--text);
      border-radius: 999px;
      padding: 10px 12px;
      cursor: pointer;
      display:flex;
      align-items:center;
      gap: 10px;
      font-size: .9rem;
      font-weight: 600;
      transition: transform .15s ease, background .2s ease;
      user-select:none;
    }
    .toggle:hover{ transform: translateY(-1px); }
    .toggle span{ color: var(--muted); font-weight: 700; }

    h1{
      position: relative;
      z-index: 1;
      font-size: 2.35rem;
      letter-spacing: -0.02em;
      margin-bottom: 10px;
    }
    p{
      position: relative;
      z-index: 1;
      color: var(--muted);
      line-height: 1.65;
      font-size: 1.05rem;
      margin-bottom: 26px;
    }

    .grid{
      position: relative;
      z-index: 1;
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px;
      margin-bottom: 22px;
    }

    .box{
      border: 1px solid var(--stroke);
      background: rgba(255,255,255,0.06);
      border-radius: 14px;
      padding: 18px 18px;
    }

    .label{
      font-size: .78rem;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .value{
      font-size: 1.25rem;
      font-weight: 700;
      letter-spacing: -0.01em;
      word-break: break-word;
    }

    .status{
      position: relative;
      z-index: 1;
      display:flex;
      align-items:center;
      gap: 10px;
      font-weight: 700;
      color: var(--success);
      margin-bottom: 30px;
    }
    .dot{
      width: 10px; height: 10px; border-radius: 50%;
      background: var(--success);
      box-shadow: 0 0 0 7px rgba(48,209,88,0.12);
    }

    .cta{
      position: relative;
      z-index: 1;
      display:flex;
      flex-wrap:wrap;
      gap: 12px;
    }
    .btn{
      border: 1px solid var(--stroke);
      border-radius: 999px;
      padding: 12px 18px;
      font-size: .95rem;
      font-weight: 700;
      text-decoration:none;
      cursor:pointer;
      transition: transform .15s ease, background .2s ease;
      display:inline-flex;
      align-items:center;
      gap: 10px;
      user-select:none;
    }
    .btn:hover{ transform: translateY(-1px); }

    .btn-primary{
      background: var(--accent);
      color: #fff;
      border-color: transparent;
    }
    .btn-primary:hover{ filter: brightness(0.95); }

    .btn-secondary{
      background: rgba(0,0,0,0.04);
      color: var(--text);
    }

    footer{
      position: relative;
      z-index: 1;
      margin-top: 32px;
      text-align:center;
      color: var(--muted);
      font-size: .86rem;
    }
    footer a{
      color: var(--accent);
      text-decoration:none;
      font-weight: 700;
    }
    footer a:hover{ text-decoration: underline; }

    @media (max-width: 640px){
      .card{ padding: 34px 26px; }
      h1{ font-size: 2.0rem; }
      .grid{ grid-template-columns: 1fr; }
      .toggle{ width: 100%; justify-content:center; }
      .top{ flex-direction: column; align-items: stretch; }
    }
  </style>
</head>

<body>
  <div class="card">
    <div class="top">
      <div class="badge">
        <div class="pill"></div>
        Berny WebHost
      </div>

      <button class="toggle" id="themeToggle" type="button" aria-label="Toggle theme">
        <span id="themeIcon">🌙</span>
        Theme
      </button>
    </div>

    <h1>Your server is ready.</h1>
    <p>
      Nginx and PHP-FPM are running correctly. Deploy your site into
      <strong>/home/container/webroot</strong> or enable WordPress from the egg settings.
    </p>

    <div class="grid">
      <div class="box">
        <div class="label">PHP Version</div>
        <div class="value"><?php echo htmlspecialchars($phpVersion); ?></div>
      </div>

      <div class="box">
        <div class="label">Web Root</div>
        <div class="value">/home/container/webroot</div>
      </div>
    </div>

    <div class="status">
      <div class="dot"></div>
      Webserver running correctly
    </div>

    <div class="cta">
      <a class="btn btn-primary" href="#" onclick="alert('Upload your files to /home/container/webroot')">
        🚀 Deploy your site
      </a>
      <a class="btn btn-secondary" href="https://discord.gg/CcrDG8Vxp5" target="_blank" rel="noopener">
        💬 BernyDev Community
      </a>
    </div>

    <footer>
      Powered by <strong>Berny</strong> · Nginx + PHP-FPM · Pelican Panel
    </footer>
  </div>

  <script>
    // Theme logic: auto by system, but allow manual override (persisted)
    const root = document.documentElement;
    const btn = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");

    function setIcon(theme) {
      icon.textContent = theme === "dark" ? "🌙" : "☀️";
    }

    function applyTheme(theme) {
      root.setAttribute("data-theme", theme);
      localStorage.setItem("berny_theme", theme);
      setIcon(theme);
    }

    // Load saved theme if exists
    const saved = localStorage.getItem("berny_theme");
    if (saved === "dark" || saved === "light") {
      applyTheme(saved);
    } else {
      // No override: show icon based on system preference
      const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
      setIcon(prefersDark ? "dark" : "light");
    }

    btn.addEventListener("click", () => {
      const current = root.getAttribute("data-theme");
      if (current === "dark") return applyTheme("light");
      if (current === "light") return applyTheme("dark");

      // If no manual theme set yet, toggle from system preference
      const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
      applyTheme(prefersDark ? "light" : "dark");
    });
  </script>
</body>
</html>
