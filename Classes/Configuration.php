<?php
namespace Flownative\Beach\Configuration;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Symfony\Component\Yaml\Yaml;

final class Configuration
{
    /**
     * @var BuilderConfiguration
     */
    private $builderConfiguration;

    /**
     */
    private function __construct()
    {
    }

    /**
     * @param string $yamlSource
     * @return Configuration
     */
    public static function fromYamlSource(string $yamlSource): Configuration
    {
        $configuration = new Configuration();
        $yaml = Yaml::parse($yamlSource);
        $configuration->builderConfiguration = isset($yaml['builder']) ? new BuilderConfiguration() : null;
        return $configuration;
    }

    /**
     * @return BuilderConfiguration
     */
    public function builder(): ?BuilderConfiguration
    {
        return $this->builderConfiguration;
    }
}
