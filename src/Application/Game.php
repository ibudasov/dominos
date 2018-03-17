<?php

declare(strict_types=1);

namespace Dominos\Application;

use Dominos\Domain\Board;
use Dominos\Domain\Output;
use Dominos\Domain\Player;
use Dominos\Domain\PlayerIsOutOfTilesException;
use Dominos\Domain\Stock;
use Dominos\Domain\Tile;

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

    /**
     * @param Stock  $stock
     * @param Player $player1
     * @param Player $player2
     * @param Board  $board
     * @param Output $output
     */
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
        $this->stock->resetAndAdd28Tiles();

        $this->player1->pull7Tiles($this->stock);

        $this->player2->pull7Tiles($this->stock);

        $firstTile = $this->stock->pullRandomTile();

        $this->board->addTile($firstTile);

        $this->output->println('Game starting with first tile: '.$firstTile);

        try {
            for ($i = 0; $i < 28 - 7 - 7 - 1; ++$i) {
                $activePlayer = $this->determineActiveUser($i);

                $tile = $activePlayer->isThereMatchingTile($this->board);
                if ($tile instanceof Tile) {
                    $this->board->addTile($tile);
                    $this->output->println($activePlayer.' plays tile '.$tile);
                    $this->output->println('Board is now: '.$this->board);
                    continue;
                }

                if (null === $tile) {
                    $pulledTile = $this->stock->pullRandomTile();
                    $activePlayer->pullTile($this->stock->pullRandomTile());
                    $this->output->println($activePlayer.' is pulling tile '.$pulledTile);
                }
            }
        } catch (PlayerIsOutOfTilesException $exception) {
            die($activePlayer.' wins');
        }
    }

    /**
     * @param $i
     *
     * @return Player
     */
    public function determineActiveUser($i): Player
    {
        if (0 === $i % 2) {
            return $this->player1;
        } else {
            return $this->player2;
        }
    }
}
