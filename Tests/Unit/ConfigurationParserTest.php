<?php
namespace Flownative\Beach\Configuration\Tests\Unit;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Builder\Steps;
use Flownative\Beach\Configuration\Builder\Builder;
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
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545237279
     */
    public function configurationRejectsUnknownTopLevelEntries(): void
    {
        Configuration::fromYamlSource(
            <<<YAML
something: []
builder: []
YAML
        );
    }

    /**
     * @test
     */
    public function builderReturnsBuilderConfigurationObject(): void
    {
        self::assertInstanceOf(Builder::class, Configuration::fromYamlSource(
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

    /**
     * @test
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
     */
    public function stepsReturnsBuildSteps(): void
    {
        self::assertInstanceOf(Steps::class, Configuration::fromYamlSource(
            <<<YAML
builder:
  steps: []
YAML
        )->builder()->steps());
    }

    /**
     * @test
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
     */
    public function stepsReturnsNullIfNoBuildStepsWereSpecified(): void
    {
        self::assertNull(Configuration::fromYamlSource(
            <<<YAML
builder: []
YAML
        )->builder()->steps());
    }
}
