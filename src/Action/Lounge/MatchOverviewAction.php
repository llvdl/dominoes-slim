<?php

namespace Llvdl\Action\Lounge;

use Llvdl\View\ViewInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class MatchOverviewAction
{
    public function __invoke(
        Request $request,
        Response $response,
        ViewInterface $view
    ) : ResponseInterface {
        return $response->write($view->render('Lounge/matchOverview.phtml'));
    }
}
