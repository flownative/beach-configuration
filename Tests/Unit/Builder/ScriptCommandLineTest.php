<?php
namespace Flownative\Beach\Configuration\Tests\Unit\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Builder\ScriptCommandLine;
use Neos\Flow\Tests\UnitTestCase;

class ScriptCommandLineTest extends UnitTestCase
{
    /**
     * @return array
     */
    public function invalidCommandLines(): array
    {
        return [
            [''],
            [null],
            [false],
            ['  '],
            [[]],
            [new \stdClass()]
        ];
    }

    /**
     * @param mixed $commandLine
     * @test
     * @dataProvider invalidCommandLines
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545316172
     */
    public function invalidCommandLineIsRejected($commandLine): void
    {
        ScriptCommandLine::fromString($commandLine);
    }
}
