<?php

/*
|--------------------------------------------------------------------------
| ONE-TIME deployment setup script (FTP-only shared hosting)
|--------------------------------------------------------------------------
|
| Runs `migrate --seed`, `storage:link`, and symlinks the app's real
| public/ assets (build/, storage/, .htaccess, favicon, ...) into this
| directory — so they're reachable at https://.../jurnal/build/... etc.
| without needing shell/SSH access.
|
| Usage:
| 1. Set $secretKey below to a random string.
| 2. Set $appBasePath below (same value as in index.php).
| 3. Upload this file next to index.php (public_html/jurnal/deploy-setup.php).
| 4. Open https://your-domain/jurnal/deploy-setup.php?key=YOUR_SECRET in a browser.
| 5. DELETE this file from the server immediately after it succeeds.
*/

$secretKey = 'CHANGE-ME';
$appBasePath = '/home/USERNAME/journal_app';

if ($secretKey === 'CHANGE-ME' || ($_GET['key'] ?? '') !== $secretKey) {
    http_response_code(403);
    exit('Forbidden. Set $secretKey in this file first, then open this URL with ?key=YOUR_SECRET.');
}

require $appBasePath.'/vendor/autoload.php';

$app = require_once $appBasePath.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/plain; charset=utf-8');

function run_artisan(string $command, array $params = []): void
{
    $exitCode = Illuminate\Support\Facades\Artisan::call($command, $params);
    echo "\$ php artisan {$command}\n";
    echo Illuminate\Support\Facades\Artisan::output();
    echo "(exit code: {$exitCode})\n\n";
}

run_artisan('migrate', ['--seed' => true, '--force' => true]);
run_artisan('storage:link');

echo "Linking public assets into this directory...\n";

$realPublic = $appBasePath.'/public';
$here = __DIR__;

foreach (scandir($realPublic) as $entry) {
    if (in_array($entry, ['.', '..', 'index.php'], true)) {
        continue;
    }

    $target = $realPublic.DIRECTORY_SEPARATOR.$entry;
    $link = $here.DIRECTORY_SEPARATOR.$entry;

    if (file_exists($link) || is_link($link)) {
        echo "  skipped {$entry} (already exists)\n";
        continue;
    }

    if (symlink($target, $link)) {
        echo "  linked {$entry}\n";
    } else {
        echo "  FAILED to link {$entry} — your host may disable symlink(). Copy it manually via FTP instead.\n";
    }
}

echo "\nDone. Now DELETE deploy-setup.php from the server.\n";
