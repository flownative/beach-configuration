<?php
namespace Flownative\Beach\Configuration;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Builder\Builder;
use Flownative\Beach\Configuration\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class Configuration
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     */
    private function __construct()
    {
    }

    /**
     * @param string $yamlSource
     * @return Configuration
     * @throws ParseException
     */
    public static function fromYamlSource(string $yamlSource): Configuration
    {
        try {
            $configuration = new Configuration();
            $yaml = Yaml::parse($yamlSource);

            if (!is_array($yaml)) {
                return $configuration;
            }

            foreach ($yaml as $key => $subConfiguration) {
                switch ($key) {
                    case 'builder':
                        $configuration->builder = Builder::fromYaml($subConfiguration);
                    break;
                    default:
                        throw new ParseException(sprintf('Unknown configuration key "%s".', $key), 1545237279);
                }
            }
            return $configuration;
        } catch (\TypeError $error) {
            throw new ParseException($error->getMessage(), 1545238715);
        }
    }

    /**
     * @return Builder
     */
    public function builder(): ?Builder
    {
        return $this->builder;
    }
}
