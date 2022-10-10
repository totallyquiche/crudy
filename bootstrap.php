<?php

declare(strict_types=1);

namespace App;

use App\Factories\ConfigFactory;
use App\Database\Connectors\Factories\DatabaseConnectorFactory;
use App\Routers\HttpRouter;
use App\Routers\CliRouter;
use App\Views\Renderers\TemplateRenderer;
use App\Views\Renderers\CliRenderer;

require_once(__DIR__ . '/autoload.php');

$config = ConfigFactory::create(file($config_file_path));
$db_driver = $config->get('DB_DRIVER');

if ($db_driver) {
    $database_connector = DatabaseConnectorFactory::create(
        $db_driver,
        $config->get('MYSQL_DB_HOST'),
        $config->get('MYSQL_DB_NAME'),
        $config->get('MYSQL_DB_PORT'),
        $config->get('MYSQL_DB_USERNAME'),
        $config->get('MYSQL_DB_PASSWORD'),
        $config->get('SQLITE_DB_NAME')
    );
}

if (isset($_SERVER['REQUEST_URI'])) {
    require_once(__DIR__ . '/App/Routes/http.php');

    $template_renderer = new TemplateRenderer(
        $config->get('SITE_TITLE'),
        $config->get('SITE_URL'),
        intval($config->get('VIEW_CACHE_SECONDS_TO_EXPIRY'))
    );

    $router = new HttpRouter(
        $routes,
        $_SERVER['REQUEST_URI'],
        $template_renderer
    );
} else {
    require_once(__DIR__ . '/App/Routes/cli.php');

    $cli_renderer = new CliRenderer;

    $router = new CliRouter(
        $routes,
        $argv[1] ?? '',
        $cli_renderer
    );
}

$app = new App(
    $config,
    $router,
    $database_connector ?? null
);

echo $app->run();