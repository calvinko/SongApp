<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../src/settings.php';
$settings($containerBuilder);

// Set up dependencies
//$dependencies = require __DIR__ . '/../src/dependencies.php';
//$dependencies($containerBuilder);
// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

$app->setBasePath('/songapp/api');

$app->get('/debug/settings', function(Request $request, Response $response) {
    $s = $this->get('settings');
    $response->getBody()->write(json_encode($s));
    return $response;
});

// Register routes
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);

$app->run();
