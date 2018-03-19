<?php

declare(strict_types=1);

use Dominos\Application\Output;
use Dominos\Domain\Board;
use Dominos\Domain\GameDomainService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Dominos\Domain\Player;
use Dominos\Domain\Tile;
use Dominos\Application\Game;

class GameTest extends TestCase
{
    /**
     * @var GameDomainService|MockInterface
     */
    private $gameService;
    /**
     * @var Output|MockInterface
     */
    private $outputMock;
    /**
     * @var Board|MockInterface
     */
    private $boardMock;
    /**
     * @var Player|MockInterface
     */
    private $playerMock;
    /**
     * @var Tile|MockInterface
     */
    private $tileMock;
    /**
     * @var Game
     */
    private $game;

    protected function setUp(): void
    {
        $this->gameService = \Mockery::mock(GameDomainService::class);
        $this->outputMock = \Mockery::mock(Output::class);
        $this->boardMock = \Mockery::mock(Board::class);
        $this->playerMock = \Mockery::mock(Player::class);
        $this->tileMock = \Mockery::mock(Tile::class);

        $this->game = new Game(
            $this->gameService,
            $this->outputMock
        );
    }

    public function testThatGameCanRun(): void
    {
        $this->gameService->shouldReceive('init')
            ->once()
            ->andReturn($this->boardMock);

        $this->gameService->shouldReceive('determineActivePlayer')
            ->once()
            ->andReturn($this->playerMock);

        $this->gameService->shouldReceive('getBoard')
            ->atLeast()
            ->once()
            ->andReturn($this->boardMock);

        $this->gameService->shouldReceive('playerMakesTurn')
            ->atLeast()
            ->once()
            ->with($this->playerMock)
            ->andReturn($this->tileMock);

        $this->gameService->shouldReceive('addTile')
            ->atLeast()
            ->once()
            ->andReturn(1);

        $this->outputMock->shouldReceive('println')
            ->atLeast()
            ->once();

        self::assertNull($this->game->run());
    }
}
