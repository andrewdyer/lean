<?php

namespace Anddye\Lean\Tests;

use Anddye\Lean\App;
use Anddye\Lean\Tests\Stubs\ErrorHandler;
use Anddye\Lean\Tests\Stubs\ErrorServiceProvider;
use League\Container\Container;
use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    public function testItConstructsWithoutAContainer(): void
    {
        $app = new App();
        $container = $app->getContainer();
        $this->assertTrue($container->has('request'));
    }

    public function testItDoesNotOverwriteAlreadyRegisteredDefinitions(): void
    {
        $container = new Container();
        $this->assertFalse($container->has('errorHandler'));

        $container->share('errorHandler', function () {
            return new ErrorHandler();
        });

        $app = new App($container);
        $this->assertInstanceOf(ErrorHandler::class, $app->getContainer()->get('errorHandler'));
        $this->assertTrue($app->getContainer()->has('request'));
    }

    public function testItLoadsTheSlimServiceProviderWithACustomContainer(): void
    {
        $container = new Container();
        $app = new App($container);
        $this->assertTrue($container->has('request'));
    }

    public function testItSupportsOverwritingDefaultDefinitions(): void
    {
        $app = new App();
        $container = $app->getContainer();
        $this->assertTrue($container->has('errorHandler'));

        $container->share('errorHandler', function () {
            return new ErrorHandler();
        });

        $this->assertInstanceOf(ErrorHandler::class, $app->getContainer()->get('errorHandler'));
        $this->assertTrue($app->getContainer()->has('request'));
    }

    public function testItSupportsPostInjectedServiceProviders(): void
    {
        $app = new App();
        $app->getContainer()->addServiceProvider(ErrorServiceProvider::class);

        $this->assertInstanceOf(ErrorHandler::class, $app->getContainer()->get('errorHandler'));
        $this->assertTrue($app->getContainer()->has('request'));
    }

    public function testItSupportsPreInjectedServiceProviders(): void
    {
        $container = new Container();
        $container->addServiceProvider(ErrorServiceProvider::class);
        $app = new App($container);

        $this->assertInstanceOf(ErrorHandler::class, $app->getContainer()->get('errorHandler'));
        $this->assertTrue($app->getContainer()->has('request'));
    }
}
