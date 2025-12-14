# Berny WebHost — Pelican Panel Egg (Nginx + PHP-FPM)

Minimal, stable, **Pelican-native** web hosting stack built and maintained by **Berny**.

This repository provides:

- 🥚 A **Pelican egg (PLCN_v1)** for Nginx + PHP-FPM hosting
- 🐳 A **custom Docker image** published in **GHCR**
- 🌐 Optional **WordPress** bootstrap
- 🔗 Optional **Git deployment** into `webroot`
- ✨ A modern **Apple-style** landing page (demo) for quick verification

---

## ✨ Features

- **Pelican Panel compatible** (PLCN_v1)
- **Nginx + PHP-FPM** (socket-based)
- **Non-root runtime** (`container` user)
- Standard paths:
  - `/home/container/webroot` (your site)
  - `/home/container/tmp` (php-fpm socket)
  - `/home/container/logs` (logs)
- Optional:
  - WordPress install
  - Git clone/pull deploy

---

## 📦 Included Files

```text
.
├─ README.md
├─ Dockerfile
├─ supervisord.conf
├─ nginx/
│  ├─ nginx.conf
│  └─ conf.d/
│     └─ default.conf
├─ webroot/
│  └─ index.php
└─ eggs/
   └─ webhost-nginx-php-berny.json
