<?php

declare(strict_types=1);

use Dominos\Domain\Stock;
use Dominos\Domain\StockIsEmptyException;
use Dominos\Domain\Tile;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    public function testThatATileCanBePulled(): void
    {
        $stock = new Stock();

        $tile = $stock->pullRandomTile();

        self::assertInstanceOf(Tile::class, $tile);
    }

    public function testThat28TilesCanBePulled(): void
    {
        $stock = new Stock();

        for ($i = 0; $i <= 27; ++$i) {
            $tile = $stock->pullRandomTile();
            self::assertInstanceOf(Tile::class, $tile);
        }
    }

    public function testThatExceptionIsThrownWhenTryingToPullATileFromEmptyStock(): void
    {
        $this->expectException(StockIsEmptyException::class);
        $stock = new Stock();

        for ($i = 0; $i <= 29; ++$i) {
            $stock->pullRandomTile();
        }
    }
}
