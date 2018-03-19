<?php

declare(strict_types=1);

namespace Dominos\Infrastructure;

use Dominos\Application\Output;

/**
 * @codeCoverageIgnore -- infrastructure level is not meant to be tested
 */
class ConsoleOutput implements Output
{
    /**
     * @param string $line
     */
    public function println(string $line): void
    {
        echo $line.PHP_EOL;
    }
}
