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
    :root {
      --bg: #f5f5f7;
      --card: rgba(255,255,255,0.75);
      --text: #1d1d1f;
      --muted: #6e6e73;
      --accent: #0071e3;
      --success: #34c759;
      --radius: 18px;
      --blur: blur(20px);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display",
                   "SF Pro Text", "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(180deg, #ffffff 0%, var(--bg) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text);
    }

    .card {
      background: var(--card);
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      border-radius: var(--radius);
      padding: 48px 56px;
      max-width: 640px;
      width: 90%;
      box-shadow:
        0 10px 30px rgba(0,0,0,0.08),
        0 1px 0 rgba(255,255,255,0.6) inset;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 999px;
      background: rgba(0,113,227,0.1);
      color: var(--accent);
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 18px;
    }

    h1 {
      font-size: 2.4rem;
      font-weight: 700;
      letter-spacing: -0.02em;
      margin-bottom: 12px;
    }

    p {
      font-size: 1.05rem;
      color: var(--muted);
      line-height: 1.6;
      margin-bottom: 28px;
    }

    .info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 32px;
    }

    .box {
      background: rgba(255,255,255,0.6);
      border-radius: 14px;
      padding: 20px;
      text-align: left;
    }

    .label {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--muted);
      margin-bottom: 6px;
    }

    .value {
      font-size: 1.3rem;
      font-weight: 600;
    }

    .status {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      color: var(--success);
      margin-bottom: 36px;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--success);
      box-shadow: 0 0 0 6px rgba(52,199,89,0.15);
    }

    .cta {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
    }

    .btn {
      appearance: none;
      border: none;
      border-radius: 999px;
      padding: 12px 22px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
    }

    .btn-primary {
      background: var(--accent);
      color: white;
    }

    .btn-primary:hover {
      background: #005bbf;
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: rgba(0,0,0,0.06);
      color: var(--text);
    }

    .btn-secondary:hover {
      background: rgba(0,0,0,0.1);
    }

    footer {
      margin-top: 36px;
      font-size: 0.85rem;
      color: var(--muted);
      text-align: center;
    }

    footer a {
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .card {
        padding: 36px 28px;
      }
      h1 {
        font-size: 2rem;
      }
      .info {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <div class="card">
    <div class="badge">Berny WebHost</div>

    <h1>Your server is ready</h1>
    <p>
      Nginx and PHP-FPM are correctly installed and running.
      You can now deploy your application or start building.
    </p>

    <div class="info">
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
      <a class="btn btn-primary" href="#" onclick="alert('Upload your files to webroot')">
        Deploy your site
      </a>
      <a class="btn btn-secondary" href="https://discord.gg/CcrDG8Vxp5" target="_blank">
        BernyDev Community
      </a>
    </div>

    <footer>
      Powered by <strong>Berny</strong> · Nginx + PHP-FPM · Pelican Panel
    </footer>
  </div>

</body>
</html>
