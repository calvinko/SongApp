<?php
declare(strict_types=1);

use App\SongBookController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/book', function (Request $request, Response $response) {
        $response->getBody()->write('Get Book!');
        return $response;
    });

    $app->get('/{bookid}/[{songnum}]', 'SongBookController');

};