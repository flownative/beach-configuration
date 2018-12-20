<?php
namespace Flownative\Beach\Configuration\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Exception\ParseException;

final class ScriptCommandLine
{
    /**
     * @var string
     */
    private $commandLine;

    /**
     * @param string $commandLine
     * @return ScriptCommandLine
     */
    public static function fromString($commandLine): ScriptCommandLine
    {
        $instance = new static;
        $instance->setCommandLine($commandLine);
        return $instance;
    }

    /**
     * @param string $commandLine
     * @throws ParseException
     */
    private function setCommandLine($commandLine): void
    {
        if (!is_string($commandLine)) {
            throw new ParseException('Command line must be a valid string.', 1545316172);
        }
        $commandLine = trim($commandLine);
        if (empty($commandLine)) {
            throw new ParseException('Command line cannot be empty.', 1545316172);
        }
        $this->commandLine = $commandLine;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->commandLine;
    }


}
