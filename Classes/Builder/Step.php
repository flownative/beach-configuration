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
    private $type;

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
                case 'type':
                    $instance->setType($subConfiguration);
                break;
//                default:
//                    throw new ParseException(sprintf('Unknown configuration key "%s".', $key), 1545299869);
            }
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

    public function type(): string
    {
        return $this->type;
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
     * @param string $type
     * @throws ParseException
     */
    private function setType(string $type): void
    {
        if ($type !== 'docker') {
            throw new ParseException(sprintf('Invalid step type option "%s" set in builder configuration.', $type), 1545300611);
        }
        $this->type = $type;
    }
}
