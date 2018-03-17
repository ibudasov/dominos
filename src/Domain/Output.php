<?php

declare(strict_types=1);

namespace Dominos\Domain;

interface Output
{
    /**
     * @param string $line
     */
    public function println(string $line): void;
}
