<?php

namespace Anddye\Lean;

use Anddye\Lean\Definition\DefinitionAggregateBuilder;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Slim\App as Slim;

class App extends Slim
{
    public function __construct(Container $container = null)
    {
        $container = $container ?: new Container();
        $container->delegate(new Container(DefinitionAggregateBuilder::build($container)));
        $container->delegate(new ReflectionContainer());

        parent::__construct($container);
    }

    public function getContainer(): Container
    {
        return parent::getContainer();
    }
}
