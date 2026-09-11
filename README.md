# PES Power theme

Sage 11 theme for the **Progressive Electrical Services Inc.** marketing site.

This repository is **the theme only**. WordPress core, Bedrock, and plugins live on each
machine (local and production) and are not tracked here. Site logic belongs in this
theme — Blade, PHP in `app/`, SCSS, and ACF field groups in `acf-json/` — not in a
must-use plugin.

## Local

Bedrock is already parked beside this theme at the PES web project root
(`pes-web/`), served at [http://pes-web.test](http://pes-web.test). From this
directory:

```bash
nvm use            # 22
unset NODE_OPTIONS # if your shell sets --openssl-legacy-provider
composer install
npm install
npm run dev        # Vite HMR
npm run build      # production assets
```

Activate the `pes` theme in WP Admin. Plugins (ACF Pro, HTML Forms) are installed
in Bedrock, not in this repo.

## Production deploy

Production is also Bedrock. Clone or pull this theme into `web/app/themes/pes`:

```bash
cd web/app/themes/pes
git pull origin main
composer install --no-dev
npm ci && npm run build
```

WordPress core and plugins are updated from WP Admin, not from this repo.

## Stack

- Sage 11.1, Blade, Vite
- Custom SCSS (no Tailwind) in `resources/css/`
- ACF field groups saved as JSON in `acf-json/`
