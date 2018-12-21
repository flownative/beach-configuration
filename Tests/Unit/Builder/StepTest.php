<?php
namespace Flownative\Beach\Configuration\Tests\Unit\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Builder\ScriptCommandLine;
use Flownative\Beach\Configuration\Builder\Step;
use Neos\Flow\Tests\UnitTestCase;

class StepTest extends UnitTestCase
{
    /**
     * @return array
     */
    public function validStepNames(): array
    {
        return [
            ['a'],
            ['X'],
            ['build'],
            ['build-composer'],
            ['build_composer'],
            ['UpperCamelCase'],
            ['something-with-numbers-1234567890'],
            ['a-pretty-long-name-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']
        ];
    }

    /**
     * @test
     * @dataProvider validStepNames
     * @param $name
     */
    public function stepAcceptsValidNames($name): void
    {
        $step = Step::fromConfiguration($name, []);
        self::assertSame($name, $step->name());
    }

    /**
     * @return array
     */
    public function invalidStepNames(): array
    {
        return [
            ['ähnlich-aber-nicht-erlaubt'],
            ['-leading-dash'],
            ['trailing-dash-'],
            ['+or-the-like'],
            ['emojies-like-🐼-are-not-allowed'],
            ['a-name-with-more-than-100-characters-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],
            ['a-name-with-a-lot-more-than-100-characters-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']
        ];
    }

    /**
     * @test
     * @dataProvider invalidStepNames
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545301376
     */
    public function stepRejectsInvalidNames($name): void
    {
        $step = Step::fromConfiguration($name, []);
        self::assertSame($name, $step->name());
    }

    /**
     * @test
     */
    public function stepAcceptsTypeDocker(): void
    {
        $step = Step::fromConfiguration('test', ['type' => 'docker']);
        self::assertSame('docker', $step->type());
    }

    /**
     * @test
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545300611
     */
    public function stepRejectsTypesOtherThanDocker(): void
    {
        Step::fromConfiguration('test', ['type' => 'something']);
    }

    /**
     * @return array
     */
    public function validImages(): array
    {
        return [
            ['flownative/php'],
            ['flownative/php:latest'],
            ['flownative/php:7.3'],
            ['flownative/php:7.3.99'],
            ['node:11.4-alpine'],
            ['eu.gcr.io/flownative-beach/php:7.3'],
            ['24.7.foo.com/-my-organization99/99designs'],
        ];
    }

    /**
     * @test
     * @dataProvider validImages
     * @param string $image
     */
    public function stepAcceptsValidImages(string $image): void
    {
        $step = Step::fromConfiguration('test', ['image' => $image]);
        self::assertSame($image, $step->image());
    }

    /**
     * @return array
     */
    public function invalidImages(): array
    {
        return [
            ['flownative/brötli'],
            ['flownative/php:bäste'],
            ['flownative//php:7.3'],
            ['/flownative//php:7.3'],
            ['flownative/php:7.3.99:1'],
            ['-eu.gcr.io/flownative-beach/php:7.3'],
            ['24.7.☠️.com/something/bad'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidImages
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545308567
     * @param string $image
     */
    public function stepRejectsInvalidImages(string $image): void
    {
        $step = Step::fromConfiguration('test', ['image' => $image]);
        self::assertSame($image, $step->image());
    }

    /**
     * @test
     */
    public function scriptReturnsEmptyArrayIfNoScriptWasDefined(): void
    {
        $step = Step::fromConfiguration('test', []);
        self::assertSame([], $step->script());
    }

    /**
     * @test
     */
    public function scriptReturnsArrayOfScriptCommandLines(): void
    {
        $line1 = 'export USERNAME=`whoami`';
        $line2 = 'echo ${USERNAME}';
        $line3 = 'pwd';

        $step = Step::fromConfiguration(
            'test',
            [
                'script' =>
                [
                    $line1,
                    $line2,
                    $line3
                ]
            ]
        );

        $commandLines = $step->script();
        self::assertCount(3, $commandLines);

        self::assertInstanceOf(ScriptCommandLine::class, $commandLines[0]);

        self::assertSame($line1, (string)$commandLines[0]);
        self::assertSame($line2, (string)$commandLines[1]);
        self::assertSame($line3, (string)$commandLines[2]);
    }
}
