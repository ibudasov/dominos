<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Dominos\Domain\Player;
use Dominos\Domain\Tile;
use Dominos\Application\Game;
use Dominos\Domain\Stock;

class GameTest extends TestCase
{
    public function testThatInitiallyEachPlayerCanPull7Tiles(): void
    {
        $tileMock = \Mockery::mock(Tile::class);

        $stockMock = \Mockery::mock(Stock::class);
        $stockMock->shouldReceive('pullRandomTile')
            ->times(14)
            ->andReturn($tileMock);

        $player1Mock = \Mockery::mock(Player::class);
        $player1Mock->shouldReceive('pull7Tiles')
            ->with($stockMock)
            ->andReturn(7);

        $player2Mock = \Mockery::mock(Player::class);
        $player2Mock->shouldReceive('pull7Tiles')
            ->with($stockMock)
            ->andReturn(7);

        $game = new Game($stockMock, $player1Mock, $player2Mock);

        self::assertEquals(7, $game->player1Pulls7Tiles());
        self::assertEquals(7, $game->player2Pulls7Tiles());
    }
}
