<?php

/*
|--------------------------------------------------------------------------
| Subfolder entry point (FTP-only shared hosting, e.g. cPanel)
|--------------------------------------------------------------------------
|
| Use this file INSTEAD OF the normal public/index.php when the Laravel
| application lives in a different folder than the one the web server
| exposes (e.g. app in ~/journal_app, exposed at ~/public_html/jurnal).
|
| Upload this file as public_html/jurnal/index.php.
| See README.md > "Subfolder დეპლოი — მხოლოდ FTP" for the full walkthrough.
*/

// EDIT THIS: absolute filesystem path to the Laravel app root — the folder
// that contains "artisan", "app/", "vendor/", ".env" (NOT the public/ folder).
$appBasePath = '/home/USERNAME/journal_app';

$_ENV['APP_BASE_PATH'] = $appBasePath;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = $appBasePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appBasePath.'/vendor/autoload.php';

$app = require_once $appBasePath.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
