<?php

namespace Anddye\Lean\Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Slim\Settings;

final class SettingsTest extends TestCase
{
    public function testGetDotNotation(): void
    {
        $settings = new Settings([
            'foo' => [
                'bar' => 'baz',
            ],
        ]);

        $this->assertEquals('baz', $settings->get('foo.bar'));
        $this->assertEquals(null, $settings->get('bar'));
        $this->assertEquals(['bar' => 'baz'], $settings->get('foo'));
    }

    public function testGetWithDefaultValue(): void
    {
        $settings = new Settings();

        $this->assertEquals('baz', $settings->get('foo.bar', 'baz'));
    }

    public function testHasDotNotation(): void
    {
        $settings = new Settings([
            'foo' => [
                'bar' => 'baz',
            ],
        ]);

        $this->assertTrue($settings->has('foo.bar'));
        $this->assertFalse($settings->has('bar'));
    }

    public function testRemoveDotNotation(): void
    {
        $settings = new Settings([
            'foo' => [
                'bar' => 'baz',
                'c' => 'd',
            ],
            'a' => 'b',
        ]);

        $settings->remove('foo.bar');
        $this->assertEquals(['c' => 'd'], $settings->get('foo'));

        $settings->remove('foo');
        $this->assertEquals(['a' => 'b'], $settings->all());
    }

    public function testSetDotNotation(): void
    {
        $settings = new Settings();
        $settings->set('foo.bar', 'baz');

        $this->assertEquals('baz', $settings->get('foo.bar'));
        $this->assertEquals(['bar' => 'baz'], $settings->get('foo'));
    }

    public function testSetWithIncompatibleTypes(): void
    {
        $settings = new Settings([
            'foo' => 'bar',
        ]);

        $this->expectException(RuntimeException::class);
        $settings->set('foo.bar', 'baz');
    }
}
