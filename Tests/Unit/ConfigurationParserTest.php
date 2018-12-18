<?php
namespace Flownative\Beach\Configuration\Tests\Unit;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\BuilderConfiguration;
use Flownative\Beach\Configuration\Configuration;
use Flownative\Beach\Configuration\ConfigurationParser;
use Neos\Flow\Tests\UnitTestCase;

class ConfigurationParserTest extends UnitTestCase
{
    /**
     * @test
     */
    public function parseReturnsConfigurationObject(): void
    {
        $parser = new ConfigurationParser();
        self::assertInstanceOf(Configuration::class, $parser->parse(''));
    }

    /**
     * @test
     */
    public function builderReturnsBuilderConfigurationObject(): void
    {
        $parser = new ConfigurationParser();
        self::assertInstanceOf(BuilderConfiguration::class, $parser->parse(
<<<YAML
builder: []
YAML
        )->builder());
    }

    /**
     * @test
     */
    public function builderReturnsNullIfNoBuilderConfigurationWasSpecified(): void
    {
        $parser = new ConfigurationParser();
        self::assertNull($parser->parse('')->builder());
    }
}
