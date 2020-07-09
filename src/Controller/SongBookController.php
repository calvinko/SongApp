<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

define('DB_NAME', 'songdb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'calvin98');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');


class SongBookController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $settings;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;

    protected $mysqli;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->settings = $container->get("settings");
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
        $bookid = $args['bookid'];
        if (array_key_exists('songnum', $args)) {
            $songnum = $args['songnum'];
            if ($songnum == "index") {
                $dstr = json_encode($this->dbGetBookIndex($bookid));
            } else {
                $dstr = json_encode($this->dbGetSong($bookid, $songnum));
            }
            $response->getBody()->write($dstr);
        } else {
            $dstr = json_encode($this->dbGetBook($bookid));
            $response->getBody()->write($dstr);
        }

        return $response;
    }

    protected function initDB() {
        //$this->mysqli = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $db = $this->settings['db'];
        $this->mysqli = new \mysqli($db['host'], $db['user'], $db['pass'], $db['dbname']);
        $this->mysqli->query("SET NAMES 'utf8'");
    }

    public function getBooks(Request $request, Response $response, array $args) : Response
    {
        $s = json_encode($this->dbGetBooks());
        $response->getBody()->write($s);
        return $response;
    }

    protected function dbGetBooks(): array
    {
        $this->initDB();
        $result = $this->mysqli->query("SELECT bookid,name,attribute FROM booktbl");
        $rows = array();
        if ($result) {
            while ( ($row = $result->fetch_assoc()) != NULL) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    protected function dbGetBook($bookid): array
    {
        $this->initDB();
        $result = $this->mysqli->query("SELECT * FROM songbooktext WHERE bookid=$bookid");
        $rows = array();
        if ($result) {
            while ( ($row = $result->fetch_assoc()) != NULL) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    protected function dbGetBookIndex($bookid): array
    {
        $this->initDB();
        $result = $this->mysqli->query("SELECT bookid,songnum,pagenum,songname FROM songbooktext WHERE bookid=$bookid");
        $rows = array();
        if ($result)
        {
            while ( ($row = $result->fetch_assoc()) != NULL) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    protected function dbGetSong($bookid, $snum): array
    {
        $this->initDB();
        $result = $this->mysqli->query("SELECT * FROM songbooktext WHERE bookid=$bookid and songnum=$snum");
        $rows = array();
        if ($result) {
            while ( ($row = $result->fetch_assoc()) != NULL) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
}