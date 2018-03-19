<?php

declare(strict_types=1);

namespace Tests\Domain;

use Dominos\Domain\Board;
use Dominos\Domain\GameDomainService;
use Dominos\Domain\Player;
use Dominos\Domain\Stock;
use Dominos\Domain\Tile;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class GameDomainServiceTest extends TestCase
{
    /**
     * @var Tile|MockInterface
     */
    private $tileMock;
    /**
     * @var Player|MockInterface
     */
    private $player1Mock;
    /**
     * @var Player|MockInterface
     */
    private $player2Mock;
    /**
     * @var Board|MockInterface
     */
    private $boardMock;
    /**
     * @var Stock|MockInterface
     */
    private $stockMock;
    /**
     * @var GameDomainService
     */
    private $game;

    protected function setUp(): void
    {
        $this->tileMock = \Mockery::mock(Tile::class);
        $this->stockMock = \Mockery::mock(Stock::class);
        $this->boardMock = \Mockery::mock(Board::class);
        $this->player1Mock = \Mockery::mock(Player::class);
        $this->player2Mock = \Mockery::mock(Player::class);

        $this->game = new GameDomainService($this->stockMock, $this->player1Mock, $this->player2Mock, $this->boardMock);
    }

    public function testThatGameCanBeInit(): void
    {
        $this->stockMock->shouldReceive('resetAndAdd28Tiles')
            ->once()
            ->andReturnSelf();
        $this->stockMock->shouldReceive('pullRandomTile')
            ->times(15) // 7 for player1 + 7 for player2 + 1 for board's first tile
            ->andReturn($this->tileMock);

        $this->player1Mock->shouldReceive('pull7Tiles')
            ->once()
            ->with($this->stockMock)
            ->andReturn(7);
        $this->player1Mock->shouldReceive('pullTile')
            ->atLeast()
            ->once();

        $this->player2Mock->shouldReceive('pull7Tiles')
            ->once()
            ->with($this->stockMock)
            ->andReturn(7);
        $this->player2Mock->shouldReceive('pullTile')
            ->atLeast()
            ->once();

        $this->boardMock->shouldReceive('addTile')
            ->once();

        self::assertInstanceOf(Board::class, $this->game->init());
    }

    public function testThatPlayerCanBeDeterminedWhenStepIsGiven(): void
    {
        self::assertSame($this->player1Mock, $this->game->determineActivePlayer(2));

        self::assertSame($this->player2Mock, $this->game->determineActivePlayer(1));
    }

    public function testThatUserCanMakeItsTurnWhenHasATile(): void
    {
        $this->player1Mock->shouldReceive('isThereMatchingTile')
            ->once()
            ->andReturn($this->tileMock);

        self::assertSame($this->tileMock, $this->game->playerMakesTurn($this->player1Mock));
    }

    public function testThatUserCanMakeItsTurnWhenHasNoTile(): void
    {
        $this->player1Mock->shouldReceive('isThereMatchingTile')
            ->once()
            ->andReturnNull();

        $this->stockMock->shouldReceive('pullRandomTile')
            ->once()
            ->andReturn($this->tileMock);

        $this->player1Mock->shouldReceive('pullTile')
            ->once()
            ->andReturn(1);

        $this->player1Mock->shouldReceive('isThereMatchingTile')
            ->once()
            ->andReturn($this->tileMock);

        self::assertSame($this->tileMock, $this->game->playerMakesTurn($this->player1Mock));
    }

    public function testThatBoardCanBeRetrieved(): void
    {
        self::assertSame($this->boardMock, $this->game->getBoard());
    }

    public function testThatTileCanBeAdded(): void
    {
        $this->boardMock->shouldReceive('addTile')
            ->once()
            ->with($this->tileMock)
            ->andReturn(1);

        self::assertEquals(1, $this->game->addTile($this->tileMock));
    }
}
