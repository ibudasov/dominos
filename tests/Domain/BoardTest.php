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

        $board->addTile(new Tile(4, 3));

        self::assertEquals(4, $board->getLeadingNumber(), (string) $board);
        self::assertEquals(3, $board->getTrailingNumber(), (string) $board);

        $board->addTile(new Tile(5, 4));
        self::assertEquals(5, $board->getLeadingNumber(), (string) $board);
        self::assertEquals(3, $board->getTrailingNumber(), (string) $board);

        $board->addTile(new Tile(6, 3));
        self::assertEquals(5, $board->getLeadingNumber(), (string) $board);
        self::assertEquals(6, $board->getTrailingNumber(), (string) $board);

        $board->addTile(new Tile(5, 2));
        self::assertEquals(2, $board->getLeadingNumber(), (string) $board);
        self::assertEquals(6, $board->getTrailingNumber(), (string) $board);
    }

    public function testThatBoardCanBePrinted(): void
    {
        $board = new Board();

        $board->addTile(new Tile(6, 5));

        self::assertEquals('<6:5> ', (string) $board);
    }

    public function testThatTilesAreBeingAddedInProperOrder(): void
    {
        $board = new Board();

        $board->addTile(new Tile(4, 3));
        $board->addTile(new Tile(5, 4));
        $board->addTile(new Tile(3, 6));

        self::assertEquals('<5:4> <4:3> <3:6> ', (string) $board);
    }
}
