<?php

namespace Llvdl\Responder;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Stream;
use Slim\Http\Request;
use Slim\Http\Response;

class JsonNotFoundResponder
{
    /**
     * @param Request $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response) : ResponseInterface
    {
        $body = new Stream(fopen('php://temp', 'rw+'));
        $body->write(json_encode(['error' => 'Resource not found']));

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(404)
            ->withBody($body);
    }
}
