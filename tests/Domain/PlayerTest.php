<?php

declare(strict_types=1);

use Dominos\Domain\Board;
use Dominos\Domain\PlayerIsOutOfTilesException;
use PHPUnit\Framework\TestCase;
use Dominos\Domain\Player;
use Dominos\Domain\Tile;
use Dominos\Domain\Stock;

class PlayerTest extends TestCase
{
    public function testThatAPlayerCanTakeATile(): void
    {
        $player = new Player('Name');

        $tileMock = \Mockery::mock(Tile::class);
        self::assertEquals(1, $player->pullTile($tileMock));
        self::assertEquals(2, $player->pullTile($tileMock));
    }

    public function testThatUserCanPull7TilesFromStock(): void
    {
        $player = new Player('Name');

        $stockMock = \Mockery::mock(Stock::class);
        $stockMock->shouldReceive('pullRandomTile')
            ->times(7);

        self::assertEquals(7, $player->pull7Tiles($stockMock));
    }

    public function testThatUserCanDecideIsTherePatchingTileInHisOrHerHand(): void
    {
        $player = new Player('Name');

        $boardMock = \Mockery::mock(Board::class);
        $boardMock->shouldReceive('getLeadingNumber')
            ->once()
            ->andReturn(2);
        $boardMock->shouldReceive('getTrailingNumber')
            ->once()
            ->andReturn(1);

        $tileMock = \Mockery::mock(Tile::class);
        $tileMock->shouldReceive('isMatching')
            ->once()
            ->with(1)
            ->andReturn(true);
        $tileMock->shouldReceive('isMatching')
            ->once()
            ->with(2)
            ->andReturn(true);

        $player->pullTile($tileMock);

        self::assertEquals($tileMock, $player->isThereMatchingTile($boardMock));
    }

    public function testThatNullIsReturnedWhenThereIsNoMatchingTileInTheHand(): void
    {
        $player = new Player('Name');

        $tileMock = \Mockery::mock(Tile::class);
        $tileMock->shouldReceive('isMatching')
            ->once()
            ->with(2)
            ->andReturn(false);
        $tileMock->shouldReceive('isMatching')
            ->once()
            ->with(1)
            ->andReturn(false);

        $boardMock = \Mockery::mock(Board::class);
        $boardMock->shouldReceive('getLeadingNumber')
            ->once()
            ->andReturn(2);
        $boardMock->shouldReceive('getTrailingNumber')
            ->once()
            ->andReturn(1);

        $player->pullTile($tileMock);
        self::assertNull($player->isThereMatchingTile($boardMock));
    }

    public function testThatExceptionIsThrownWhenPlayerHasNoTiles(): void
    {
        $this->expectException(PlayerIsOutOfTilesException::class);

        $player = new Player('Name');
        $player->isThereMatchingTile(\Mockery::mock(Board::class));
    }

    public function testThatPlayerHasAName(): void
    {
        $player = new Player('Igor');

        self::assertEquals('Igor', (string) $player);
    }
}
