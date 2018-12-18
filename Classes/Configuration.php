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
     * @param string $yamlSource
     */
    public function __construct(string $yamlSource)
    {
        $yaml = Yaml::parse($yamlSource);
        $this->builderConfiguration = isset($yaml['builder']) ? new BuilderConfiguration() : null;
    }

    /**
     * @return BuilderConfiguration
     */
    public function builder(): ?BuilderConfiguration
    {
        return $this->builderConfiguration;
    }
}
