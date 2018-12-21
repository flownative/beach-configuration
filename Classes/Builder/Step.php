<?php
namespace Flownative\Beach\Configuration\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

use Flownative\Beach\Configuration\Exception\ParseException;

final class Step
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $executor = 'docker';

    /**
     * @var string
     */
    private $image;

    /**
     * @var array
     */
    private $script = [];

    /**
     * @param string $name
     * @param array $configuration
     * @return Step
     * @throws ParseException
     */
    public static function fromConfiguration(string $name, array $configuration): Step
    {
        $instance = new static;
        $instance->setName($name);

        foreach ($configuration as $key => $subConfiguration) {
            switch ($key) {
                case 'executor':
                    $instance->setExecutor($subConfiguration);
                break;
                case 'image':
                    $instance->setImage($subConfiguration);
                break;
                case 'script':
                    $instance->setScript($subConfiguration);
                break;
//                default:
//                    throw new ParseException(sprintf('Unknown configuration key "%s".', $key), 1545299869);
            }
        }

        if ($instance->image === null) {
            throw new ParseException(sprintf('No image specified for build step "%s".', $name), 1545385420);
        }

        return $instance;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function executor(): string
    {
        return $this->executor;
    }

    /**
     * @return string
     */
    public function image(): string
    {
        return $this->image;
    }

    /**
     * @return ScriptCommandLine[]
     */
    public function script(): array
    {
        return $this->script;
    }

    /**
     * @param string $name
     * @throws ParseException
     */
    private function setName(string $name): void
    {
        if (preg_match('/^[a-zA-Z]([a-zA-Z0-9_-]{0,98}[a-zA-Z0-9])?$/', $name) !== 1) {
            throw new ParseException(sprintf('Invalid step name "%s" set in builder configuration.', $name), 1545301376);
        }
        $this->name = $name;
    }

    /**
     * @param string $executor
     * @throws ParseException
     */
    private function setExecutor(string $executor): void
    {
        if ($executor !== 'docker') {
            throw new ParseException(sprintf('Invalid step executor option "%s" set in builder configuration.', $executor), 1545300611);
        }
        $this->executor = $executor;
    }

    /**
     * @param string $image
     * @throws ParseException
     */
    private function setImage(string $image): void
    {
        if (preg_match('|^[a-z0-9.]+(/[a-z0-9-]+)*(:[a-z0-9-_.]+)?$|', $image) !== 1) {
            throw new ParseException(sprintf('Invalid step image "%s" set in builder configuration.', $image), 1545308567);
        }
        $this->image = $image;
    }

    /**
     * @param array $subConfiguration
     */
    private function setScript(array $subConfiguration): void
    {
//        if (!is_array($subConfiguration)) {
//            throw new ParseException(sprintf('Invalid builder steps configuration: steps must be an array, "%s" given.', gettype($subConfiguration)), 1545299545);
//        }
        foreach ($subConfiguration as $commandLineString) {
            $this->script[] = ScriptCommandLine::fromString($commandLineString);
        }
    }

}
