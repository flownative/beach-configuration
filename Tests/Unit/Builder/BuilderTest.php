<?php
namespace Flownative\Beach\Configuration\Tests\Unit\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Builder\Builder;
use Flownative\Beach\Configuration\Builder\Step;
use Flownative\Beach\Configuration\Configuration;
use Neos\Flow\Tests\UnitTestCase;

class BuilderTest extends UnitTestCase
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
    public function builderAcceptsGitStrategyOptionClone(): void
    {
        self::assertInstanceOf(Builder::class, Configuration::fromYamlSource(
            <<<YAML
builder:
  gitStrategy: clone
YAML
        )->builder());
    }

    /**
     * @test
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545298865
     */
    public function builderRejectsOtherGitStrategyOptions(): void
    {
        self::assertInstanceOf(Builder::class, Configuration::fromYamlSource(
            <<<YAML
builder:
  gitStrategy: none
YAML
        )->builder());
    }

    /**
     * @test
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
     */
    public function stepsReturnsEmptyArrayIfNoStepsWereDefined(): void
    {
        self::assertSame([], Configuration::fromYamlSource(
            <<<YAML
builder:
  steps: []
YAML
        )->builder()->steps());
    }

    /**
     * @test
     * @expectedException \Flownative\Beach\Configuration\Exception\ParseException
     * @expectedExceptionCode 1545299545
     */
    public function parseErrorIfStepsIsNotAnArray(): void
    {
        Configuration::fromYamlSource(
            <<<YAML
builder:
  steps: 'foo'
YAML
        )->builder()->steps();
    }

    /**
     * @test
     * @throws \Flownative\Beach\Configuration\Exception\ParseException
     */
    public function stepsReturnsDefinedSteps(): void
    {
        $steps =         Configuration::fromYamlSource(
            <<<'YAML'
builder:
  steps:
    build-composer:
      type: docker
      image: 'flownative/composer:7.2'
      script: []
    build-assets:
      type: docker
      image: 'flownative/node-build-tools:1'
      script: []      
YAML
        )->builder()->steps();

        self::assertInternalType('array', $steps);
        self::assertCount(2, $steps);

        self::assertInstanceOf(Step::class, $steps[0]);
        self::assertSame('build-composer', (string)$steps[0]->name());
        self::assertSame('docker', (string)$steps[0]->type());

        self::assertInstanceOf(Step::class, $steps[1]);
        self::assertSame('build-assets', (string)$steps[1]->name());
        self::assertSame('docker', (string)$steps[0]->type());
    }
}
