<?php
namespace Flownative\Beach\Configuration\Tests\Unit\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

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
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
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
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
     */
    public function stepRejectsInvalidNames($name): void
    {
        $step = Step::fromConfiguration($name, []);
        self::assertSame($name, $step->name());
    }

    /**
     * @test
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
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

}
