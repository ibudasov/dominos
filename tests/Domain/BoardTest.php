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

        self::assertEquals(1, $board->addTile($tileMock));
    }
}
