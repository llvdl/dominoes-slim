<?php

namespace Llvdl\Responder;

use JMS\Serializer\Serializer;
use Slim\Http\Stream;
use Slim\Http\Request;
use Slim\Http\Response;

class JsonResponder
{
    /**
     * @var Serializer
    */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param mixed $data
     */
    public function __invoke(Request $request, Response $response, $data)
    {
        $body = new Stream(fopen('php://temp', 'rw+'));
        $body->write($this->serializer->serialize($data, 'json'));

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withBody($body);
    }
}
