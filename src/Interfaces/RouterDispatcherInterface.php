<?php


namespace Mitquinn\Hrs\Interfaces;


use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RouterDispatcherInterface
{

    /**
     * Handles the processing of the request.
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception;
     */
    public function dispatch(RequestInterface $request): ResponseInterface;

}