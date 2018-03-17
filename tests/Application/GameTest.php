<?php

declare(strict_types=1);

use Dominos\Domain\Board;
use Dominos\Domain\Output;
use PHPUnit\Framework\TestCase;
use Dominos\Domain\Player;
use Dominos\Domain\Tile;
use Dominos\Application\Game;
use Dominos\Domain\Stock;

class GameTest extends TestCase
{
    public function testThatGameCanRun(): void
    {
        $tileMock = \Mockery::mock(Tile::class);

        $stockMock = \Mockery::mock(Stock::class);
        $stockMock->shouldReceive('resetAndAdd28Tiles')
            ->once()
            ->andReturnSelf();
        $stockMock->shouldReceive('pullRandomTile')
            ->times(15) // 7 for player1 + 7 for player2 + 1 for board's first tile
            ->andReturn($tileMock);

        $player1Mock = \Mockery::mock(Player::class);
        $player1Mock->shouldReceive('pull7Tiles')
            ->once()
            ->with($stockMock)
            ->andReturn(7);
        $player1Mock->shouldReceive('isThereMatchingTile')
            ->atLeast()
            ->once()
            ->andReturn($tileMock);
        $player1Mock->shouldReceive('pullTile')
            ->atLeast()
            ->once();

        $player2Mock = \Mockery::mock(Player::class);
        $player2Mock->shouldReceive('pull7Tiles')
            ->once()
            ->with($stockMock)
            ->andReturn(7);
        $player2Mock->shouldReceive('isThereMatchingTile')
            ->atLeast()
            ->once()
            ->andReturn($tileMock);
        $player2Mock->shouldReceive('pullTile')
            ->atLeast()
            ->once();

        $boardMock = \Mockery::mock(Board::class);
        $boardMock->shouldReceive('addTile')
            ->once();
        $boardMock->shouldReceive('getLeadingNumber')
            ->atLeast()
            ->once();
        $boardMock->shouldReceive('getTrailingNumber')
            ->atLeast()
            ->once();

        $outputMock = \Mockery::mock(Output::class);
        $outputMock->shouldReceive('println')
            ->atLeast()
            ->once();

        $game = new Game($stockMock, $player1Mock, $player2Mock, $boardMock, $outputMock);

        self::assertNull($game->run());
    }
}
