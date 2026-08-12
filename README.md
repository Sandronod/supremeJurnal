# Justice and Law — მართლმსაჯულება და კანონი

სამართლებრივი ჟურნალის დამოუკიდებელი Laravel 9 აპლიკაცია (ISSN 1512-259X). მთავარი საიტიდან (supremecourt.ge) ამ აპლიკაციაზე უბრალო ბმულით მოხდება გადასვლა.

## ტექ სტეკი

- **Laravel 9.x**, PHP `^8.0.2` — production სერვერზე გაშვებულია PHP **8.0.30**, ამიტომ `composer.json`-ის `config.platform.php` მითითებულია `8.0.30`-ზე, რომ dependency resolution ყოველთვის production-თან თავსებად ვერსიებს ირჩევდეს, მაშინაც კი, თუ ლოკალურ მანქანაზე უფრო ახალი PHP დგას.
- **MySQL** production-ზე. ლოკალურად, თუ MySQL სერვერი ხელმისაწვდომი არაა, გამოიყენება **SQLite** fallback-ად (იხ. ქვემოთ).
- **Blade + Tailwind CSS** (Vite-ით ბანდლირებული), **Alpine.js** მსუბუქი ინტერაქციისთვის (dropdown მენიუ, mobile nav).
- **Trix** rich-text რედაქტორი — გვერდების (Pages) ტექსტის რედაქტირებისთვის admin პანელში.
- ხელით აწყობილი, მარტივი **Blade-based admin პანელი** (არა Filament/Nova — ისინი PHP 8.1+-ს მოითხოვენ).
- ლოკალიზაცია: Laravel-ის ჩაშენებული lang სისტემა, სესიაზე დაფუძნებული GEO/ENG გადამრთველი (`/lang/{locale}`).

## მონაცემთა მოდელი

- `pages` — 5 ფიქსირებული სტატიკური გვერდი (`about`, `aims-scope`, `review-ethics`, `editorial-board`, `for-authors`), თითოეული ორ ენაზე, Trix-ით რედაქტირებადი.
- `settings` — singleton ცხრილი (ერთი row): საიტის სახელი, ISSN, საავტორო უფლების ტექსტი, საკონტაქტო ინფო, რუკის embed URL.
- `issues` — ჟურნალის ნომრები (წელი, ნომერი, PDF, გამოქვეყნების თარიღი, `is_current` flag).
- `articles` — სტატიები, თითოეული ეკუთვნის კონკრეტულ `issue`-ს, საკუთარი slug/URL, PDF.

## ლოკალური გაშვება

```bash
composer install
npm install

cp .env.example .env   # უკვე მზადაა repo-ში .env ლოკალური SQLite კონფიგით
php artisan key:generate   # საჭიროების შემთხვევაში

php artisan migrate --seed
php artisan storage:link

npm run dev      # Vite dev server (ცალკე ტერმინალში), ან npm run build ერთჯერადი build-ისთვის
php artisan serve
```

საიტი ხელმისაწვდომი იქნება `http://127.0.0.1:8000`-ზე, ადმინ პანელი — `http://127.0.0.1:8000/admin`.

### ლოკალური DB: SQLite fallback

Repo-ში მოცემული `.env` იყენებს SQLite-ს (`database/database.sqlite`), რადგან ლოკალურ dev მანქანაზე MySQL სერვერი შეიძლება ხელმისაწვდომი არ იყოს. Migrations/Eloquent კოდი ორივე დრაივერთან უცვლელად მუშაობს. Თუ გინდათ ლოკალურადაც MySQL-ის გამოყენება, უბრალოდ შეცვალეთ `.env`-ში `DB_CONNECTION=mysql` და შესაბამისი `DB_HOST`/`DB_DATABASE`/`DB_USERNAME`/`DB_PASSWORD`.

### Admin ანგარიში

საწყისი admin მომხმარებელი იქმნება `database/seeders/AdminUserSeeder.php`-ის მიერ, `.env`-ში მითითებული `ADMIN_EMAIL`/`ADMIN_PASSWORD` მნიშვნელობებით (default: `admin@example.com` / `password`). **Production-ზე გაშვებამდე აუცილებლად შეცვალეთ ეს მნიშვნელობები** `.env`-ში seed-ის გაშვებამდე, ან შეცვალეთ პაროლი პირველივე შესვლის შემდეგ პირდაპირ ბაზაში/tinker-ით.

## Production დეპლოი

