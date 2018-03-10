<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dominos\Domain\Player;
use Dominos\Domain\Tile;
use Dominos\Domain\Stock;

class PlayerTest extends TestCase
{
    public function testThatAPlayerCanTakeATile(): void
    {
        $player = new Player();

        $tileMock = \Mockery::mock(Tile::class);
        self::assertEquals(1, $player->pullTile($tileMock));
        self::assertEquals(2, $player->pullTile($tileMock));
    }

    public function testThatUserCanPull7TilesFromStock(): void
    {
        $player = new Player();

        $stockMock = \Mockery::mock(Stock::class);
        $stockMock->shouldReceive('pullRandomTile')
            ->times(7);

        self::assertEquals(7, $player->pull7Tiles($stockMock));
    }
}
