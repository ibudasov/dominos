<?php

declare(strict_types=1);

namespace Dominos\Domain;

interface Output
{
    public function println(string $line): void;
}
