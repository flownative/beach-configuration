<?php
namespace Flownative\Beach\Configuration\Tests\Unit;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\BuilderConfiguration;
use Flownative\Beach\Configuration\Configuration;
use Neos\Flow\Tests\UnitTestCase;

class ConfigurationParserTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createFromYamlSourceReturnsConfigurationObject(): void
    {
        self::assertInstanceOf(Configuration::class, Configuration::fromYamlSource(''));
    }

    /**
     * @test
     */
    public function builderReturnsBuilderConfigurationObject(): void
    {
        self::assertInstanceOf(BuilderConfiguration::class, Configuration::fromYamlSource(
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
        self::assertNull(Configuration::fromYamlSource('')->builder());
    }
}
