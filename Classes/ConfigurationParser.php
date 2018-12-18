<?php
namespace Flownative\Beach\Configuration;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

final class ConfigurationParser
{

    /**
     * @param string $yamlSource
     * @return Configuration
     */
    public function parse(string $yamlSource): Configuration
    {
        return new Configuration($yamlSource);
    }
}
