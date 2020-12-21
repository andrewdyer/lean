<?php

namespace Anddye\Lean\Tests;

use Anddye\Lean\Handlers\Strategies\MethodInjection;
use DateTime;
use League\Container\Container;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

final class MethodInjectionTest extends TestCase
{
    public function testItSupportsMethodInjection(): void
    {
        $container = new Container();
        $strategy = new MethodInjection($container);

        $yesterday = new DateTime('yesterday');
        $container->add(DateTime::class, $yesterday);

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $callable = function (DateTime $day, $foo) use ($yesterday) {
            $this->assertEquals($day, $yesterday);
            $this->assertEquals('bar', $foo);
        };

        $strategy($callable, $request, $response, ['foo' => 'bar']);
    }
}
