# Fonts

- `dejavu-sans-condensed/dejavu-sans-condensed.ttf` + `dejavu-sans-condensed-bold.ttf` — body font. Free/open (Bitstream Vera license), sourced from the official DejaVu Fonts release (dejavu-fonts-ttf-2.37) at https://github.com/dejavu-fonts/dejavu-fonts/releases. Included as-is.
- `bpg-nino-mtavruli/bpg-nino-mtavruli.otf` — heading font, matches supremecourt.ge headings. **Not bundled** (licensing) — must be added manually; `resources/css/app.css` references it as an `.otf` file directly (no woff/woff2 conversion needed, modern browsers load opentype/truetype fonts directly via `@font-face`).

Until the BPG file is present, headings fall back to the system sans-serif stack, so the site remains fully usable without it.
