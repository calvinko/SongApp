<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

if (!defined('API_BASE')) {
    define('API_BASE', dirname(__DIR__));
}

define('APP_CONFIG', API_BASE . '/conf/server.ini');

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object

    $defaultSettings = [
            'displayErrorDetails' => true, // Should be set to false in production,
            'displaySettings' => true,     // Should be set of false in production,
            'logger' => [
                'name' => 'bclogger',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'host' => 'localhost',
                'port' => 3306,
                'dbname' => 'biblcircle',
                'user' => 'bcircle',
                'pass' => 'bcirclepass'
            ],
            'configfile' => APP_CONFIG
    ];

    $settings = $defaultSettings;

    if (file_exists(APP_CONFIG)) {
        $config = parse_ini_file(APP_CONFIG, true);
        if (is_array($config)) {
            if (isset($config['database']) && is_array($config['database'])) {
                foreach ($config['database'] as $key => $val) {
                    $settings['db'][$key] = $val;
                }
            }

            if (isset($config['logging']) && (is_array($config['logging']))) {
                if (isset($config['logging']['path']))
                    $settings['logger']['path'] = str_replace('API_BASE', API_BASE, $config['logging']['path']);
                if (isset($config['logging']['level'] ))
                    $settings['logger']['level'] = $config['logging']['level'];
            }
        }
    }
    $containerBuilder->addDefinitions([
        'settings' => $settings
    ]);
};