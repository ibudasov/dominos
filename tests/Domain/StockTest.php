<?php

declare(strict_types=1);

use Dominos\Domain\Stock;
use Dominos\Domain\StockIsEmptyException;
use Dominos\Domain\Tile;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    public function testThatATilieCanBeAdded(): void
    {
        $stock = new Stock();
        $tileMock = \Mockery::mock(Tile::class);

        self::assertEquals(1, $stock->addTile($tileMock));
    }

    public function testThatATileCanBePulledWhenPresent(): void
    {
        $stock = new Stock();
        $tileMock = \Mockery::mock(Tile::class);

        self::assertEquals(1, $stock->addTile($tileMock));
        $tile = $stock->pullRandomTile();

        self::assertSame($tileMock, $tile);
    }

    public function testThatExceptionIsThrownWhenTryingToPullATileFromEmptyStock(): void
    {
        $this->expectException(StockIsEmptyException::class);
        $stock = new Stock();

        $stock->pullRandomTile();
    }
}
