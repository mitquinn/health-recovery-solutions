<?php

namespace Mitquinn\Hrs\Tests\Application\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PatientController
 * @package Mitquinn\Hrs\Tests\Application\Controllers
 */
class PatientController extends Controller
{

    /**
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientController',
            'function' => 'index',
            'body' => 'index body'
        ]);
    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function get($id): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientController',
            'function' => 'get',
            'body' => "$id - get body"
        ]);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function create(RequestInterface $request): ResponseInterface
    {
        return static::response(201, [
            'controller' => 'PatientController',
            'function' => 'create',
            'body' => 'create body'
        ]);
    }

    /**
     * @param RequestInterface $request
     * @param $id
     * @return ResponseInterface
     */
    public function update(RequestInterface $request, $id): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientController',
            'function' => 'update',
            'body' => "$id - update body"
        ]);
    }

    /**
     * @param $id
     * @return ResponseInterface
     */
    public function delete($id): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientController',
            'function' => 'delete',
            'body' => "$id - delete body"
        ]);
    }
}