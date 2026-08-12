# Fonts

These font files are not bundled in this repository (licensing) and must be added manually:

- `bpg-nino-mtavruli/bpg-nino-mtavruli.woff2` (+ `.woff`) — heading font, matches supremecourt.ge headings.
- `dejavu-sans-condensed/dejavu-sans-condensed.woff2` (+ `.woff`, and `-bold.woff2`/`-bold.woff`) — body font. DejaVu fonts are free/open (Bitstream Vera license) and can be sourced from https://dejavu-fonts.github.io/ and converted to woff2 with a tool such as `fonttools varLib.instancer` / `woff2_compress`, or downloaded pre-converted from Google Fonts' "DejaVu Sans" mirrors.

Until these files are present, `resources/css/app.css` falls back to `Noto Sans Georgian` / the system sans-serif stack, so the site remains fully usable without them.
