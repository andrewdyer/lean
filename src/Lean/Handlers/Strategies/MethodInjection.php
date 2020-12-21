<?php

namespace Anddye\Lean\Handlers\Strategies;

use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Interfaces\InvocationStrategyInterface;

class MethodInjection implements InvocationStrategyInterface
{
    private $reflectionContainer;

    public function __construct(ContainerInterface $container)
    {
        $this->reflectionContainer = new ReflectionContainer();
        $this->reflectionContainer->setContainer($container);
    }

    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        foreach ($routeArguments as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }

        $this->reflectionContainer->getContainer()->share('request', $request);

        return $this->reflectionContainer->call($callable, $routeArguments);
    }
}
