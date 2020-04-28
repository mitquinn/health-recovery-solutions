<?php

namespace Mitquinn\Hrs\Tests\Application\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Controller
 * @package Mitquinn\Hrs\Tests\Application\Controllers
 */
class Controller
{
    public static function response(int $statusCode, array $body): ResponseInterface
    {
        return new Response($statusCode, [], json_encode($body));
    }
}