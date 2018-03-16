<?php

declare(strict_types=1);

use Dominos\Domain\Tile;
use PHPUnit\Framework\TestCase;

class TileTest extends TestCase
{
    public function testThatTileCanBeCreated(): void
    {
        $tile = new Tile(1, 2);

        self::assertEquals(1, $tile->getFirstValue());
        self::assertEquals(2, $tile->getSecondValue());
    }

    public function testThatTileCanMatchANumber(): void
    {
        $tile = new Tile(1, 2);

        self::assertTrue($tile->isMatching(1));
    }
}
