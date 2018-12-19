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
     * @var Steps
     */
    private $steps;

    /**
     */
    private function __construct()
    {
    }

    /**
     * @param array $yaml
     * @return Builder
     * @throws ParseException
     */
    public static function fromYaml(array $yaml): Builder
    {
        $instance = new Builder();

        foreach ($yaml as $key => $subConfiguration) {
            switch ($key) {
                case 'steps':
                    $instance->steps= Steps::fromYaml($subConfiguration);
                break;
                default:
                    throw new ParseException(sprintf('Unknown configuration key "%s".', $key), 1545238579);
            }
        }

        return $instance;
    }

    /**
     * @return Steps|null
     */
    public function steps(): ?Steps
    {
        return $this->steps;
    }
}
