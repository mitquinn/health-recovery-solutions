<?php

namespace Mitquinn\Hrs\Tests\Application\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PatientMetricController
 * @package Mitquinn\Hrs\Tests\Application\Controllers
 */
class PatientMetricController extends Controller
{
    /**
     * @return ResponseInterface
     */
    public function index(): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientMetricController',
            'function' => 'index',
            'body' => 'index body'
        ]);
    }

    /**
     * @param $patientId
     * @param $metricId
     * @return ResponseInterface
     */
    public function get($patientId, $metricId): ResponseInterface
    {
        return static::response(200, [
            'controller' => 'PatientMetricController',
            'function' => 'get',
            'body' => [
                'patientId' => $patientId,
                'metricId' => $metricId
            ]
        ]);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function create(RequestInterface $request): ResponseInterface
    {
        return static::response(201, [
            'controller' => 'PatientMetricController',
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
            'controller' => 'PatientMetricController',
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
            'controller' => 'PatientMetricController',
            'function' => 'delete',
            'body' => "$id - delete body"
        ]);
    }
}