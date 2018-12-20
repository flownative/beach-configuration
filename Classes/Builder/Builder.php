<?php
namespace Flownative\Beach\Configuration\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Exception\ParseException;

final class Builder
{
    /**
     * @var array
     */
    private $steps = [];

    /**
     */
    private function __construct()
    {
    }

    /**
     * @param array $configuration
     * @return Builder
     * @throws ParseException
     */
    public static function fromConfiguration(array $configuration): Builder
    {
        $instance = new Builder();
        foreach ($configuration as $key => $subConfiguration) {
            switch ($key) {
                case 'gitStrategy':
                    $instance->setGitStrategy($subConfiguration);
                break;
                case 'steps':
                    $instance->setSteps($subConfiguration);
                break;
                default:
                    throw new ParseException(sprintf('Unknown configuration key "%s".', $key), 1545238579);
            }
        }
        return $instance;
    }

    /**
     * @return Step[]
     */
    public function steps(): array
    {
        return $this->steps;
    }

    /**
     * @param $subConfiguration
     * @throws ParseException
     */
    private function setSteps($subConfiguration): void
    {
        if (!is_array($subConfiguration)) {
            throw new ParseException(sprintf('Invalid builder steps configuration: steps must be an array, "%s" given.', gettype($subConfiguration)), 1545299545);
        }
        foreach ($subConfiguration as $stepName => $stepConfiguration) {
            $this->steps[] = Step::fromConfiguration($stepName, $stepConfiguration);
        }
    }

    /**
     * @param $subConfiguration
     * @throws ParseException
     */
    private function setGitStrategy($subConfiguration): void
    {
        if ($subConfiguration !== 'clone') {
            throw new ParseException(sprintf('Invalid git strategy option "%s" set in builder configuration.', is_string($subConfiguration) ? $subConfiguration : gettype($subConfiguration)), 1545298865);
        }
    }
}
