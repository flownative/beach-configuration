<?php
namespace Flownative\Beach\Configuration\Builder;

/*
 * This file is part of the Flownative.Beach.Configuration package.
 *
 * (c) Flownative GmbH - www.flownative.com
 */

final class Steps
{
    /**
     * @param array $yaml
     * @return Steps
     */
    public static function fromYaml(array $yaml): Steps
    {
        return new Steps();
    }
}
