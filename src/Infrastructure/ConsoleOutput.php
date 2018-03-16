<?php

declare(strict_types=1);

namespace Dominos\Infrastructure;

/**
 * @codeCoverageIgnore -- infrastructure level is not meant to be tested
 */
class ConsoleOutput implements \Dominos\Domain\Output
{
    /**
     * @param string $line
     */
    public function println(string $line): void
    {
        echo $line.PHP_EOL;
    }
}
