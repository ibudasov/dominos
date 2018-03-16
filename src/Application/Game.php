<?php

declare(strict_types=1);

namespace Dominos\Application;

use Dominos\Domain\Board;
use Dominos\Domain\Output;
use Dominos\Domain\Player;
use Dominos\Domain\Stock;

class Game
{
    /**
     * @var Stock
     */
    private $stock;
    /**
     * @var Player
     */
    private $player1;
    /**
     * @var Player
     */
    private $player2;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Output
     */
    private $output;

    public function __construct(Stock $stock, Player $player1, Player $player2, Board $board, Output $output)
    {
        $this->stock = $stock;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->board = $board;
        $this->output = $output;
    }

    public function run(): void
    {
        $this->output->println('The game has started');

        $this->stock->resetAndAdd28Tiles();

        $this->player1->pull7Tiles($this->stock);

        $this->player2->pull7Tiles($this->stock);

        $this->board->addTile($this->stock->pullRandomTile());
    }
}
