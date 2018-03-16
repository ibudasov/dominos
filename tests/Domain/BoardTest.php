<?php

declare(strict_types=1);

use Dominos\Domain\Board;
use Dominos\Domain\Tile;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testThatATileCanBeAddedToTheBoard(): void
    {
        $board = new Board();

        $tileMock = \Mockery::mock(Tile::class);
        $tileMock->shouldReceive('getFirstValue')
            ->once()
            ->andReturn(6);
        $tileMock->shouldReceive('getSecondValue')
            ->once()
            ->andReturn(5);

        self::assertEquals(1, $board->addTile($tileMock));
    }

    public function testThatLeadingAndTrailingNumbersCanBeRetrieved(): void
    {
        $board = new Board();

        $tileMock = \Mockery::mock(Tile::class);
        $tileMock->shouldReceive('getFirstValue')
            ->once()
            ->andReturn(4);
        $tileMock->shouldReceive('getSecondValue')
            ->once()
            ->andReturn(3);

        $tileMock2 = \Mockery::mock(Tile::class);
        $tileMock2->shouldReceive('getFirstValue')
            ->once()
            ->andReturn(5);
        $tileMock2->shouldReceive('getSecondValue')
            ->once()
            ->andReturn(4);

        $tileMock3 = \Mockery::mock(Tile::class);
        $tileMock3->shouldReceive('getFirstValue')
            ->once()
            ->andReturn(3);
        $tileMock3->shouldReceive('getSecondValue')
            ->once()
            ->andReturn(6);

        $board->addTile($tileMock);
        $board->addTile($tileMock2);
        $board->addTile($tileMock3);

        self::assertEquals(5, $board->getLeadingNumber());
        self::assertEquals(6, $board->getTrailingNumber());
    }

    public function testThatBoardCanBePrinted(): void
    {
        $board = new Board();

        $board->addTile(new Tile(6, 5));

        self::assertEquals('<6:5> ', (string) $board);
    }
}