1. **გარემო**: უმარტივესია ცალკე subdomain ან domain (მაგ. `journal.supremecourt.ge`) — მაშინ APP_URL-ის/asset-ების კონფიგურაცია დამატებით ყურადღებას არ საჭიროებს. `/jurnal`-ის მსგავს subfolder-შიც შესაძლებელია დაყენება (იხ. „Subfolder დეპლოი (Apache)" ქვემოთ), უბრალოდ რამდენიმე დამატებითი `.env`/web-server კონფიგია საჭირო.
2. სერვერზე დარწმუნდით რომ არის PHP **8.0.30** საჭირო extension-ებით (`pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`).
3. `.env` production სერვერზე — დააკოპირეთ `.env.example` და შეავსეთ:
   - `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` — რეალური მისამართით.
   - `DB_CONNECTION=mysql` + `DB_HOST`/`DB_DATABASE`/`DB_USERNAME`/`DB_PASSWORD` — production MySQL კრედენშალები.
   - `ADMIN_EMAIL`/`ADMIN_PASSWORD` — production-ის ადმინის საწყისი კრედენშალები (შეცვალეთ პირველი შესვლის შემდეგ).
   - `APP_KEY` — გენერირდება `php artisan key:generate`-ით (არასდროს გამოიყენოთ dev-ის key production-ზე).
4. დამოკიდებულებები და build:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install && npm run build
   ```
5. ბაზა და storage:
   ```bash
   php artisan migrate --seed --force
   php artisan storage:link
   ```
6. Queue/cache ცალკე worker არ სჭირდება — საიტი საკმარისად მარტივია (`QUEUE_CONNECTION=sync`, `CACHE_DRIVER=file` საკმარისია).
7. **ფონტები**: `public/fonts/` დირექტორია ცარიელია ლიცენზიის გამო — იხ. `public/fonts/README.md`. `BPG Nino Mtavruli` და `DejaVu Sans Condensed` ფაილები ხელით უნდა დაემატოს (`.woff2`/`.woff`), წინააღმდეგ შემთხვევაში საიტი გადადის fallback ფონტებზე (Noto Sans Georgian / სისტემური sans-serif) — საიტი მაინც სრულად მუშაობს, უბრალოდ ტიპოგრაფია არ ემთხვევა 100%-ით მთავარ საიტს, სანამ ფონტები არ დაემატება.
8. მთავარ საიტზე (supremecourt.ge) დაამატეთ ბმული ახალ URL-ზე ჟურნალის სექციის ნაცვლად.

## Subfolder დეპლოი — მაგ. supremecourt.ge/journal

ყველა ვარიანტში საერთო წესი: `.env`-ს, `app/`-ს, `vendor/`-ს (DB პაროლების და `APP_KEY`-ის ჩათვლით) — web server-მა პირდაპირ (ფაილის სახით) არ უნდა დააბრუნოს ვინმეს მოთხოვნაზე. `dot`-ფაილის „დამალულობას" web server-თან კავშირი არა აქვს — Apache ამას ჩვეულებრივ ფაილად აბრუნებს, თუ ვინმემ ზუსტი მისამართი იცის.

### ვარიანტი C — მთელი აპლიკაცია ერთად, `.htaccess` internal rewrite-ით (მუშაობს დადასტურებულია)

ეს გამოსადეგია, როცა მთავარი საიტიც Laravel-ია (`public_html/<main-app>/public`) და თქვენ მხოლოდ FTP/cPanel წვდომა გაქვთ (არც subdomain-ის შექმნის უფლება, არც Apache vhost-ზე წვდომა). მთელი journal-ის პროექტი (თავისი `public/`-ის ჩათვლით, ცვლილებების გარეშე) იტვირთება `public_html/journal/`-ში, `public_html`-ის საერთო `.htaccess`-ი კი შიგნიდან (არა ბრაუზერისთვის ხილულად) მიმართავს მოთხოვნებს სწორ ადგილას:

1. **`public_html/journal/`** — ატვირთეთ მთელი journal-ის პროექტი უცვლელად (`app/`, `.env`, `vendor/`, `public/` — ყველაფერი ერთად, ისე როგორც ლოკალურადაა).

2. **`public_html/.htaccess`** (root, საერთო მთავარი საიტისთვისაც) — დაამატეთ journal-ის წესები **მთავარი საიტის catch-all rewrite-მდე** (რიგითობა მნიშვნელოვანია):
   ```apache
   RewriteEngine On

   RewriteCond %{HTTPS} off
   RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

   # JOURNAL ROOT
   RewriteRule ^journal/?$ journal/public/index.php [L]

   # JOURNAL FILES / ROUTES
   RewriteRule ^journal/(.*)$ journal/public/$1 [L]

   # MAIN SITE (თქვენი უკვე არსებული წესი)
   RewriteRule ^(.*)$ <main-app>/public/$1 [L]
   ```

3. **`journal/.env`**:
   ```
   APP_URL=https://supremecourt.ge/journal
   ASSET_URL="${APP_URL}"
   SESSION_PATH=/journal
   ROUTE_PREFIX=journal
   ```
   **`ROUTE_PREFIX` აუცილებელია** — `.htaccess`-ის internal rewrite-ის გამო PHP-ის `SCRIPT_NAME` იცვლება, მაგრამ `REQUEST_URI` ინარჩუნებს ორიგინალ `/journal/...`-ს, და Laravel ვერ აცნობიერებს ავტომატურად რომ `/journal` პრეფიქსი route-მატჩინგისას მოაცილოს. `ROUTE_PREFIX=journal` (`config/app.php` → `route_prefix`, `routes/web.php`-ში გამოყენებული) აიძულებს ყველა route-ს `/journal`-ით დარეგისტრირდეს, რაც ზუსტად ემთხვევა რასაც Laravel რეალურად იღებს. ლოკალურ/testing გარემოში ეს env ცვლადი ცარიელია და არაფერზე გავლენას არ ახდენს.

4. **ტერმინალიდან** (თუ გაქვთ SSH/Terminal წვდომა cPanel-ში):
   ```bash
   cd ~/public_html/journal
   php artisan migrate --seed --force
   php artisan storage:link
   ```
   (თუ Terminal არ გაქვთ, იხ. ვარიანტი B-ს "ერთჯერადი setup" ნაწილი — იგივე ტექნიკა აქაც გამოსადეგია, `deploy/subfolder-ftp/deploy-setup.php`-ს `$appBasePath`-ს უბრალოდ `journal/`-ის ზუსტ მისამართზე მიუთითებთ.)

### ვარიანტი A — თუ გაქვთ წვდომა Apache vhost/`httpd.conf`-ზე

1. **Codebase** განათავსეთ სერვერზე ცალკე დირექტორიაში, მთავარი საიტის docroot-ის **გარეთ** (მაგ. `/var/www/journal`, არა `/var/www/main-site/jurnal`) — მხოლოდ `public/` ქვედირექტორია უნდა იყოს web-ით ხელმისაწვდომი.

2. მთავარი საიტის Apache vhost-ში (ან `httpd.conf`-ში) დაამატეთ:
   ```apache
   Alias /jurnal "/var/www/journal/public"
   <Directory "/var/www/journal/public">
       Options -Indexes +FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>
   ```
   `AllowOverride All` აუცილებელია, რომ Laravel-ის `public/.htaccess`-ის (mod_rewrite) წესები გამოიყენებოდეს.

3. ჟურნალის `.env`-ში:
   ```
   APP_URL=https://supremecourt.ge/jurnal
   ASSET_URL="${APP_URL}"
   SESSION_PATH=/jurnal
   ```

4. `php artisan storage:link` ჩვეულებრივად — Alias-ის მეშვეობით ავტომატურად ხელმისაწვდომი გახდება `/jurnal/storage/...`-ზეც.

### ვარიანტი B — მხოლოდ FTP/cPanel (Apache config-ზე/SSH-ზე წვდომის გარეშე)

`Alias` არის `mod_alias`-ის დირექტივა და მხოლოდ vhost/server config დონეზე მუშაობს — `.htaccess`-იდან ვერ გამოიყენება. ამიტომ საჭიროა ხელით გაყოფა ორ ნაწილად, FTP-ის საშუალებით:

**საწყისი წყობა** (მაგ. cPanel-ის home დირექტორიაში):
```
/home/USERNAME/
├── public_html/
│   └── jurnal/              ← მხოლოდ ეს ხდება web-ით ხელმისაწვდომი
└── journal_app/             ← მთელი დანარჩენი Laravel აპლიკაცია (app/, .env, vendor/, database/, ...)
```

1. **`journal_app/`** — ატვირთეთ მთელი პროექტი (გარდა `node_modules/`-ისა და ლოკალური `database/database.sqlite`-ისა) `public_html`-ის **გარეთ**, სახელით `journal_app` (ან სხვა სახელით — უბრალოდ ეს გზა უნდა გამოიყენოთ ქვემოთ ყველგან). დარწმუნდით, რომ `npm run build` უკვე ლოკალურად გაშვებულია და `journal_app/public/build/` დაბილდილი მოდის ატვირთვასთან ერთად (production სერვერს Node არ სჭირდება).

2. **`public_html/jurnal/index.php`** — ატვირთეთ `deploy/subfolder-ftp/index.php` ამ repo-დან (ჩვეულებრივი `public/index.php`-ის ნაცვლად). გახსენით და შეცვალეთ ერთადერთი ხაზი:
   ```php
   $appBasePath = '/home/USERNAME/journal_app';
   ```
   ზუსტი აბსოლუტური path მიუთითეთ (cPanel-ის File Manager-ში ჩანს, ან hosting-ის დოკუმენტაციაში).

3. **`.env`** (`journal_app/.env`-ში):
   ```
   APP_URL=https://supremecourt.ge/jurnal
   ASSET_URL="${APP_URL}"
   SESSION_PATH=/jurnal
   ```

4. **ერთჯერადი setup** (migrate/seed/storage-link — SSH-ის გარეშე):
   - ატვირთეთ `deploy/subfolder-ftp/deploy-setup.php` დროებით `public_html/jurnal/`-ში.
   - გახსენით ფაილი, შეცვალეთ `$secretKey` (რაიმე შემთხვევითი სტრიქონი) და `$appBasePath` (იგივე მნიშვნელობა რაც `index.php`-ში).
   - ბრაუზერში გახსენით `https://supremecourt.ge/jurnal/deploy-setup.php?key=თქვენი_secretKey` — ეს გაუშვებს migrations/seed-ს, `storage:link`-ს, და symlink-ით დაუკავშირებს `journal_app/public/`-ის ყველა სტატიკურ ფაილს (`build/`, `storage`, `.htaccess`, `favicon.ico`, `robots.txt`) `public_html/jurnal/`-თან — ასე რომ ბრაუზერს პირდაპირ შეუძლია მათი წამოღება, Laravel-ის გავლის გარეშე.
   - **წარმატების შემდეგ დაუყოვნებლივ წაშალეთ `deploy-setup.php`** სერვერიდან FTP-ით.

ამ მიდგომით `.env`/`app/`/`vendor/` ფიზიკურადაც არასდროს ხვდება `public_html`-ში — მხოლოდ `index.php` და symlink-ები (რომლებიც უსაფრთხოდ მიუთითებენ `journal_app/public/`-ის კონკრეტულ ფაილებზე, არა მთელ აპლიკაციაზე).

5. **გადამოწმეთ deploy-ის შემდეგ**: თუ მთავარი საიტი თავადაც იყენებს mod_rewrite-ს root `.htaccess`-ში (მაგ. CMS-ია), დარწმუნდით, რომ მისი წესები `/jurnal`-ს არ იჭერს Alias-მდე მისვლისას — უმეტეს შემთხვევებში (`RewriteCond %{REQUEST_FILENAME} !-d`-ის მსგავსი პირობებით) კონფლიქტი არ იქმნება, რადგან `/jurnal` რეალურ დირექტორიას წარმოადგენს, მაგრამ კონკრეტული CMS-ის მიხედვით შეიძლება დაზუსტება დასჭირდეს.

## ტესტები

```bash
php artisan test
```

მოცავს: საჯარო გვერდების (200 OK), ძებნის, ენის გადართვის, admin-ის login/auth-guard-ის, გვერდის რედაქტირების, ნომრისა და სტატიის შექმნა/PDF ატვირთვა/"მიმდინარედ დაყენება"/წაშლის ტესტებს. Feature ტესტები დამოუკიდებელ in-memory SQLite ბაზაზე გაქვთ (`phpunit.xml`), ლოკალურ dev DB-ს არ ეხება.

## პროექტის სტრუქტურა (მოკლედ)

```
app/Http/Controllers/           საჯარო კონტროლერები (Page, Issue, Article, Search, Contact, Locale)
app/Http/Controllers/Admin/     admin პანელის კონტროლერები
app/Models/                     Page, Setting, Issue, Article, User
database/migrations/            pages, settings, issues, articles
database/seeders/                5 გვერდი, ერთი settings row, admin მომხმარებელი
resources/views/                 საჯარო Blade views + layouts/public.blade.php
resources/views/admin/           admin Blade views + layouts/admin.blade.php
resources/css/app.css            Tailwind + ფონტების @font-face + საჯარო საიტის სტილები
resources/css/admin.css          Trix editor-ის სტილები (მხოლოდ admin-ში იტვირთება)
routes/web.php                   საჯარო + admin routes
routes/auth.php                  მხოლოდ admin login/logout
```
