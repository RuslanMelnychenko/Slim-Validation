<?php


namespace DavidePastore\Slim\Validation;

use Slim\Http\Response;

class ValidationParams extends \DavidePastore\Slim\Validation\Validation
{
    public function __invoke($request, $handler)
    {
        $this->errors = [];
        $params = $request->getParams();
        $params = array_merge((array) $request->getAttribute('routeInfo')[2], $params);
        $this->validate($params, $this->validators);

        if ($this->hasErrors()) {
            $response = new Response(new \Slim\Psr7\Response(), new \Slim\Psr7\Factory\StreamFactory());
            return $response->withJson(['params' => $this->getErrors()], 400);
        }
        return $handler->handle($request);
    }
}